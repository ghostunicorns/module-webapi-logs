<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\WebapiLogs\Model\Config\Source;

use GhostUnicorns\WebapiLogs\Model\ResourceModel\Entity\LogCollection;
use GhostUnicorns\WebapiLogs\Model\ResourceModel\Entity\LogCollectionFactory;
use Magento\Framework\Data\OptionSourceInterface;

class Methods implements OptionSourceInterface
{
    /**
     * @var LogCollectionFactory
     */
    private $logCollectionFactory;

    /**
     * @param LogCollectionFactory $logCollectionFactory
     */
    public function __construct(
        LogCollectionFactory $logCollectionFactory
    ) {
        $this->logCollectionFactory = $logCollectionFactory;
    }

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        $result = [];
        /** @var LogCollection $logsCollection */
        $logsCollection = $this->logCollectionFactory->create();
        $logsCollection->addFieldToSelect('request_method');
        $logsCollection->distinct(true);
        foreach ($logsCollection as $logs) {
            $result[] = [
                'value' => $logs->getRequestMethod(),
                'label' => $logs->getRequestMethod()
            ];
        }
        return $result;
    }
}
