<?php
declare(strict_types=1);

namespace Getfreeproxy\Sdk\Exception;

use RuntimeException;

class ApiException extends RuntimeException
{
    private ?string $apiErrorCode;

    public function __construct(string $message = "API_ERROR", int $code = 0, ?string $apiErrorCode = null)
    {
        parent::__construct($message, $code);
        $this->apiErrorCode = $apiErrorCode;
    }

    public function getApiErrorCode(): ?string
    {
        return $this->apiErrorCode;
    }
}
