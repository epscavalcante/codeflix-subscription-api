<?php

use Core\User\Domain\Exceptions\CpfInvalidException;
use Core\User\Domain\ValueObjects\Cpf;

describe('CPF Unit Test', function () {
    test('Should receive CpfInvalidException', function (string $cpf) {
        new Cpf($cpf);
    })
        ->throws(CpfInvalidException::class)
        ->with([
            '958187',
            '00000000000',
            '22222222222',
            '03521244232',
            '133.231.987-00',
        ]);

    test('Should be create a cpf', function (string $cpf) {
        $cpf = new Cpf($cpf);

        expect($cpf)->toBeInstanceOf(Cpf::class);
        expect($cpf->getValue())->toBe(preg_replace('/[^0-9]/is', '', $cpf));
        expect((string) $cpf)->toBe(preg_replace('/[^0-9]/is', '', $cpf));
    })->with([
        '860.280.970-04',
        '007.918.161-92',
    ]);
});
