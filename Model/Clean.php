<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\WebapiLogs\Model;

use DateTime;
use Exception;
use Psr\Log\LoggerInterface as Logger;
use GhostUnicorns\WebapiLogs\Model\ResourceModel\LogResourceModel;

class Clean
{
    /**
     * Rows removed per statement: a small write set for the cluster, and no row loaded into PHP
     */
    private const BATCH_SIZE = 1000;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var ResourceModel\LogResourceModel
     */
    private $logResourceModel;

    /**
     * @param Config $config
     * @param Logger $logger
     * @param LogResourceModel $logResourceModel
     */
    public function __construct(
        Config $config,
        Logger $logger,
        LogResourceModel $logResourceModel
    ) {
        $this->config = $config;
        $this->logger = $logger;
        $this->logResourceModel = $logResourceModel;
    }

    /**
     * @throws Exception
     */
    public function execute()
    {
        if (!$this->config->isEnabled()) {
            return;
        }

        $this->logger->info(__('Start webapi logs clean'));
        $hours = $this->config->getCleanOlderThanHours();
        $datetime = new DateTime('-' . $hours . ' hour');

        $connection = $this->logResourceModel->getConnection();
        $sql = sprintf(
            'DELETE FROM %s WHERE %s < ? LIMIT %d',
            $connection->quoteIdentifier($this->logResourceModel->getMainTable()),
            $connection->quoteIdentifier(LogResourceModel::CREATED_AT),
            self::BATCH_SIZE
        );
        $tot = 0;
        do {
            $deleted = $connection->query($sql, [$datetime->format('Y-m-d H:i:s')])->rowCount();
            $tot += $deleted;
        } while ($deleted === self::BATCH_SIZE);

        $this->logger->info(__('End webapi logs clean. Deleted %1 elements.', $tot));
    }
}
