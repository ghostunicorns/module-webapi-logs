<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\WebapiLogs\Controller\Adminhtml\Reports;

use Exception;
use Psr\Log\LoggerInterface as Logger;
use GhostUnicorns\WebapiLogs\Model\ResourceModel\LogResourceModel;
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
     * Seconds to wait for the table lock before giving up, so a long query on the table cannot queue the log writes
     */
    private const LOCK_WAIT_TIMEOUT = 5;

    /**
     * @var LogResourceModel
     */
    private $logResourceModel;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param LogResourceModel $logResourceModel
     * @param Logger $logger
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        LogResourceModel $logResourceModel,
        Logger $logger
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->logResourceModel = $logResourceModel;
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        try {
            $connection = $this->logResourceModel->getConnection();
            $connection->query('SET SESSION lock_wait_timeout = ' . self::LOCK_WAIT_TIMEOUT);
            $connection->truncateTable($this->logResourceModel->getMainTable());
        } catch (Exception $exception) {
            $this->logger->error(__('Cant delete webapi log because of error: %1', $exception->getMessage()));
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/index', ['_current' => true]);
    }
}
