<?php

namespace Core\Plan\Application\Usecases\Dto;

class DeletePlanUsecaseInput
{
    public function __construct(
        public readonly string $id
    ) {
    }
}
