<?php

namespace Core\User\Domain\Repositories;

use Core\Shared\Domain\Repositories\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    /**
     * @param  User  $entity
     */
    public function create(object $entity): void;
}
