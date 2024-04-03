<?php

namespace Core\Shared\Domain\Repositories;

use Core\Shared\Domain\Entity;

interface SearchResultInterface
{
    /**
     * @return array<Entity>
     */
    public function items(): array;

    public function total(): int;

    public function page(): int;

    public function perPage(): int;

    public function previousPage(): ?int;

    public function nextPage(): ?int;

    public function firstPage(): int;

    public function lastPage(): int;
}
