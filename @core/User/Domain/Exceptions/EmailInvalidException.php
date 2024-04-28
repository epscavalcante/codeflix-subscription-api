<?php

namespace Core\User\Domain\Exceptions;

use Exception;

class EmailInvalidException extends Exception
{
    public function __construct()
    {
        $message = 'The email  must be a valid email address.';
        parent::__construct($message);
    }
}
