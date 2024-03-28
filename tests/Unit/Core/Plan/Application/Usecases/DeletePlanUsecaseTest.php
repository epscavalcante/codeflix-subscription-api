<?php

use Core\Plan\Application\Usecases\DeletePlanUsecase;
use Core\Plan\Application\Usecases\Dto\DeletePlanUsecaseInput;
use Core\Plan\Application\Usecases\Dto\DeletePlanUsecaseOutput;
use Core\Plan\Domain\Exceptions\PlanNotFoundException;
use Core\Plan\Domain\Plan;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;
use Core\Shared\Domain\Uuid;

describe('DeletePlanUsecase Unit Test', function () {
    test('Deve excluir um plano', function () {
        $plan = new Plan(name: 'test', description: 'Alguma descricao');
        $mockRepository = Mockery::mock(PlanRepositoryInterface::class);
        $mockRepository->shouldReceive('findById')
            ->with($plan->getId()->getValue())
            ->once()
            ->andReturn($plan);
        $mockRepository->shouldReceive('delete')
            ->with($plan->getId()->getValue())
            ->once()
            ->andReturn();
        $usecase = new DeletePlanUsecase(
            planRepository: $mockRepository
        );
        $input = new DeletePlanUsecaseInput(
            id: $plan->getId()->getValue()
        );
        $output = $usecase->execute($input);
        expect($output)->toBeInstanceOf(DeletePlanUsecaseOutput::class);
        expect($output->planId)->toBe($plan->getId()->getValue());
    });

    test('Deve lançar exception PlanNotFoundException ao buscar plano que não existe', function () {
        $planId = Uuid::create();
        $mockRepository = Mockery::mock(PlanRepositoryInterface::class);
        $mockRepository->shouldReceive('findById')
            ->with($planId->getValue())
            ->once()
            ->andReturnNull();
        $usecase = new DeletePlanUsecase(
            planRepository: $mockRepository
        );
        $input = new DeletePlanUsecaseInput(
            id: $planId->getValue()
        );
        $usecase->execute($input);
    })->throws(PlanNotFoundException::class);
});
