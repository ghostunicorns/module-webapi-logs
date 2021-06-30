<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\WebapiLogs\Model;

use Exception;
use GhostUnicorns\WebapiLogs\Model\ResourceModel\LogResourceModel;
use Psr\Log\LoggerInterface;

class LogHandle
{
    private $lastLog;

    /**
     * @var LogFactory
     */
    private $logFactory;

    /**
     * @var LogResourceModel
     */
    private $logResourceModel;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param LogFactory $logFactory
     * @param LogResourceModel $logResourceModel
     * @param LoggerInterface $logger
     */
    public function __construct(
        LogFactory $logFactory,
        LogResourceModel $logResourceModel,
        LoggerInterface $logger
    ) {
        $this->logFactory = $logFactory;
        $this->logResourceModel = $logResourceModel;
        $this->logger = $logger;
    }

    /**
     * @param string $requestMethod
     * @param string $requestorIp
     * @param string $requestPath
     * @param string $requestHeaders
     * @param string $requestBody
     * @param string $requestDateTime
     */
    public function before(
        string $requestMethod,
        string $requestorIp,
        string $requestPath,
        string $requestHeaders,
        string $requestBody,
        string $requestDateTime
    ) {
        try {
            $newLog = $this->logFactory->create();
            $newLog->setData([
                'request_method' => $requestMethod,
                'requestor_ip' => $requestorIp,
                'request_url' => $requestPath,
                'request_headers' => $requestHeaders,
                'request_body' => $requestBody,
                'request_datetime' => $requestDateTime
            ]);
            $this->logResourceModel->save($newLog);
            $this->lastLog = $newLog;
        } catch (Exception $exception) {
            $this->logger->error(__('Cant complete webapi log save because of error: %1', $exception->getMessage()));
            unset($exception);
        }
    }

    /**
     * @param string $responseCode
     * @param string $resposeBody
     * @param string $responseDateTime
     */
    public function after(
        string $responseCode,
        string $resposeBody,
        string $responseDateTime
    ) {
        if (!$this->lastLog) {
            return;
        }

        try {
            $this->lastLog->setResponseBody($resposeBody);
            $this->lastLog->setResponseCode($responseCode);
            $this->lastLog->setResponseDatetime($responseDateTime);
            $this->logResourceModel->save($this->lastLog);
        } catch (Exception $exception) {
            $this->logger->error(__('Cant complete webapi log save because of error: %1', $exception->getMessage()));
            unset($exception);
        }
    }
}
