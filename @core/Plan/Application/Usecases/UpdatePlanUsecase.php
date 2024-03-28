<?php

namespace Core\Plan\Application\Usecases;

use Core\Plan\Application\Usecases\Dto\UpdatePlanUsecaseInput;
use Core\Plan\Application\Usecases\Dto\UpdatePlanUsecaseOutput;
use Core\Plan\Domain\Exceptions\PlanNotFoundException;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;
use Core\Shared\Domain\Uuid;

class UpdatePlanUsecase
{
    public function __construct(
        private readonly PlanRepositoryInterface $planRepository
    ) {
    }

    public function execute(UpdatePlanUsecaseInput $input)
    {
        $planId = new Uuid($input->planId);
        $plan = $this->planRepository->findById($planId);

        if (is_null($plan)) {
            throw new PlanNotFoundException($planId);
        }

        if ($input->name) {
            $plan->changeName($input->name);
        }

        if ($input->description) {
            $plan->changeDescription($input->description);
        }

        $this->planRepository->update($plan);

        return UpdatePlanUsecaseOutput::build($plan);
    }
}
