<?php

namespace Core\Plan\Domain;

use Core\Shared\Domain\IlluminateValidator;

class PlanIlluminateValidator extends IlluminateValidator
{
    /**
     * @param  Plan  $entity
     */
    public function validate(object $entity, array $rules): void
    {
        parent::validate($entity, $rules);
    }
}
