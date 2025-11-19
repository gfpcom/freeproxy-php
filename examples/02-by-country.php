<?php

declare(strict_types=1);

/**
 * Example: Filter proxies by country
 *
 * Run: php examples/02-by-country.php
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Freeproxy\Client;
use Freeproxy\Exception\ApiException;

$apiKey = getenv('FREEPROXY_API_KEY') or die("Set FREEPROXY_API_KEY environment variable\n");
$client = new Client($apiKey);

try {
    // Get proxies from United States
    echo "=== Proxies from United States ===\n";
    $usProxies = $client->queryCountry('US');
    printf("Found %d US proxies\n\n", count($usProxies));

    // Get proxies from United Kingdom
    echo "=== Proxies from United Kingdom ===\n";
    $gbProxies = $client->queryCountry('GB');
    printf("Found %d GB proxies\n\n", count($gbProxies));

    // Get proxies from Germany
    echo "=== Proxies from Germany ===\n";
    $deProxies = $client->queryCountry('DE');
    printf("Found %d DE proxies\n", count($deProxies));

    if (!empty($deProxies)) {
        echo "\nFirst German proxy details:\n";
        $proxy = $deProxies[0];
        printf("  - IP: %s:%d\n", $proxy->ip, $proxy->port);
        printf("  - Region: %s\n", $proxy->region);
        printf("  - Anonymity: %s\n", $proxy->anonymity);
    }
} catch (ApiException $e) {
    fprintf(STDERR, "Error: %s (%s)\n", $e->getMessage(), $e->getErrorCode());
    exit(1);
}
