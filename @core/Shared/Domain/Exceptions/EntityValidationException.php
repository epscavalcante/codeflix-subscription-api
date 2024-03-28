<?php

namespace Core\Shared\Domain\Exceptions;

use Exception;

class EntityValidationException extends Exception
{
    public function __construct(
        ?string $message,
        public readonly array|string $error,
    ) {
        parent::__construct($message || 'The Entity was invalid.');
    }

    public function getErrors()
    {
        return [
            is_array($this->error) ? $this->error : [$this->error],
        ];
    }
}
