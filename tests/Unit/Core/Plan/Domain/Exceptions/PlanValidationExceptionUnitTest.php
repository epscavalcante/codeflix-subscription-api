<?php

use Core\Plan\Domain\Exceptions\PlanValidationException;

describe('PlanValidationExceptionUnitTestPlanValidationException', function () {
    test('should throw error', function () {
        throw new PlanValidationException(['test' => 'Error']);
    })->throws(PlanValidationException::class, 'The Plan was invalid.');

    test('should return errors when send string error ', function () {
        try {
            throw new PlanValidationException(['test' => 'Error']);
        } catch (PlanValidationException $e) {

            expect($e->getMessage())->toBe('The Plan was invalid.');
            expect($e->getErrors())->toMatchArray([
                'test' => 'Error'
            ]);
        }
    });

    test('should return errors when send array error ', function () {
        try {
            throw new PlanValidationException([
                'test' =>
                ['Error 1', 'Error 2'],
            ]);
        } catch (PlanValidationException $e) {

            expect($e->getMessage())->toBe('The Plan was invalid.');
            expect($e->getErrors())->toMatchArray([
                'test' => ['Error 1', 'Error 2']
            ]);
        }
    });
})->group('Unit');
