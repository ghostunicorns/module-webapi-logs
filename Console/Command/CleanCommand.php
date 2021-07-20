<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\WebapiLogs\Console\Command;

use GhostUnicorns\WebapiLogs\Model\Clean;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CleanCommand extends Command
{
    /**
     * @var Clean
     */
    private $clean;

    /**
     * @param Clean $clean
     * @param string $name
     */
    public function __construct(
        Clean $clean,
        string $name = 'webapilogs:clean'
    ) {
        $this->clean = $clean;
        parent::__construct($name);
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setDescription('WebapiLogs Cleaner');
        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->clean->execute();
    }
}
