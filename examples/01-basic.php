<?php

declare(strict_types=1);

/**
 * Basic example: Get all proxies (first page)
 *
 * Run: php examples/01-basic.php
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Freeproxy\Client;
use Freeproxy\Exception\ApiException;

// Initialize client with API key
$apiKey = getenv('FREEPROXY_API_KEY') or die("Set FREEPROXY_API_KEY environment variable\n");
$client = new Client($apiKey);

try {
    // Get all proxies from the first page
    $proxies = $client->query();

    if (empty($proxies)) {
        echo "No proxies available\n";
        exit(0);
    }

    printf("Found %d proxies:\n\n", count($proxies));

    foreach ($proxies as $proxy) {
        printf("ID:              %s\n", $proxy->id);
        printf("Protocol:        %s\n", $proxy->protocol);
        printf("Address:         %s\n", $proxy->connectionString());
        printf("Location:        %s\n", $proxy->location());
        printf("Uptime:          %d%%\n", $proxy->uptime);
        printf("Response Time:   %.2fs\n", $proxy->responseTime);
        printf("HTTPS Support:   %s\n", $proxy->supportsHttps() ? 'Yes' : 'No');
        printf("Google Access:   %s\n", $proxy->canAccessGoogle() ? 'Yes' : 'No');
        printf("Proxy URL:       %s\n", $proxy->url());
        echo "\n";
    }
} catch (ApiException $e) {
    fprintf(STDERR, "Error: %s (%s)\n", $e->getMessage(), $e->getErrorCode());
    exit(1);
}
