<?php

use Core\User\Domain\Exceptions\EmailInvalidException;
use Core\User\Domain\ValueObjects\Email;

describe('Email Unit Test', function () {
    test('Should receive EmailInvalidException', function (string $cpf) {
        new Email($cpf);
    })
        ->throws(EmailInvalidException::class)
        ->with([
            'email',
            'email@',
            'email@email',
        ]);
});
