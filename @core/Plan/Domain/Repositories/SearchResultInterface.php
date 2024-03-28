<?php

namespace Core\Plan\Domain\Repositories;

interface SearchResultInterface
{
    /**
     * @return Array<Plan>
     */
    public function items(): array;
    public function total(): int;
    public function page(): int;
    public function perPage(): int;
    public function previousPage(): int;
    public function nextPage(): int;
    public function firstPage(): int;
    public function lastPage(): int;
}
