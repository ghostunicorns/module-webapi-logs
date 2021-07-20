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
     * @param string $requestBody
     * @return string
     */
    public function bodyParser(string $requestBody): string
    {
        $result = $requestBody;
        return $result;
    }

    /**
     * @param string $requestHeaders
     * @return string
     */
    public function headersParser(string $requestHeaders): string
    {
        $result = preg_replace('/Cookie:(.*)/', 'Cookie: ********', $requestHeaders);
        $result = preg_replace('/User-Agent:(.*)/', 'User-Agent: ********', $result);
        $result = preg_replace('/Authorization:(.*)/', 'Authorization: ********', $result);
        return preg_replace('/Host:(.*)/', 'Host: ********', $result);
    }

    /**
     * @return string
     */
    public function ipParser(): string
    {
        return '***.***.***.***';
    }

    /**
     * @param string $requestPath
     * @return string
     */
    public function pathParser(string $requestPath): string
    {
        $segments = parse_url($requestPath);

        if (array_key_exists('path', $segments)) {
            return $segments['path'];
        }

        return $requestPath;
    }
}
