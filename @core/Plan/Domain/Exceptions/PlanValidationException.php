<?php

namespace Core\Plan\Domain\Exceptions;

use Core\Shared\Domain\Exceptions\EntityValidationException;

class PlanValidationException extends EntityValidationException
{
    public function __construct(
        protected array|string $errors,
    ) {
        parent::__construct(
            errors: $errors,
            message: 'The Plan was invalid.',
        );
    }
}
