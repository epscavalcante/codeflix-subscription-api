<?php

namespace Core\User\Domain\Exceptions;

use Core\Shared\Domain\Exceptions\EntityValidationException;

class UserValidationException extends EntityValidationException
{
    public function __construct(
        protected array|string $errors,
    ) {
        parent::__construct(
            errors: $errors,
            message: 'The User was invalid.',
        );
    }
}
