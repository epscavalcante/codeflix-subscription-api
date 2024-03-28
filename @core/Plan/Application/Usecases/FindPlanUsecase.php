<?php

namespace Core\Plan\Application\Usecases;

use Core\Plan\Application\Usecases\Dto\FindPlanUsecaseInput;
use Core\Plan\Application\Usecases\Dto\FindPlanUsecaseOutput;
use Core\Plan\Domain\Exceptions\PlanNotFoundException;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;
use Core\Shared\Domain\Uuid;

class FindPlanUsecase
{
    public function __construct(
        private readonly PlanRepositoryInterface $planRepository
    ) {
    }

    public function execute(FindPlanUsecaseInput $input)
    {
        $planId = new Uuid(($input->id));
        $plan = $this->planRepository->findById($planId);

        if (is_null($plan)) {
            throw new PlanNotFoundException($planId);
        }

        return FindPlanUsecaseOutput::build($plan);
    }
}
