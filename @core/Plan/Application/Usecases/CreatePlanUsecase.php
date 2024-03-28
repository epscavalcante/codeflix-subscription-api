<?php

namespace Core\Plan\Application\Usecases;

use Core\Plan\Application\Usecases\Dto\CreatePlanUsecaseInput;
use Core\Plan\Application\Usecases\Dto\CreatePlanUsecaseOutput;
use Core\Plan\Domain\Plan;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;

class CreatePlanUsecase
{
    public function __construct(
        private readonly PlanRepositoryInterface $planRepository
    ) {
    }

    public function execute(CreatePlanUsecaseInput $input)
    {
        $plan = new Plan(
            name: $input->name,
            description: $input->description
        );

        $this->planRepository->create($plan);

        return CreatePlanUsecaseOutput::build($plan);
    }
}
