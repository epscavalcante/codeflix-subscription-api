<?php

namespace Core\Plan\Domain\Repositories;

use Core\Shared\Domain\Repositories\RepositoryInterface;

interface PlanRepositoryInterface extends RepositoryInterface
{
    /**
     * @param  Plan  $entity
     */
    public function create(object $entity): void;
}
