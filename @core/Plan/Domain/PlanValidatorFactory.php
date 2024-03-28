<?php

namespace Core\Plan\Domain;

class PlanValidatorFactory
{
    public static function create()
    {
        return new PlanIlluminateValidator();
    }
}
