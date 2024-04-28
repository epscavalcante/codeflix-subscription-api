<?php

namespace Core\User\Domain\Exceptions;

use Exception;

class CpfInvalidException extends Exception
{
    public function __construct()
    {
        $message = 'The cpf are invalid.';
        parent::__construct($message);
    }
}
