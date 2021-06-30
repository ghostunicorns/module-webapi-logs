<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\WebapiLogs\Model;

use GhostUnicorns\WebapiLogs\Api\Data\LogInterface;
use GhostUnicorns\WebapiLogs\Model\ResourceModel\LogResourceModel;
use Magento\Framework\Model\AbstractModel;

class Log extends AbstractModel implements LogInterface
{
    protected function _construct()
    {
        $this->_init(LogResourceModel::class);
    }
}
