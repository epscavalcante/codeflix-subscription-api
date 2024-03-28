<?php

use Core\Plan\Application\Usecases\CreatePlanUsecase;
use Core\Plan\Application\Usecases\Dto\CreatePlanUsecaseInput;
use Core\Plan\Application\Usecases\Dto\CreatePlanUsecaseOutput;
use Core\Plan\Domain\Exceptions\PlanValidationException;
use Core\Plan\Domain\Plan;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;

describe('CreatePlanUsecase Unit Test', function () {
    test('Deve criar um plano', function () {
        $input = new CreatePlanUsecaseInput(
            name: 'test',
            description: 'Alguma descricao'
        );
        $plan = new Plan(
            name: $input->name,
            description: $input->description
        );
        $planRepository = Mockery::mock(PlanRepositoryInterface::class);
        $planRepository->shouldReceive('create')
            ->once()
            ->andReturn($plan);
        $usecase = new CreatePlanUsecase(
            planRepository: $planRepository
        );
        $output = $usecase->execute($input);
        expect($output)->toBeInstanceOf(CreatePlanUsecaseOutput::class);
        expect($output->planId)->not->toBeNull();
        expect($output->name)->toBe('test');
        expect($output->description)->toBe('Alguma descricao');
    });

    test('Deve lançar exception PlanValidationException ao criar um plano com dados inválidos', function () {
        $input = new CreatePlanUsecaseInput(
            name: str_repeat('a', 256),
            description: 'Alguma descricao'
        );
        $plan = new Plan(
            name: $input->name,
            description: $input->description
        );
        $planRepository = Mockery::mock(PlanRepositoryInterface::class);
        $planRepository->shouldReceive('create')
            ->once()
            ->andReturn($plan);
        $usecase = new CreatePlanUsecase(
            planRepository: $planRepository
        );
        $output = $usecase->execute($input);
    })->throws(PlanValidationException::class);
});
