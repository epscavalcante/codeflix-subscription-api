<?php

namespace Core\Plan\Domain\Repositories;

use Core\Plan\Domain\Plan;

class SearchResult implements SearchResultInterface
{
    public function __construct(
        private readonly array $items,
        private readonly int $total,
        private readonly int $page,
        private readonly int $perPage,
        private readonly int $previousPage,
        private readonly int $nextPage,
        private readonly int $firstPage,
        private readonly int $lastPage,
    ) {
    }

    /**
     * @return array<Plan>
     */
    public function items(): array
    {
        return $this->items;
    }

    public function total(): int
    {
        return $this->total;
    }

    public function page(): int
    {
        return $this->page;
    }

    public function perPage(): int
    {
        return $this->perPage;
    }

    public function previousPage(): int
    {
        return $this->previousPage;
    }

    public function nextPage(): int
    {
        return $this->nextPage;
    }

    public function firstPage(): int
    {
        return $this->firstPage;
    }

    public function lastPage(): int
    {
        return $this->lastPage;
    }
}
