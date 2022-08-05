<?php

declare(strict_types=1);

namespace Webpag\Entities;

class Paginator
{
    /**
     * @var Entity[]
     */
    protected array $items = [];
    protected array $metadata = [];

    public function __construct(array $data)
    {
        foreach ($data['data'] ?? [] as $item) {
            $this->items[] = new Entity($item);
        }
        $this->metadata = $data['meta'] ?? [];
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getMetadata(): array
    {
        return $this->metadata;
    }

    public function currentPage(): ?int
    {
        return $this->metadata['current_page'] ?? null;
    }

    public function total(): ?int
    {
        return $this->metadata['total'] ?? null;
    }

    public function lastPage(): ?int
    {
        return $this->metadata['last_page'] ?? null;
    }

    public function hasNextPage(): bool
    {
        return ($this->currentPage() < $this->lastPage());
    }
}