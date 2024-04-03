<?php

use Core\User\Domain\User;
use Core\User\Domain\ValueObjects\Birthdate;
use Core\User\Domain\ValueObjects\Cpf;
use Core\User\Domain\ValueObjects\Email;
use Core\User\Domain\ValueObjects\Name;

describe('User unit tests', function () {
    test('Deve criar um user', function () {
        $user = new User(
            document: new Cpf('860.280.970-04'),
            name: new Name('User', 'Test'),
            email: new Email('user.test@email.com'),
            birthdate: new Birthdate(new DateTime('2000-01-01'))
        );

        expect($user)->toBeInstanceOf(User::class);

    });
})->group('Unit');
