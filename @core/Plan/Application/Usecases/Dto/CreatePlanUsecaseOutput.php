<?php

namespace Core\Plan\Application\Usecases\Dto;

use Core\Plan\Domain\Plan;

class CreatePlanUsecaseOutput
{
    private function __construct(
        public readonly string $planId,
        public readonly string $name,
        public readonly string $description,

    ) {
    }

    public static function build(Plan $plan): CreatePlanUsecaseOutput
    {
        return new CreatePlanUsecaseOutput(
            planId: $plan->getId()->getValue(),
            name: $plan->name,
            description: $plan->description
        );
    }
}
