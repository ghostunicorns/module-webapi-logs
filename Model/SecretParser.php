<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\WebapiLogs\Model;

class SecretParser
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @param Config $config
     */
    public function __construct(
        Config $config
    ) {
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function parseIp(): string
    {
        return '***.***.***.***';
    }

    /**
     * @param string $header
     * @return string
     */
    public function parseHeades(string $header): string
    {
        $secrets = $this->config->getSecrets();
        $headers =  implode('|', $secrets);
        return preg_replace('/('.$headers.'):(.*)/', '$1: ********', $header);
    }

    /**
     * @param string $body
     * @return string
     */
    public function parseBody(string $body): string
    {
        $secrets = $this->config->getSecrets();
        foreach ($secrets as $secret) {
            $body = preg_replace('/' . $secret . '(")*:( )*"(.*)"/', $secret . '$1: "********"', $body);
        }
        return $body;
    }
}
