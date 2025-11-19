<?php
declare(strict_types=1);


require __DIR__ . '/../vendor/autoload.php';

use Getfreeproxy\Sdk\Client;
use Getfreeproxy\Sdk\QueryBuilder;

$apiKey = getenv('FREEPROXY_API_KEY') ?: 'your-api-key-here';
$client = new Client($apiKey);

// Simple: get first page
$proxies = $client->query();
echo "Found " . count($proxies) . " proxies on page 1\n";

// Filter by country
$us = $client->queryCountry('US');
echo "US proxies: " . count($us) . "\n";

// Fluent builder: socks5 proxies in US, page 1
$qb = QueryBuilder::create()->country('US')->protocol('socks5')->page(1);
$list = $client->query($qb);
foreach ($list as $p) {
    echo $p->proxyUrl ?? ($p->protocol . '://' . $p->ip . ':' . $p->port) . "\n";
}
