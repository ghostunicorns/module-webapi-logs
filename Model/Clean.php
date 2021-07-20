<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\WebapiLogs\Model;

use DateTime;
use Exception;
use GhostUnicorns\WebapiLogs\Model\Log\Logger;
use GhostUnicorns\WebapiLogs\Model\ResourceModel\Entity\LogCollectionFactory;
use GhostUnicorns\WebapiLogs\Model\ResourceModel\LogResourceModel;

class Clean
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var LogCollectionFactory
     */
    private $logCollectionFactory;

    /**
     * @var ResourceModel\LogResourceModel
     */
    private $logResourceModel;

    /**
     * @param Config $config
     * @param Logger $logger
     * @param LogCollectionFactory $logCollectionFactory
     * @param LogResourceModel $logResourceModel
     */
    public function __construct(
        Config $config,
        Logger $logger,
        LogCollectionFactory $logCollectionFactory,
        LogResourceModel $logResourceModel
    ) {
        $this->config = $config;
        $this->logger = $logger;
        $this->logCollectionFactory = $logCollectionFactory;
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

        $collection = $this->logCollectionFactory->create();
        $rows = $collection->addFieldToFilter(LogResourceModel::CREATED_AT, ['lt' => $datetime])
            ->getItems();

        $tot = $collection->count();

        /** @var LogResourceModel $row */
        foreach ($rows as $row) {
            $this->logResourceModel->delete($row);
        }

        $this->logger->info(__('End webapi logs clean. Deleted %1 elements.', $tot));
    }
}
