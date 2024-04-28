<?php

namespace Core\Shared\Domain\Repositories;

use Core\Shared\Domain\Uuid;

interface RepositoryInterface
{
    /**
     * @param  Entity  $entity
     */
    public function create(object $entity): void;

    /**
     * @param  Entity  $entity
     */
    public function update(object $entity): void;

    /**
     * @param  Uuid  $id
     */
    public function delete(object $id): void;

    public function findById(object $id): ?object;

    public function search(
        ?string $filterBy = null,
        ?string $sortBy = null,
        ?string $sortDir = null,
        ?int $page = 1,
        ?int $perPage = 10,
    ): SearchResultInterface;
}
