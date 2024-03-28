<?php

namespace Core\Plan\Infra\Repositories;

use Core\Plan\Domain\Exceptions\PlanNotFoundException;
use Core\Plan\Domain\Plan;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;
use Core\Plan\Domain\Repositories\SearchResultInterface;
use Core\Shared\Domain\Uuid;
use Exception;
use phpDocumentor\Reflection\Types\Null_;

class MemoryPlanRepository implements PlanRepositoryInterface
{
    /**
     * @var Array<Plan> $items
     */
    private $items = [];
    public function create(Plan $plan): void
    {
        array_push($this->items, $plan);
    }
    public function update(Plan $entity): void
    {
        throw new Exception('Not implemeted');
    }
    public function delete(Uuid $id): void
    {
        throw new Exception('Not implemeted');
    }

    public function findAll(): array
    {
        throw new Exception('not implemented');
    }

    public function findById(Uuid $id): ?Plan
    {
        $plan = null;
        foreach($this->items as $item) {
            if ($item->getId()->getValue() === $id->getValue())
                $plan = $item;
        }

        return $plan;
    }

    public function search(
        ?string $filterBy = null,
        ?string $sortBy = null,
        ?string $sortDir = 'DESC',
        ?int $page = 1,
        ?int $perPage = 10,
    ): SearchResultInterface {
        throw new Exception('Not implemeted');
    }
}
