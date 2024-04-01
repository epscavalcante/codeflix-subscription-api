<?php

namespace Core\Plan\Domain\Repositories;

use Core\Plan\Domain\Plan;
use Core\Shared\Domain\Uuid;

interface PlanRepositoryInterface
{
    public function create(Plan $entity): void;

    public function update(Plan $entity): void;

    public function delete(Uuid $id): void;

    public function findById(Uuid $id): ?Plan;

    public function search(
        ?string $filterBy = null,
        ?string $sortBy = null,
        ?string $sortDir = null,
        ?int $page = 1,
        ?int $perPage = 10,
    ): SearchResultInterface;
}
