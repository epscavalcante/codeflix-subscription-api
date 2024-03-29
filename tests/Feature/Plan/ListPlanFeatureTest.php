<?php

describe('List plan Feature tests', function () {
    describe('GET /plans', function () {
        test('Deve retornar paginação vazia', function () {
            $response = $this->getJson(route('plans.list'));

            $response->assertStatus(200);
            $response->assertJsonCount(0, 'data');
            $response->assertJsonStructure([
                'data' => ['*'],
                'meta' => ['*']
            ]);
        });
    });
});
