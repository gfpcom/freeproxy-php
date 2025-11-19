<?php
declare(strict_types=1);

namespace Getfreeproxy\Sdk;

final class QueryBuilder
{
    private array $params = [];

    public static function create(): self
    {
        return new self();
    }

    public function country(string $country): self
    {
        $this->params['country'] = $country;
        return $this;
    }

    public function protocol(string $protocol): self
    {
        $this->params['protocol'] = $protocol;
        return $this;
    }

    public function page(int $page): self
    {
        $this->params['page'] = $page;
        return $this;
    }

    public function toArray(): array
    {
        return $this->params;
    }

    public function buildQuery(): string
    {
        return http_build_query($this->params);
    }
}

