# Freeproxy PHP Client

A small, dependency-free PHP client for the Freeproxy API. Focused on clear, typed models and a fluent QueryBuilder API.

## Requirements
# Freeproxy PHP Client

A small, dependency-free PHP client for the Freeproxy API. Focused on clear, typed models and a fluent QueryBuilder API.

## Requirements

- PHP 8.0+
- cURL extension

## Installation

Install via Composer:

```bash
composer require getfreeproxy/sdk
```

Or include this repository in your project and run `composer dump-autoload`.

## Quick Start

```php
require 'vendor/autoload.php';

use Getfreeproxy\Sdk\Client;

$client = new Client(getenv('FREEPROXY_API_KEY'));
$proxies = $client->query();
foreach ($proxies as $p) {
    echo $p->proxyUrl . PHP_EOL;
}
```

### Querying with filters

```php
use Getfreeproxy\Sdk\QueryBuilder;

$qb = QueryBuilder::create()->country('US')->protocol('https')->page(1);
$proxies = $client->query($qb);
```

## Exceptions

- `Getfreeproxy\Sdk\Exception\ApiException`
- `Getfreeproxy\Sdk\Exception\UnauthorizedException`
- `Getfreeproxy\Sdk\Exception\InvalidParameterException`

These wrap API errors and network problems. Inspect `getApiErrorCode()` on `ApiException` for the provider's error code when available.

## Notes

- The client uses cURL by default and supports a `timeout` option via the constructor.
- The API requires a Bearer token set as the constructor `apiKey` or via `FREEPROXY_API_KEY` environment variable in examples.

## Examples

See the `examples/usage.php` for a quick demonstration.

## License

MIT License - see LICENSE file for details

## Support

For API documentation, visit: https://developer.getfreeproxy.com/docs
