<?php
declare(strict_types=1);

namespace Getfreeproxy\Sdk\Models;

final class Proxy
{
    public function __construct(
        public string $id,
        public string $protocol,
        public string $ip,
        public int $port,
        public ?string $user = null,
        public ?string $passwd = null,
        public ?string $countryCode = null,
        public ?string $region = null,
        public ?string $asnNumber = null,
        public ?string $asnName = null,
        public ?string $anonymity = null,
        public ?int $uptime = null,
        public ?float $responseTime = null,
        public ?string $lastAliveAt = null,
        public ?string $proxyUrl = null,
        public ?bool $https = null,
        public ?bool $google = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            (string)($data['id'] ?? ''),
            (string)($data['protocol'] ?? ''),
            (string)($data['ip'] ?? ''),
            isset($data['port']) ? (int)$data['port'] : 0,
            $data['user'] ?? null,
            $data['passwd'] ?? null,
            $data['countryCode'] ?? null,
            $data['region'] ?? null,
            $data['asnNumber'] ?? null,
            $data['asnName'] ?? null,
            $data['anonymity'] ?? null,
            isset($data['uptime']) ? (int)$data['uptime'] : null,
            isset($data['responseTime']) ? (float)$data['responseTime'] : null,
            $data['lastAliveAt'] ?? null,
            $data['proxyUrl'] ?? null,
            isset($data['https']) ? (bool)$data['https'] : null,
            isset($data['google']) ? (bool)$data['google'] : null,
        );
    }
}
