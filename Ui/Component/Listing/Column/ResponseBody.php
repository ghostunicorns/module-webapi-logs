<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GhostUnicorns\WebapiLogs\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

class ResponseBody extends Column
{
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item[$this->getData('name')]) && isset($item['response_code'])) {
                    if ((int)$item['response_code'] === 200) {
                        $item[$this->getData('name')] = '';
                    }
                }
            }
        }

        return $dataSource;
    }
}
