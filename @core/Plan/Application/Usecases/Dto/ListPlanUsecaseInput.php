<?php

namespace Core\Plan\Application\Usecases\Dto;

class ListPlanUsecaseInput
{
    public function __construct(
        public readonly ?string $filterBy,
        public readonly ?string $sortBy,
        public readonly ?string $sortDir,
        public readonly ?int $page,
        public readonly ?int $perPage,
    ) {
    }
}
