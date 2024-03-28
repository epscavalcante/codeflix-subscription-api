<?php

namespace Core\Plan\Domain;

use Core\Shared\Domain\IlluminateValidator;
use Core\Shared\Domain\Notification;

class PlanIlluminateValidator extends IlluminateValidator
{
    public function validate(Notification $notification, $data, array $rules): bool
    {
        return parent::validate($notification, $data, $rules);
    }
}
