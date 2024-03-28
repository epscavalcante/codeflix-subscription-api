<?php

namespace Core\Plan\Application\Usecases\Dto;

class UpdatePlanUsecaseInput
{
    public function __construct(
        public readonly string $planId,
        public readonly ?string $name,
        public readonly ?string $description,
    ) {
    }
}
