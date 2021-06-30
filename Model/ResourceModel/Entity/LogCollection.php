<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\WebapiLogs\Model\ResourceModel\Entity;

use GhostUnicorns\WebapiLogs\Model\Log;
use GhostUnicorns\WebapiLogs\Model\ResourceModel\LogResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class LogCollection extends AbstractCollection
{
    protected $_idFieldName = 'log_id';
    protected $_eventPrefix = 'webapi_log_collection';
    protected $_eventObject = 'logs_collection';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Log::class, LogResourceModel::class);
    }
}
