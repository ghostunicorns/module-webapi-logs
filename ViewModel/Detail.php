<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\WebapiLogs\ViewModel;

use GhostUnicorns\WebapiLogs\Model\LogFactory;
use GhostUnicorns\WebapiLogs\Model\ResourceModel\LogResourceModel;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\ScopeInterface;

class Detail implements ArgumentInterface
{
    /**
     * @var LogResourceModel
     */
    private $logResourceModel;

    /**
     * @var LogFactory
     */
    private $logFactory;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @param LogResourceModel $logResourceModel
     * @param LogFactory $logFactory
     * @param RequestInterface $request
     */
    public function __construct(
        LogResourceModel $logResourceModel,
        LogFactory $logFactory,
        RequestInterface $request
    ) {
        $this->logResourceModel = $logResourceModel;
        $this->logFactory = $logFactory;
        $this->request = $request;
    }

    public function getLog()
    {
        $logId = $this->request->getParam('log_id');

        $log = $this->logFactory->create();
        $this->logResourceModel->load($log, $logId);

        return $log;
    }
}
