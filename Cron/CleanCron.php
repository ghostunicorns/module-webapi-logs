<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\WebapiLogs\Cron;

use Exception;
use GhostUnicorns\WebapiLogs\Model\Clean;

class CleanCron
{
    /**
     * @var Clean
     */
    private $clean;

    /**
     * @param Clean $clean
     */
    public function __construct(
        Clean $clean
    ) {
        $this->clean = $clean;
    }

    /**
     * @throws Exception
     */
    public function execute()
    {
        $this->clean->execute();
    }
}
