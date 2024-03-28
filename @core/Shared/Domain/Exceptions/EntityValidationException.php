<?php

namespace Core\Shared\Domain\Exceptions;

use Exception;

class EntityValidationException extends Exception
{
    public function __construct(
        protected array|string $errors,
        string $message = 'The Entity was invalid.',
    ) {
        parent::__construct($message);
    }

    public function getErrors()
    {
        if (is_array($this->errors)) {
            return $this->errors;
        }

        return [$this->errors];
    }
}
