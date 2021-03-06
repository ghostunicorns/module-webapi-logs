<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\WebapiLogs\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class LogResourceModel extends AbstractDb
{
    /** @var string */
    const CREATED_AT = 'created_at';

    /** @var string */
    const LOG_ID = 'log_id';

    protected function _construct()
    {
        $this->_init('webapi_logs', 'log_id');
    }
}
