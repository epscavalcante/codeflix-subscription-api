<?php

namespace Core\Plan\Application\Usecases\Dto;

use Core\Plan\Domain\Plan;

class DeletePlanUsecaseOutput
{
    private function __construct(
        public readonly string $planId,
    ) {
    }

    public static function build(Plan $plan): DeletePlanUsecaseOutput
    {
        return new DeletePlanUsecaseOutput(
            planId: $plan->getId()->getValue(),
        );
    }
}
