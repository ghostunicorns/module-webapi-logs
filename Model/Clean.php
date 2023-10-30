<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\WebapiLogs\Model;

use DateTime;
use Exception;
use GhostUnicorns\WebapiLogs\Model\ResourceModel\LogResourceModel;

class Clean
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var ResourceModel\LogResourceModel
     */
    private $logResourceModel;

    public function __construct(
        Config $config,
        LogResourceModel $logResourceModel
    ) {
        $this->config = $config;
        $this->logResourceModel = $logResourceModel;
    }

    public function cleanAll()
    {
        $this->logResourceModel->getConnection()->truncateTable($this->logResourceModel->getMainTable());
    }

    /**
     * @throws Exception
     */
    public function execute()
    {
        $this->logResourceModel->getConnection()->delete(
            $this->logResourceModel->getMainTable(),
            sprintf(
                '%s < NOW() - INTERVAL %s HOUR',
                LogResourceModel::CREATED_AT,
                (int)$this->config->getCleanOlderThanHours()
            )
        );
    }
}
