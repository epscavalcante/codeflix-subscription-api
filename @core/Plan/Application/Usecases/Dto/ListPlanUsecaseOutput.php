<?php

namespace Core\Plan\Application\Usecases\Dto;

use Core\Plan\Domain\Plan;
use Core\Plan\Domain\Repositories\SearchResult;

class ListPlanUsecaseOutput
{
    private function __construct(
        public readonly array $items,
        public readonly int $total,
        public readonly int $page,
        public readonly int $perPage,
        public readonly int $previousPage,
        public readonly int $nextPage,
        public readonly int $firstPage,
        public readonly int $lastPage,
    ) {
    }

    public static function build(SearchResult $searchResult): ListPlanUsecaseOutput
    {
        $items = array_map(fn ($plan) => self::buildItemPlan($plan), $searchResult->items());

        return new ListPlanUsecaseOutput(
            items: $items,
            total: $searchResult->total(),
            page: $searchResult->page(),
            perPage: $searchResult->perPage(),
            previousPage: $searchResult->previousPage(),
            nextPage: $searchResult->nextPage(),
            firstPage: $searchResult->firstPage(),
            lastPage: $searchResult->lastPage(),
        );
    }

    private static function buildItemPlan(Plan $plan): array
    {
        return [
            'planId' => $plan->getId(),
            'name' => $plan->name,
            'description' => $plan->description,
        ];
    }
}
