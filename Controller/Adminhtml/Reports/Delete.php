<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\WebapiLogs\Controller\Adminhtml\Reports;

use GhostUnicorns\WebapiLogs\Model\ResourceModel\Entity\LogCollectionFactory;
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
     * @var bool|PageFactory
     */
    protected $resultPageFactory = false;

    /**
     * @var LogCollectionFactory
     */
    private $logCollectionFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param LogCollectionFactory $logCollectionFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        LogCollectionFactory $logCollectionFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->logCollectionFactory = $logCollectionFactory;
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
        } catch (\Exception $exception) {
            unset($exception);
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/index', ['_current' => true]);
    }
}
