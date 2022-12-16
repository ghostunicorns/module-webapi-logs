<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\WebapiLogs\Model;

use Exception;
use GhostUnicorns\WebapiLogs\Model\Log\Logger;
use GhostUnicorns\WebapiLogs\Model\ResourceModel\LogResourceModel;

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
     * @var Logger
     */
    private $logger;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var SecretParser
     */
    private $secretParser;

    /**
     * @param LogFactory $logFactory
     * @param LogResourceModel $logResourceModel
     * @param SecretParser $secretParser
     * @param Config $config
     * @param Logger $logger
     */
    public function __construct(
        LogFactory $logFactory,
        LogResourceModel $logResourceModel,
        SecretParser $secretParser,
        Config $config,
        Logger $logger
    ) {
        $this->logFactory = $logFactory;
        $this->logResourceModel = $logResourceModel;
        $this->config = $config;
        $this->logger = $logger;
        $this->secretParser = $secretParser;
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
            if ($this->config->isSecretMode()) {
                $requestorIp = $this->secretParser->parseIp();
                $requestHeaders = $this->secretParser->parseHeades($requestHeaders);
                $requestBody = $this->secretParser->parseBody($requestBody);
            }

            $filter = $this->config->getFilterRequestPaths();

            // Only log this request if the path is not filtered.
            if (!$this->filterRequestPath($requestPath, $filter)) {
                $log = $this->logFactory->create();
                $log->setData([
                    'request_method' => $requestMethod,
                    'requestor_ip' => $requestorIp,
                    'request_url' => $requestPath,
                    'request_headers' => $requestHeaders,
                    'request_body' => $requestBody,
                    'request_datetime' => $requestDateTime
                ]);
                $this->logResourceModel->save($log);
                $this->lastLog = $log;
            }
        } catch (Exception $exception) {
            $this->logger->error(__('Cant complete webapi log save because of error: %1', $exception->getMessage()));
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
            if ($this->config->isSecretMode()) {
                $resposeBody = $this->secretParser->parseBody($resposeBody);
            }

            $this->lastLog->setResponseBody($resposeBody);
            $this->lastLog->setResponseCode($responseCode);
            $this->lastLog->setResponseDatetime($responseDateTime);
            $this->logResourceModel->save($this->lastLog);
        } catch (Exception $exception) {
            $this->logger->error(__('Cant complete webapi log save because of error: %1', $exception->getMessage()));
        }
    }

    /**
     * Check if request path is among the filters.
     *
     * @param string $requestPath
     * @param array  $filters
     *
     * @return bool
     */
    private function filterRequestPath(
        string $requestPath,
        array $filters
    ): bool {
        foreach ($filters as $filter) {
            if ($filter != '') {
                if (stripos($requestPath, $filter) !== false) {
                    return true;
                }
            }
        }
        return false;
    }
}
