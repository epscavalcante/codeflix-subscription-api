<?php

namespace Core\User\Domain\Validators;

use Core\Shared\Domain\ValidatorContract;

class UserValidatorFactory
{
    public static function create(): ValidatorContract
    {
        return new UserIlluminateValidator();
    }
}
