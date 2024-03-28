<?php

use Core\Plan\Application\Usecases\Dto\UpdatePlanUsecaseInput;
use Core\Plan\Application\Usecases\Dto\UpdatePlanUsecaseOutput;
use Core\Plan\Application\Usecases\UpdatePlanUsecase;
use Core\Plan\Domain\Exceptions\PlanNotFoundException;
use Core\Plan\Domain\Exceptions\PlanValidationException;
use Core\Plan\Domain\Plan;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;
use Core\Shared\Domain\Uuid;

describe('UpdatePlanUsecase Unit Test', function () {
    test('Deve atualizar um plano', function () {

        $plan = new Plan(
            name: 'plan',
            description: 'description'
        );
        $input = new UpdatePlanUsecaseInput(
            planId: $plan->getId(),
            name: 'test edited',
            description: 'description edited'
        );
        $planRepository = Mockery::mock(PlanRepositoryInterface::class);
        $planRepository->shouldReceive('findById')
            ->once()
            ->andReturn($plan);
        $plan->changeName($input->name);
        $plan->changeDescription($input->description);
        $planRepository->shouldReceive('update')
            ->once()
            ->andReturn($plan);
        $usecase = new UpdatePlanUsecase(
            planRepository: $planRepository
        );
        $output = $usecase->execute($input);
        expect($output)->toBeInstanceOf(UpdatePlanUsecaseOutput::class);
        expect($output->planId)->toBe($plan->getId()->getValue());
        expect($output->name)->toBe('test edited');
        expect($output->description)->toBe('description edited');
    });

    test('Deve receber um PlanNotFoundException ao editar um plano que não existe', function () {
        $planRepository = Mockery::mock(PlanRepositoryInterface::class);
        $planRepository->shouldReceive('findById')
            ->once()
            ->andReturnNull();

        $usecase = new UpdatePlanUsecase(
            planRepository: $planRepository
        );
        $input = new UpdatePlanUsecaseInput(
            planId: Uuid::create(),
            name: 'test edited',
            description: 'description edited'
        );
        $usecase->execute($input);
    })->throws(PlanNotFoundException::class);

    test('Deve receber PlanValidationException ao editar um plano com o nome inválido', function () {
        $plan = new Plan(
            name: 'plan',
            description: 'description'
        );
        $input = new UpdatePlanUsecaseInput(
            planId: $plan->getId(),
            name: str_repeat('a', 256),
            description: 'description edited'
        );
        $planRepository = Mockery::mock(PlanRepositoryInterface::class);
        $planRepository->shouldReceive('findById')
            ->once()
            ->andReturn($plan);

        $usecase = new UpdatePlanUsecase(
            planRepository: $planRepository
        );

        try {
            $usecase->execute($input);
        } catch (PlanValidationException $th) {
            expect($th->getErrors())->toMatchArray([
                'name' => ['The name field must not be greater than  100 characters.']
            ]);
        }
    });
});
