<?php

namespace App\Repositories;

use Core\Plan\Domain\Plan;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;
use Core\Plan\Domain\Repositories\SearchResultInterface;
use App\Models\Plan as PlanModel;
use App\Repositories\Mappers\PlanEloquentRepositoryMapper;
use Core\Plan\Domain\Exceptions\PlanNotFoundException;
use Core\Plan\Domain\Repositories\SearchResult;
use Core\Shared\Domain\Uuid;

class PlanEloquentRepository implements PlanRepositoryInterface
{
    public function __construct(
        private readonly PlanModel $model
    ) {
    }

    public function create(Plan $plan): void
    {
        $modelProps = PlanEloquentRepositoryMapper::toModel($plan);

        $this->model->create($modelProps->toArray());
    }

    public function update(Plan $plan): void
    {
        $planModel = $this->model->find($plan->getId());

        if (!$planModel) throw new PlanNotFoundException($plan->getId());

        $modelProps = PlanEloquentRepositoryMapper::toModel($plan);

        $planModel->update($modelProps->toArray());
    }

    public function delete(Uuid $planId): void
    {
        $planModel = $this->model->find($planId);

        if (!$planModel) throw new PlanNotFoundException($planId);

        $planModel->delete();
    }

    public function findById(Uuid $planId): ?Plan
    {
        $planModel = $this->model->find($planId);

        if ($planModel)
            return PlanEloquentRepositoryMapper::toEntity($planModel);

        return null;
    }

    public function search(
        ?string $filterBy,
        ?string $sortBy = 'name',
        ?string $sortDir,
        ?int $page = 1,
        ?int $perPage = 10,
    ): SearchResultInterface {

        $result = $this->model::query()
            //implements a filter using laravel scout
            ->orderBy($sortBy, $sortDir ?? 'DESC')
            ->paginate(
                perPage: $perPage,
                page: $page
            );

        return new SearchResult(
            items: array_map(fn ($planModel) => (PlanEloquentRepositoryMapper::toEntity($planModel)), $result->items()),
            total: $result->total(),
            page: $result->currentPage(),
            perPage: $result->perPage(),

            previousPage: $result->currentPage() > 1
                ? $result->currentPage() - 1
                : null,
            nextPage: $result->currentPage() < $result->lastPage()
                ? $result->currentPage() + 1
                : null,
            firstPage: 1,
            lastPage: $result->lastPage()
        );
    }
}
