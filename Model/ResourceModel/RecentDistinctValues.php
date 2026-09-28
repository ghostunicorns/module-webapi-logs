<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\WebapiLogs\Model\ResourceModel;

use InvalidArgumentException;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Select;

class RecentDistinctValues
{
    /**
     * How many of the latest rows the values are read from, so the cost does not grow with the table
     */
    private const RECENT_ROWS = 10000;

    /**
     * Columns whose values feed the grid filters
     */
    private const COLUMNS = ['response_code', 'request_method', 'requestor_ip'];

    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        ResourceConnection $resourceConnection
    ) {
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * Distinct values of a column among the latest rows, sorted
     *
     * @param string $column
     * @return string[]
     */
    public function execute(string $column): array
    {
        if (!in_array($column, self::COLUMNS, true)) {
            throw new InvalidArgumentException(sprintf('Unsupported column "%s"', $column));
        }

        $connection = $this->resourceConnection->getConnection();
        $recent = $connection->select()
            ->from($this->resourceConnection->getTableName('webapi_logs'), [$column])
            ->order(LogResourceModel::LOG_ID . ' ' . Select::SQL_DESC)
            ->limit(self::RECENT_ROWS);
        $select = $connection->select()
            ->distinct()
            ->from(['recent' => $recent], [$column])
            ->order($column);

        return $connection->fetchCol($select);
    }
}
