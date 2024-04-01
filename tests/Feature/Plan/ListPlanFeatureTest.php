<?php

use App\Models\Plan;

describe('List plan Feature tests', function () {
    describe('GET /plans', function () {
        test('Deve retornar paginação vazia', function () {
            $response = $this->getJson(route('plans.list'));

            $response->assertStatus(200);
            $response->assertJsonCount(0, 'data');
            $response->assertJsonStructure([
                'data' => [],
                'meta' => [
                    'page',
                    'per_page',
                    'next_page',
                    'first_page',
                    'last_page',
                ],
            ]);
        });

        test('Deve retornar listagem paginada e ordenada', function () {
            Plan::factory()->create(['name' => 'Name 1']);
            $planTwo = Plan::factory()->create(['name' => 'Name 2']);
            Plan::factory()->create(['name' => 'Name 3']);
            $response = $this->getJson(route('plans.list', [
                'per_page' => 1,
                'page' => 2,
                'sort_by' => 'name',
                'sort_dir' => 'desc',
            ]));

            expect($response->status())->toBe(200);
            $response->assertStatus(200);
            $response->assertJsonCount(1, 'data');
            $response->assertJsonStructure([
                'data' => [
                    '*' => [
                        'plan_id',
                        'name',
                        'description',
                    ],
                ],
                'meta' => [
                    'page',
                    'total',
                    'per_page',
                    'previous_page',
                    'next_page',
                    'first_page',
                    'last_page',
                ],
            ]);
            $response->assertJson([
                'data' => [
                    [
                        'plan_id' => $planTwo->plan_id,
                        'name' => $planTwo->name,
                        'description' => $planTwo->description,
                    ],
                ],
                'meta' => [
                    'page' => 2,
                    'total' => 3,
                    'per_page' => 1,
                    'previous_page' => 1,
                    'next_page' => 3,
                    'first_page' => 1,
                    'last_page' => 3,
                ],
            ]);
        });
    });
});
