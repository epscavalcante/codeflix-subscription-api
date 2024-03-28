<?php

namespace Core\Plan\Application\Usecases;

use Core\Plan\Application\Usecases\Dto\ListPlanUsecaseInput;
use Core\Plan\Application\Usecases\Dto\ListPlanUsecaseOutput;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;

class ListPlanUsecase
{
    public function __construct(
        private readonly PlanRepositoryInterface $planRepository
    ) {
    }

    public function execute(ListPlanUsecaseInput $input)
    {
        $searchResult = $this->planRepository->search(
            filterBy: $input->filterBy,
            sortBy: $input->sortBy,
            sortDir: $input->sortDir,
            page: $input->page,
            perPage: $input->perPage
        );

        return ListPlanUsecaseOutput::build($searchResult);
    }
}
