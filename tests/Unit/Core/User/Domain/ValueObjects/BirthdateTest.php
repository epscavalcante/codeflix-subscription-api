<?php

use Core\User\Domain\ValueObjects\Birthdate;

describe('Birthdate Unit Test', function () {
    test('Should create a birthdate', function () {
        $birthdate = new Birthdate(new DateTime('1990-01-01'));

        expect(
            $birthdate->getValue()
        )->toBeInstanceOf(DateTime::class);

        expect(
            (string) $birthdate
        )->toBe('1990-01-01');

        expect(
            $birthdate->getYearsOld(new DateTime('2000-01-01'))
        )->toBe(10);
    });
});
