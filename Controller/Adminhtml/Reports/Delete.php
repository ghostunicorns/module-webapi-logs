<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\WebapiLogs\Controller\Adminhtml\Reports;

use Exception;
use GhostUnicorns\WebapiLogs\Model\Log\Logger;
use GhostUnicorns\WebapiLogs\Model\Clean;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;

class Delete extends Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'GhostUnicorns_WebapiLogs::reports_webapilogs';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var Clean
     */
    private $clean;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param LogCollectionFactory $logCollectionFactory
     * @param Logger $logger
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Clean $clean,
        Logger $logger
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->clean = $clean;
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        try {
            $this->clean->cleanAll();
        } catch (Exception $exception) {
            $this->logger->error(__('Cant delete webapi log because of error: %1', $exception->getMessage()));
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/index', ['_current' => true]);
    }
}
