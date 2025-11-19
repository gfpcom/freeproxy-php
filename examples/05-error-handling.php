<?php

declare(strict_types=1);

/**
 * Example: Error handling
 *
 * Run: php examples/05-error-handling.php
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Freeproxy\Client;
use Freeproxy\Exception\ApiException;
use Freeproxy\Exception\UnauthorizedException;
use Freeproxy\Exception\InvalidParameterException;

// Test 1: Invalid API Key
echo "=== Test 1: Invalid API Key ===\n";
try {
    $client = new Client('invalid-api-key');
    $proxies = $client->query();
    echo "Unexpected success\n";
} catch (UnauthorizedException $e) {
    printf("Caught UnauthorizedException: %s\n", $e->getMessage());
    printf("Error Code: %s\n\n", $e->getErrorCode());
} catch (ApiException $e) {
    printf("Caught ApiException: %s\n", $e->getMessage());
    printf("Error Code: %s\n\n", $e->getErrorCode());
}

// Test 2: Empty API Key
echo "=== Test 2: Empty API Key ===\n";
try {
    $client = new Client('');
} catch (InvalidParameterException $e) {
    printf("Caught InvalidParameterException: %s\n", $e->getMessage());
    printf("Error Code: %s\n\n", $e->getErrorCode());
}

// Test 3: Valid API key (if provided) - network simulation
echo "=== Test 3: Network Error Handling ===\n";
$apiKey = getenv('FREEPROXY_API_KEY');
if ($apiKey) {
    try {
        $client = new Client($apiKey);
        $proxies = $client->query();
        printf("Successfully retrieved %d proxies\n", count($proxies));
    } catch (ApiException $e) {
        printf("Caught ApiException: %s\n", $e->getMessage());
        printf("Error Code: %s\n", $e->getErrorCode());
    }
} else {
    echo "Skipping - set FREEPROXY_API_KEY to test with valid credentials\n";
}
