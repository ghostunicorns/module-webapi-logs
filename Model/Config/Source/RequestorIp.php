<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\WebapiLogs\Model\Config\Source;

use GhostUnicorns\WebapiLogs\Model\ResourceModel\RecentDistinctValues;
use Magento\Framework\Data\OptionSourceInterface;

class RequestorIp implements OptionSourceInterface
{
    /**
     * @var RecentDistinctValues
     */
    private $recentDistinctValues;

    /**
     * @param RecentDistinctValues $recentDistinctValues
     */
    public function __construct(
        RecentDistinctValues $recentDistinctValues
    ) {
        $this->recentDistinctValues = $recentDistinctValues;
    }

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        $result = [];
        foreach ($this->recentDistinctValues->execute('requestor_ip') as $ip) {
            $result[] = [
                'value' => $ip,
                'label' => $ip
            ];
        }
        return $result;
    }
}
