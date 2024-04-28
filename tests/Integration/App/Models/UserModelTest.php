<?php

use App\Models\User;

describe('User Model Unit Tests', function () {
    $userModel = new User();

    test('Table name must be plans', function () use ($userModel) {
        expect($userModel->getTable())->toBe('users');
    });

    test('Key type name must bem plan_id', function () use ($userModel) {
        expect($userModel->getKeyName())->toBe('user_id');
    });

    test('Key Type must be a string', function () use ($userModel) {
        expect($userModel->getKeyType())->toBe('string');
    });

    test('Incrementing primary key must bem false', function () use ($userModel) {
        expect($userModel->getIncrementing())->toBeFalsy();
    });

    test('Timestamps must bem false', function () use ($userModel) {
        expect($userModel->usesTimestamps())->toBeFalsy();
    });

    test('Fillable', function () use ($userModel) {
        expect($userModel->getFillable())->toMatchArray([
            'user_id',
            'document',
            'first_name',
            'last_name',
            'email',
            'birthdate',
        ]);
    });

    test('relations must be empty', function () use ($userModel) {
        expect($userModel->getRelations())->toBeArray()->toHaveCount(0);
    });
});
