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
     * string
     */
    protected const WEBAPI_LOGS_LOG_SECRET_WORDS = 'webapi_logs/log/secret_words';

    /**
     * string
     */
    protected const WEBAPI_LOGS_LOG_CLEAN_OLDER_THAN_HOURS = 'webapi_logs/log/clean_older_than_hours';

    /**
     * @var string
     */
    protected const WEBAPI_LOGS_LOG_FILTER_REQUEST_PATHS = 'webapi_logs/log/filter_request_paths';

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

    /**
     * @return array
     */
    public function getSecrets(): array
    {
        $secrets = $this->scopeConfig->getValue(
            self::WEBAPI_LOGS_LOG_SECRET_WORDS,
            ScopeInterface::SCOPE_WEBSITE
        );
        return preg_split('/\n|\r\n?/', $secrets);
    }

    /**
     * @return int
     */
    public function getCleanOlderThanHours(): int
    {
        return (int)$this->scopeConfig->getValue(
            self::WEBAPI_LOGS_LOG_CLEAN_OLDER_THAN_HOURS,
            ScopeInterface::SCOPE_WEBSITE
        );
    }

    /**
     * @return array
     */
    public function getFilterRequestPaths(): array
    {
        $value = $this->scopeConfig->getValue(
            self::WEBAPI_LOGS_LOG_FILTER_REQUEST_PATHS,
            ScopeInterface::SCOPE_WEBSITE
        );
        if ($value == null) {
            return [];
        }
        return preg_split('/\n|\r\n?/', $value);
    }
}
