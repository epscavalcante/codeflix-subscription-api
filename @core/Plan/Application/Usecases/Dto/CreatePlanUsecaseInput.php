<?php

namespace Core\Plan\Application\Usecases\Dto;

class CreatePlanUsecaseInput
{
    public function __construct(
        public readonly string $name,
        public readonly string $description,
    ) {
    }
}
