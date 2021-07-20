<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\WebapiLogs\Controller\Adminhtml\Reports;

use Exception;
use GhostUnicorns\WebapiLogs\Model\ResourceModel\Entity\LogCollectionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;
use Psr\Log\LoggerInterface;

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
     * @var LogCollectionFactory
     */
    private $logCollectionFactory;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param LogCollectionFactory $logCollectionFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        LogCollectionFactory $logCollectionFactory,
        LoggerInterface $logger
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->logCollectionFactory = $logCollectionFactory;
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        try {
            $logs = $this->logCollectionFactory->create();
            foreach ($logs as $log) {
                $log->delete();
            }
        } catch (Exception $exception) {
            $this->logger->error(__('Cant delete webapi log because of error: %1', $exception->getMessage()));
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/index', ['_current' => true]);
    }
}
