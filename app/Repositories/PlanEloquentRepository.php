<?php

namespace App\Repositories;

use App\Models\Plan as PlanModel;
use App\Repositories\Mappers\PlanEloquentRepositoryMapper;
use Core\Plan\Domain\Exceptions\PlanNotFoundException;
use Core\Plan\Domain\Plan;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;
use Core\Plan\Domain\Repositories\PlanSearchResult;
use Core\Plan\Domain\Repositories\PlanSearchResultInterface;
use Core\Shared\Domain\Uuid;

class PlanEloquentRepository implements PlanRepositoryInterface
{
    public function __construct(
        private readonly PlanModel $model
    ) {
    }

    /**
     * @param  Plan  $plan
     */
    public function create(object $plan): void
    {
        $modelProps = PlanEloquentRepositoryMapper::toModel($plan);

        $this->model->create($modelProps->toArray());
    }

    /**
     * @param  Plan  $plan
     */
    public function update(object $plan): void
    {
        $planModel = $this->model->find($plan->getId());

        if (! $planModel) {
            throw new PlanNotFoundException($plan->getId());
        }

        $modelProps = PlanEloquentRepositoryMapper::toModel($plan);

        $planModel->update($modelProps->toArray());
    }

    /**
     * @param  Uuid  $id
     */
    public function delete(object $id): void
    {
        $planModel = $this->model->find($id);

        if (! $planModel) {
            throw new PlanNotFoundException($id);
        }

        $planModel->delete();
    }

    /**
     * @param  Uuid  $id
     */
    public function findById(object $id): ?Plan
    {
        $planModel = $this->model->find($id);

        if ($planModel) {
            return PlanEloquentRepositoryMapper::toEntity($planModel);
        }

        return null;
    }

    public function search(
        ?string $filterBy = null,
        ?string $sortBy = 'name',
        ?string $sortDir = null,
        ?int $page = 1,
        ?int $perPage = 10,
    ): PlanSearchResult {

        $result = $this->model::query()
            //implements a filter using laravel scout
            ->orderBy($sortBy, $sortDir ?? 'DESC')
            ->paginate(
                perPage: $perPage,
                page: $page
            );

        return new PlanSearchResult(
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
