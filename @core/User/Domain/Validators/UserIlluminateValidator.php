<?php

namespace Core\User\Domain\Validators;

use Core\Shared\Domain\IlluminateValidator;

class UserIlluminateValidator extends IlluminateValidator
{
    /**
     * @param  User  $entity
     */
    public function validate(object $entity, array $rules): void
    {
        parent::validate(
            entity: $entity,
            rules: UserRules::RULES
        );
    }
}
