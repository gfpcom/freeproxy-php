<?php

declare(strict_types=1);

/**
 * Example: Filter proxies by protocol
 *
 * Run: php examples/03-by-protocol.php
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Freeproxy\Client;
use Freeproxy\Exception\ApiException;

$apiKey = getenv('FREEPROXY_API_KEY') or die("Set FREEPROXY_API_KEY environment variable\n");
$client = new Client($apiKey);

try {
    // Get HTTP proxies
    echo "=== HTTP Proxies ===\n";
    $httpProxies = $client->queryProtocol('http');
    printf("Found %d HTTP proxies\n\n", count($httpProxies));

    // Get HTTPS proxies
    echo "=== HTTPS Proxies ===\n";
    $httpsProxies = $client->queryProtocol('https');
    printf("Found %d HTTPS proxies\n\n", count($httpsProxies));

    // Get SOCKS5 proxies
    echo "=== SOCKS5 Proxies ===\n";
    $socks5Proxies = $client->queryProtocol('socks5');
    printf("Found %d SOCKS5 proxies\n", count($socks5Proxies));

    if (!empty($socks5Proxies)) {
        echo "\nFirst SOCKS5 proxy:\n";
        $proxy = $socks5Proxies[0];
        printf("  - URL: %s\n", $proxy->url());
        printf("  - Uptime: %d%%\n", $proxy->uptime);
        printf("  - Response Time: %.3fs\n", $proxy->responseTime);
    }
} catch (ApiException $e) {
    fprintf(STDERR, "Error: %s (%s)\n", $e->getMessage(), $e->getErrorCode());
    exit(1);
}
