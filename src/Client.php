<?php
declare(strict_types=1);

namespace Getfreeproxy\Sdk;

use Getfreeproxy\Sdk\Models\Proxy;
use Getfreeproxy\Sdk\Exception\ApiException;
use Getfreeproxy\Sdk\Exception\UnauthorizedException;
use Getfreeproxy\Sdk\Exception\InvalidParameterException;

final class Client
{
    private string $apiKey;
    private string $baseUrl = 'https://api.getfreeproxy.com/v1/proxies';
    private int $timeout = 30;

    public function __construct(string $apiKey, array $options = [])
    {
        $this->apiKey = $apiKey;
        if (isset($options['timeout'])) {
            $this->timeout = (int)$options['timeout'];
        }
    }

    /**
     * Query proxies.
     *
     * @param QueryBuilder|array|null $query
     * @return Proxy[]
     * @throws ApiException
     */
    public function query(QueryBuilder|array|null $query = null): array
    {
        $params = [];
        if ($query instanceof QueryBuilder) {
            $params = $query->toArray();
        } elseif (is_array($query)) {
            $params = $query;
        }

        $url = $this->baseUrl;
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $headers = [
            'Accept: application/json',
            'Authorization: Bearer ' . $this->apiKey,
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $body = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($body === false) {
            $err = curl_error($ch);
            curl_close($ch);
            throw new ApiException('Network error: ' . $err);
        }

        curl_close($ch);

        $decoded = json_decode($body, true);

        if ($status >= 200 && $status < 300) {
            if (!is_array($decoded)) {
                return [];
            }
            $out = [];
            foreach ($decoded as $item) {
                if (is_array($item)) {
                    $out[] = Proxy::fromArray($item);
                }
            }
            return $out;
        }

        $apiError = is_array($decoded) && isset($decoded['error']) ? (string)$decoded['error'] : null;

        return match ($status) {
            400 => throw new InvalidParameterException($apiError ?? 'INVALID_PARAMETER', $status, $apiError),
            401 => throw new UnauthorizedException($apiError ?? 'UNAUTHORIZED', $status, $apiError),
            default => throw new ApiException($apiError ?? 'API_ERROR', $status, $apiError),
        };
    }

    public function queryCountry(string $country): array
    {
        return $this->query(QueryBuilder::create()->country($country));
    }

    public function queryProtocol(string $protocol): array
    {
        return $this->query(QueryBuilder::create()->protocol($protocol));
    }

    public function queryPage(int $page): array
    {
        return $this->query(QueryBuilder::create()->page($page));
    }
}
