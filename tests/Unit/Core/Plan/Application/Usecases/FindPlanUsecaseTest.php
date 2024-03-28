<?php

use Core\Plan\Application\Usecases\Dto\FindPlanUsecaseInput;
use Core\Plan\Application\Usecases\Dto\FindPlanUsecaseOutput;
use Core\Plan\Application\Usecases\FindPlanUsecase;
use Core\Plan\Domain\Exceptions\PlanNotFoundException;
use Core\Plan\Domain\Plan;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;
use Core\Plan\Infra\Repositories\MemoryPlanRepository;
use Core\Shared\Domain\Uuid;

describe('FindPlanUsecase Unit Test', function () {
    test('Deve encontrar um plano', function () {
        $plan = new Plan(name: 'test', description: 'Alguma descricao');
        $planRepository = new MemoryPlanRepository();
        $planRepository->create($plan);
        $usecase = new FindPlanUsecase(
            planRepository: $planRepository
        );
        $input = new FindPlanUsecaseInput(
            id: $plan->getId()->getValue()
        );
        $output = $usecase->execute($input);
        expect($output)->toBeInstanceOf(FindPlanUsecaseOutput::class);
        expect($output->planId)->toBe($plan->getId()->getValue());
        expect($output->name)->toBe('test');
        expect($output->description)->toBe('Alguma descricao');
    });

    test('Deve lançar PlanNotFoundException quando não encontrar um plano', function () {
        $planRepository = new MemoryPlanRepository();
        $usecase = new FindPlanUsecase(
            planRepository: $planRepository
        );
        $input = new FindPlanUsecaseInput(
            id: Uuid::create()->getValue()
        );
        $usecase->execute($input);
    })->throws(PlanNotFoundException::class);

    test('Deve encontrar um plano usando mock', function () {
        $plan = new Plan(name: 'test', description: 'Alguma descricao');
        $mockRepository = Mockery::mock(PlanRepositoryInterface::class);
        $mockRepository->shouldReceive('findById')
            ->with($plan->getId()->getValue())
            ->once()
            ->andReturn($plan);
        $usecase = new FindPlanUsecase(
            planRepository: $mockRepository
        );
        $input = new FindPlanUsecaseInput(
            id: $plan->getId()->getValue()
        );
        $output = $usecase->execute($input);
        expect($output)->toBeInstanceOf(FindPlanUsecaseOutput::class);
        expect($output->planId)->toBe($plan->getId()->getValue());
        expect($output->name)->toBe('test');
        expect($output->description)->toBe('Alguma descricao');
    });

    test('Deve lançar exception PlanNotFoundException ao buscar plano usando mock', function () {
        $planId = Uuid::create();
        $mockRepository = Mockery::mock(PlanRepositoryInterface::class);
        $mockRepository->shouldReceive('findById')
            ->with($planId->getValue())
            ->once()
            ->andReturnNull();
        $usecase = new FindPlanUsecase(
            planRepository: $mockRepository
        );
        $input = new FindPlanUsecaseInput(
            id: $planId->getValue()
        );
        $usecase->execute($input);
    })->throws(PlanNotFoundException::class);
});
