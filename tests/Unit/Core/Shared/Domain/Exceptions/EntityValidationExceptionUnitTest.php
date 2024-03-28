<?php

use Core\Shared\Domain\Exceptions\EntityValidationException;

describe('EntityValidationExceptionUnitTest', function () {
    test('should throw error', function () {
        throw new EntityValidationException(['test' => 'Error']);
    })->throws(EntityValidationException::class, 'The Entity was invalid.');

    test('should return errors when send string error ', function () {
        try {
            throw new EntityValidationException(['test' => 'Error']);
        } catch (EntityValidationException $e) {
            expect($e->getMessage())->toBe('The Entity was invalid.');
            expect($e->getErrors())->toMatchArray([
                'test' => 'Error',
            ]);
        }
    });

    test('should return errors when send array error ', function () {
        try {
            throw new EntityValidationException(
                ['test' => ['Error 1', 'Error 2']],
            );
        } catch (EntityValidationException $e) {
            expect($e->getMessage())->toBe('The Entity was invalid.');
            expect($e->getErrors())->toMatchArray([
                'test' => ['Error 1', 'Error 2'],
            ]);
        }
    });
})->group('Unit');
