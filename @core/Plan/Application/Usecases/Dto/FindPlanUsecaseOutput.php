<?php

namespace Core\Plan\Application\Usecases\Dto;

use Core\Plan\Domain\Plan;

class FindPlanUsecaseOutput
{
    private function __construct(
        public readonly string $planId,
        public readonly string $name,
        public readonly string $description,

    ) {
    }

    static function build(Plan $plan): self
    {
        return new FindPlanUsecaseOutput(
            planId: $plan->getId()->getValue(),
            name: $plan->name,
            description: $plan->description
        );
    }
}
