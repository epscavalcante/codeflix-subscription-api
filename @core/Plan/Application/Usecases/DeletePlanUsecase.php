<?php

namespace Core\Plan\Application\Usecases;

use Core\Plan\Application\Usecases\Dto\DeletePlanUsecaseInput;
use Core\Plan\Application\Usecases\Dto\DeletePlanUsecaseOutput;
use Core\Plan\Domain\Exceptions\PlanNotFoundException;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;
use Core\Shared\Domain\Uuid;

class DeletePlanUsecase
{
    public function __construct(
        private readonly PlanRepositoryInterface $planRepository
    ) {
    }

    public function execute(DeletePlanUsecaseInput $input)
    {
        $planId = new Uuid(($input->id));
        $plan = $this->planRepository->findById($planId);

        if (is_null($plan)) {
            throw new PlanNotFoundException($planId);
        }

        $this->planRepository->delete($plan->getId());

        // futuramente tratar quando plan estiver vinculados a outras entities

        return DeletePlanUsecaseOutput::build($plan);
    }
}
