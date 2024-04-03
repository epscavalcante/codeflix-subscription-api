<?php

namespace Core\User\Domain\Exceptions;

use Core\User\Domain\ValueObjects\Name;
use Exception;

class NameInvalidException extends Exception
{
    public function __construct()
    {
        $minLength = Name::NAME_MIN_LENGTH;
        $maxLength = Name::NAME_MAX_LENGTH;
        $message = "The name must be min {$minLength} and max {$maxLength} characters.";
        parent::__construct($message);
    }
}
