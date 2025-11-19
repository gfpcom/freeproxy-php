<?php

declare(strict_types=1);

/**
 * Example: Advanced filtering with QueryBuilder
 *
 * Run: php examples/04-advanced-query.php
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Freeproxy\Client;
use Freeproxy\QueryBuilder;
use Freeproxy\Exception\ApiException;

$apiKey = getenv('FREEPROXY_API_KEY') or die("Set FREEPROXY_API_KEY environment variable\n");
$client = new Client($apiKey);

try {
    // Query with multiple filters
    echo "=== US HTTPS Proxies ===\n";
    $query = (new QueryBuilder())
        ->country('US')
        ->protocol('https');

    $proxies = $client->query($query);
    printf("Found %d US HTTPS proxies\n", count($proxies));

    // Query specific page
    echo "\n=== Page 2 of proxies ===\n";
    $page2Query = (new QueryBuilder())->page(2);
    $page2Proxies = $client->query($page2Query);
    printf("Found %d proxies on page 2\n", count($page2Proxies));

    // Complex query: US, SOCKS5, Page 1
    echo "\n=== US SOCKS5 Proxies (Page 1) ===\n";
    $complexQuery = (new QueryBuilder())
        ->country('US')
        ->protocol('socks5')
        ->page(1);

    $complexProxies = $client->query($complexQuery);
    printf("Found %d proxies matching complex filter\n", count($complexProxies));

    if (!empty($complexProxies)) {
        echo "\nFirst result:\n";
        $p = $complexProxies[0];
        printf("  - ID: %s\n", $p->id);
        printf("  - Address: %s\n", $p->connectionString());
        printf("  - Anonymity: %s\n", $p->anonymity);
        printf("  - Last Alive: %s\n", $p->lastAliveAt->format('Y-m-d H:i:s'));
    }
} catch (ApiException $e) {
    fprintf(STDERR, "Error: %s (%s)\n", $e->getMessage(), $e->getErrorCode());
    exit(1);
}
