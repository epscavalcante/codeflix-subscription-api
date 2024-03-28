<?php

use Core\Shared\Domain\Notification;

describe('Notification errros', function () {

    test('add errros', function () {
        $notification = new Notification();

        $notification->addError('Primeiro erro', 'name');
        expect($notification->getErrors())->toEqualCanonicalizing(['name' => ['Primeiro erro']]);

        $notification->addError('Segundo erro', 'name');
        expect($notification->getErrors())->toEqualCanonicalizing(['name' => ['Primeiro erro', 'Segundo erro']]);

        $notification->addError('Terceiro erro', 'other_field');
        expect($notification->getErrors())->toEqualCanonicalizing([
            'name' => ['Primeiro erro', 'Segundo erro'],
            'other_field' => [0 => 'Terceiro erro'],
        ]);

        $notification->addError('Quarto erro', 'other_field');
        expect($notification->getErrors())->toEqualCanonicalizing([
            'name' => ['Primeiro erro', 'Segundo erro'],
            'other_field' => ['Terceiro erro', 'Quarto erro'],
        ]);

        $notification->addError('Quinto erro', 'other_field');
        expect($notification->getErrors())->toEqualCanonicalizing([
            'name' => ['Primeiro erro', 'Segundo erro'],
            'other_field' => ['Terceiro erro', 'Quarto erro', 'Quinto erro'],
        ]);

        $notification->addError('Sexto erro', 'other_other_field');
        expect($notification->getErrors())->toEqualCanonicalizing([
            'name' => ['Primeiro erro', 'Segundo erro'],
            'other_field' => ['Terceiro erro', 'Quarto erro', 'Quinto erro'],
            'other_other_field' => ['Sexto erro'],
        ]);
    });

    describe('Check has errors', function () {
        test('No errors', function () {
            $notification = new Notification();

            expect($notification->hasErrors())->toBeFalsy();
        });

        test('With errors', function () {
            $notification = new Notification();
            $notification->addError('Test', 'fieldName');

            expect($notification->hasErrors())->toBeTruthy();
        });
    });
});
