<?php

use Core\User\Domain\Exceptions\NameInvalidException;
use Core\User\Domain\ValueObjects\Name;

describe('Name Unit Test', function () {
    test('Should receive NameInvalidException', function (string $firstName, $lastName) {
        new Name(
            firstName: $firstName,
            lastName: $lastName
        );
    })
        ->throws(NameInvalidException::class)
        ->with([
            ['   ', ''],
            ['', '   '],
            ['   ', '   '],
            ['', ''],
            ['', 'aaa'],
            ['aaa', ''],
            ['a', 'aa'],
            ['aa', 'a'],
            ['   a', '  a    '],
            ['', 'a'],
            [str_repeat('a', 156), str_repeat('a', 100)],
            [str_repeat('a', 100), str_repeat('a', 156)],
        ]);

    test('Should create a name', function () {
        $name = new Name('User', 'Test');

        expect((string) $name)->toBe('User Test');
        expect($name->getValue())->toBe('User Test');
        expect($name->getFirstName())->toBe('User');
        expect($name->getLastName())->toBe('Test');
        expect($name->getFullName())->toBe('User Test');
    });
});
