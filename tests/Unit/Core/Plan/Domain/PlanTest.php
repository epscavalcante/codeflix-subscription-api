<?php

use Core\Plan\Domain\Exceptions\PlanValidationException;
use Core\Plan\Domain\Plan;
use Core\Shared\Domain\Uuid;

describe('Plan unit tests', function () {

    test('Deve criar um plan com id autogerado', function () {
        $plan = new Plan(
            name: 'plan name',
            description: 'plan description',
        );

        expect($plan->planId)->toBeInstanceOf(Uuid::class);
        expect($plan->planId->getValue())->toBeString();
        expect($plan->name)->toBe('plan name');
        expect($plan->description)->toBe('plan description');
    });

    test('Deve criar um plan passando id', function () {
        $id = Uuid::create()->getValue();

        $plan = new Plan(
            name: 'plan name',
            description: 'plan description',
            planId: $id
        );

        expect($plan->planId)->toBeInstanceOf(Uuid::class);
        expect($plan->planId->getValue())->toBe($id);
        expect($plan->name)->toBe('plan name');
        expect($plan->description)->toBe('plan description');
    });

    test('Deve alterar o nome do plano', function () {
        $plan = new Plan(
            name: 'plan name',
            description: 'plan description',
        );
        $plan->changeName('New name');
        expect($plan->name)->toBe('New name');
    });

    test('Deve alterar a descrição do plano', function () {
        $plan = new Plan(
            name: 'plan name',
            description: 'plan description',
        );
        $plan->changeDescription('New description');
        expect($plan->description)->toBe('New description');
    });

    describe('Validations', function () {
        test('Deve lançar PlanValidationException ao criar entity', function () {
            new Plan(
                name: str_repeat('a', 256),
                description: 'plan description',
            );
        })->throws(PlanValidationException::class);

        test('Deve lançar PlanValidationException ao alterar o nome do plano', function () {
            $plan = new Plan(
                name: 'plan name',
                description: 'plan description',
            );

            $plan->changeName(str_repeat('a', 256));
        })->throws(PlanValidationException::class);

        test('Deve lançar PlanValidationException ao alterar a descrição do plano', function () {
            $plan = new Plan(
                name: 'plan name',
                description: 'plan description',
            );

            try {
                $plan->changeDescription(str_repeat('a', 256));
            } catch (PlanValidationException $th) {
                expect($th)->toBeInstanceOf(PlanValidationException::class);
                expect($th->getErrors())->toMatchArray([
                    'description' => ['The description field must not be greater than  100 characters.'],
                ]);
            }
        });
    });
})->group('Unit');
