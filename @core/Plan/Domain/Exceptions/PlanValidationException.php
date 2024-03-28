<?php

namespace Core\Plan\Domain\Exceptions;

use Core\Shared\Domain\Exceptions\EntityValidationException;

class PlanValidationException extends EntityValidationException
{
    public function __construct(
        public readonly array $errors,
    ) {
        parent::__construct(
            message: 'The Plan was invalid.',
            error: $errors
        );
    }
}
