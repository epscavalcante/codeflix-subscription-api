<?php

use App\Models\Plan as PlanModel;
use App\Repositories\Mappers\PlanEloquentRepositoryMapper;
use App\Repositories\PlanEloquentRepository;
use Core\Plan\Domain\Exceptions\PlanNotFoundException;
use Core\Plan\Domain\Plan;
use Core\Shared\Domain\Repositories\SearchResult;
use Core\Shared\Domain\Uuid;
use Illuminate\Database\Eloquent\Factories\Sequence;

beforeEach(function () {
    /**
     * @var PlanEloquentRepository $planRepository
     */
    $this->planRepository = new PlanEloquentRepository(new PlanModel());
});

describe('Plan Eloquent Repository', function () {
    test('Deve criar um plano', function () {
        $plan = new Plan('plan', 'description');

        $this->planRepository->create($plan);

        expect(PlanModel::count())->toBe(1);
        $planModel = PlanModel::first();
        expect($planModel->plan_id)->tobe($plan->getId()->getValue());
        expect($planModel->plan_id)->tobe($plan->getId()->getValue());
        expect($planModel->plan_id)->tobe($plan->getId()->getValue());
    });

    describe('Find a plan', function () {
        test('Deve retornar null ao buscar um pplano que não existe', function () {
            $planId = Uuid::create();
            $planFound = $this->planRepository->findById($planId);
            expect($planFound)->toBeNull();
        });

        test('Deve encontrar um plan', function () {
            $planModel = PlanModel::factory()->create();
            $planId = new Uuid($planModel->plan_id);
            $planFound = $this->planRepository->findById($planId);

            expect($planFound)->toBeInstanceOf(Plan::class);
        });
    });

    describe('Delete a plan', function () {
        test('Deve lançar PlanNotFoundException ao excluir um plano que não existe', function () {
            $planId = Uuid::create();
            $this->planRepository->delete($planId);
        })->throws(PlanNotFoundException::class);

        test('Deve encontrar um plan', function () {
            $planModel = PlanModel::factory()->create();
            $planId = new Uuid($planModel->plan_id);
            $this->planRepository->delete($planId);

            expect(PlanModel::count())->toBe(0);
            expect(PlanModel::find($planId))->toBeNull();
        });
    });

    describe('Update a plan', function () {
        test('Deve lançar PlanNotFoundException ao atualizar um plano que não existe', function () {
            $plan = new Plan('plan', 'description');
            $this->planRepository->update($plan);
        })->throws(PlanNotFoundException::class);

        test('Deve atualizar um plano', function () {
            $planModel = PlanModel::factory()->create();
            $plan = PlanEloquentRepositoryMapper::toEntity($planModel);
            $plan->changeName('updated');
            $plan->changeDescription('updated description');
            $this->planRepository->update($plan);

            $planUpdated = PlanModel::find($plan->getId());
            expect($planUpdated->plan_id)->toBe($plan->getId()->getValue());
            expect($planUpdated->name)->toBe('updated');
            expect($planUpdated->description)->toBe('updated description');
        });
    });

    describe('List plans', function () {
        test('Deve retonar resultado padrão', function () {
            $result = $this->planRepository->search();

            expect($result)->toBeInstanceOf(SearchResult::class);
            expect($result->total())->toBe(0);
            expect($result->page())->toBe(1);
            expect($result->perPage())->toBe(10);
            expect($result->previousPage())->toBeNull();
            expect($result->nextPage())->toBeNull();
            expect($result->firstPage())->toBe(1);
            expect($result->lastPage())->toBe(1);
            expect($result->items())->toBeArray();
            expect($result->items())->toHaveCount(0);
        });

        test('Deve paginar e order os planos', function () {
            PlanModel::factory()
                ->count(10)
                ->sequence(fn (Sequence $sequence) => ['name' => 'Name '.$sequence->index])
                ->create();

            $result = $this->planRepository->search(
                sortBy: 'name',
                sortDir: 'ASC',
                page: 2,
                perPage: 5
            );

            expect($result)->toBeInstanceOf(SearchResult::class);
            expect($result->total())->toBe(10);
            expect($result->page())->toBe(2);
            expect($result->perPage())->toBe(5);
            expect($result->previousPage())->toBe(1);
            expect($result->nextPage())->toBeNull();
            expect($result->firstPage())->toBe(1);
            expect($result->lastPage())->toBe(2);
            expect($result->items())->toBeArray();
            expect($result->items())->toHaveCount(5);
        });
    });
});
