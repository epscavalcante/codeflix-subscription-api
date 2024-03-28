<?php

namespace Core\Plan\Application\Usecases\Dto;

class FindPlanUsecaseInput
{
    public function __construct(
        public readonly string $id
    ) {
    }
}
