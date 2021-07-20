<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\WebapiLogs\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    /**
     * string
     */
    protected const WEBAPI_LOGS_IS_ENABLED_CONFIG_PATH = 'webapi_logs/log/enabled';
    /**
     * string
     */
    protected const WEBAPI_LOGS_LOG_SECRET_MODE = 'webapi_logs/log/secret_mode';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::WEBAPI_LOGS_IS_ENABLED_CONFIG_PATH,
            ScopeInterface::SCOPE_WEBSITE
        );
    }

    /**
     * @return bool
     */
    public function isSecretMode(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::WEBAPI_LOGS_LOG_SECRET_MODE,
            ScopeInterface::SCOPE_WEBSITE
        );
    }
}
