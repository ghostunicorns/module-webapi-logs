<?php

namespace GhostUnicorns\WebapiLogs\Ui\Component\Listing\Column;

use IntlDateFormatter;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Locale\Bundle\DataBundle;
use Magento\Framework\Locale\ResolverInterface;
use Magento\Framework\Stdlib\BooleanUtils;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use ResourceBundle;

class ResponseBody extends Column
{
    /**
     * @inheritdoc
     */
    public function prepareDataSource(array $dataSource)
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
