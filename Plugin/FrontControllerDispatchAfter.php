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

class FrontControllerDispatchAfter
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
     * @param $result
     * @param RequestInterface $request
     * @return mixed
     */
    public function afterDispatch(Rest $subject, $result, RequestInterface $request)
    {
        if ($this->config->isEnabled() && !$request->isXmlHttpRequest()) {
            $exceptions = $result->getException();

            if (!empty($exceptions)) {
                $responseCode = '';
                $resposeBody = '';
                foreach ($exceptions as $exception) {
                    $responseCode .= (string)$exception->getHttpCode() . ' ';
                    $resposeBody .= $exception->getMessage() . ' ';
                }
                $responseCode = rtrim($responseCode);
                $resposeBody = rtrim($resposeBody);
            } else {
                $responseCode = (string)$result->getStatusCode();
                $resposeBody = $result->getContent();
                $resposeBody = trim($resposeBody, '"');
            }

            $responseDateTime = $this->date->gmtDate();
            $this->logHandle->after($responseCode, $resposeBody, $responseDateTime);
        }
        return $result;
    }
}
