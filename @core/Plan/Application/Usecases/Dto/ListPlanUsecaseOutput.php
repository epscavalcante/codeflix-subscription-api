<?php

namespace Core\Plan\Application\Usecases\Dto;

use Core\Plan\Domain\Plan;
use Core\Plan\Domain\Repositories\PlanSearchResult as SearchResult;
use stdClass;

class ListPlanUsecaseOutput
{
    private function __construct(
        public readonly array $items,
        public readonly int $total,
        public readonly int $page,
        public readonly int $perPage,
        public readonly ?int $previousPage,
        public readonly ?int $nextPage,
        public readonly int $firstPage,
        public readonly int $lastPage,
    ) {
    }

    public static function build(SearchResult $searchResult): ListPlanUsecaseOutput
    {
        return new ListPlanUsecaseOutput(
            items: array_map(
                callback: function (Plan $plan) {
                    $planOutput = new stdClass;
                    $planOutput->planId = $plan->getId()->getValue();
                    $planOutput->name = $plan->name;
                    $planOutput->description = $plan->description;

                    return $planOutput;
                },
                array: $searchResult->items()
            ),
            total: $searchResult->total(),
            page: $searchResult->page(),
            perPage: $searchResult->perPage(),
            previousPage: $searchResult->previousPage(),
            nextPage: $searchResult->nextPage(),
            firstPage: $searchResult->firstPage(),
            lastPage: $searchResult->lastPage(),
        );
    }
}
