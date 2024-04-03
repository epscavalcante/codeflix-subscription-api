<?php

namespace Core\Shared\Domain;

interface ValidatorContract
{
    /**
     * @param  Entity  $entity
     */
    public function validate(
        object $entity,
        array $rules
    );
}
