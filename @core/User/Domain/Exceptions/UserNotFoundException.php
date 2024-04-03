<?php

namespace Core\User\Domain\Exceptions;

use Core\Shared\Domain\Exceptions\EntityNotFoundException;
use Core\Shared\Domain\Uuid;
use Core\User\Domain\User;

class UserNotFoundException extends EntityNotFoundException
{
    public function __construct(Uuid $userId)
    {
        parent::__construct(User::class, $userId);
    }
}
