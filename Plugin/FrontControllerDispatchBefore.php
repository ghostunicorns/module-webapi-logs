<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\WebapiLogs\Plugin;

use GhostUnicorns\WebapiLogs\Model\Config;
use GhostUnicorns\WebapiLogs\Model\LogHandle;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Webapi\Controller\Rest;

class FrontControllerDispatchBefore
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var DateTime
     */
    private $date;

    /**
     * @var LogHandle
     */
    private $logHandle;

    /**
     * @param Config $config
     * @param DateTime $date
     * @param LogHandle $logHandle
     */
    public function __construct(
        Config $config,
        DateTime $date,
        LogHandle $logHandle
    ) {
        $this->config = $config;
        $this->date = $date;
        $this->logHandle = $logHandle;
    }

    /**
     * @param Rest $subject
     * @param RequestInterface $request
     * @return array
     */
    public function beforeDispatch(Rest $subject, RequestInterface $request)
    {
        if ($this->config->isEnabled()
            && (
                !$request->isXmlHttpRequest()
                || !$this->config->isAjaxCallsDisabled()
            )
        ) {
            $requestMethod = $request->getMethod();
            $requestorIp = $request->getClientIp();
            $requestPath = $request->getUriString();
            $requestHeaders = $request->getHeaders()->toString();
            $requestBody = $request->getContent();
            $requestDateTime = $this->date->gmtDate();

            $this->logHandle->before(
                $requestMethod,
                $requestorIp,
                $requestPath,
                $requestHeaders,
                $requestBody,
                $requestDateTime
            );
        }
        return [$request];
    }
}
