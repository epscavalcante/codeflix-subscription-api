<?php

use Core\Shared\Domain\Exceptions\UuidInvalidException;
use Core\Shared\Domain\Uuid;

test('Deve criar um uuid', function () {
    $uuidString = Uuid::create();
    $uuid = new Uuid($uuidString);
    expect($uuid)->toBeInstanceOf(Uuid::class);
});

test('Deve lançar erro criar uuid inválido', function () {
    new Uuid('fake');
})->throws(UuidInvalidException::class);
