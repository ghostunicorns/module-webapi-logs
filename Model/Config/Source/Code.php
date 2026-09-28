<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\WebapiLogs\Model\Config\Source;

use GhostUnicorns\WebapiLogs\Model\ResourceModel\RecentDistinctValues;
use Magento\Framework\Data\OptionSourceInterface;

class Code implements OptionSourceInterface
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
        foreach ($this->recentDistinctValues->execute('response_code') as $code) {
            $result[] = [
                'value' => $code,
                'label' => $code
            ];
        }
        return $result;
    }
}
