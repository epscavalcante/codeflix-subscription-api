<?php

namespace Core\User\Domain\Exceptions;

use Exception;

class BirthdateInvalidException extends Exception
{
    public function __construct()
    {
        $message = 'The birthdate are invalid.';
        parent::__construct($message);
    }
}
