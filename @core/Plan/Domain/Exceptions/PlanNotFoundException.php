<?php

namespace Core\Plan\Domain\Exceptions;

use Core\Plan\Domain\Plan;
use Core\Shared\Domain\Exceptions\EntityNotFoundException;
use Core\Shared\Domain\Uuid;

class PlanNotFoundException extends EntityNotFoundException
{
    public function __construct(Uuid $planId)
    {
        parent::__construct(Plan::class, $planId);
    }
}
