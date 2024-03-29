<?php

use App\Models\Plan;

describe('Plan Model Unit Tests', function () {
    $planModel = new Plan();

    test('Table name must be plans', function () use ($planModel) {
        expect($planModel->getTable())->toBe('plans');
    });

    test('Key type name must bem plan_id', function () use ($planModel) {
        expect($planModel->getKeyName())->toBe('plan_id');
    });

    test('Key Type must be a string', function () use ($planModel) {
        expect($planModel->getKeyType())->toBe('string');
    });

    test('Incrementing primary key must bem false', function () use ($planModel) {
        expect($planModel->getIncrementing())->toBeFalsy();
    });

    test('Timestamps  must bem false', function () use ($planModel) {
        expect($planModel->usesTimestamps())->toBeFalsy();
    });

    test('Fillable', function () use ($planModel) {
        expect($planModel->getFillable())->toMatchArray([
            'plan_id',
            'name',
            'description'
        ]);
    });

    test('relations must be empty', function () use ($planModel) {
        expect($planModel->getRelations())->toBeArray()->toHaveCount(0);
    });
});
