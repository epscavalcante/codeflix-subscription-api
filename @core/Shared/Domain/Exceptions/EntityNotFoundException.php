<?php

namespace Core\Shared\Domain\Exceptions;

use Core\Shared\Domain\Uuid;
use Exception;

class EntityNotFoundException extends Exception
{
    public function __construct($namespace, Uuid $id)
    {
        $paths = explode('\\', $namespace);
        $className = end($paths);
        $message = "The {$className} ({$id->getValue()}) not found.";
        parent::__construct($message);
    }
}
