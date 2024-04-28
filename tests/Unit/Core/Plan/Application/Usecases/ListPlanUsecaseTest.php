<?php

use Core\Plan\Application\Usecases\Dto\ListPlanUsecaseInput;
use Core\Plan\Application\Usecases\Dto\ListPlanUsecaseOutput;
use Core\Plan\Application\Usecases\ListPlanUsecase;
use Core\Plan\Domain\Plan;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;
use Core\Plan\Domain\Repositories\PlanSearchResult as SearchResult;

describe('ListPlanUsecase Unit Test', function () {
    test('Deve listar os planos com valores default', function () {
        $mockRepository = Mockery::mock(PlanRepositoryInterface::class);
        $searchResult = new SearchResult(
            items: [],
            total: 0,
            page: 1,
            perPage: 10,
            previousPage: 1,
            nextPage: 1,
            firstPage: 1,
            lastPage: 1,
        );
        $mockRepository->shouldReceive('search')
            ->once()
            ->with(
                null,
                null,
                null,
                null,
                null
            )
            ->andReturn($searchResult);
        $usecase = new ListPlanUsecase(
            planRepository: $mockRepository
        );
        $input = new ListPlanUsecaseInput(
            filterBy: null,
            sortBy: null,
            sortDir: null,
            page: null,
            perPage: null
        );

        $output = $usecase->execute($input);
        expect($output)->toBeInstanceOf(ListPlanUsecaseOutput::class);
        expect($output->items)->toBeArray();
        expect($output->items)->toHaveCount(0);
        expect($output->total)->toBe(0);
        expect($output->page)->toBe(1);
        expect($output->perPage)->toBe(10);
        expect($output->previousPage)->toBe(1);
        expect($output->firstPage)->toBe(1);
        expect($output->lastPage)->toBe(1);
    });

    test('Deve listar os planos', function () {
        $mockRepository = Mockery::mock(PlanRepositoryInterface::class);
        $planOne = new Plan('plan 1', 'descricao');
        $planTwo = new Plan('plan 2', 'descricao');
        $searchResult = new SearchResult(
            items: [
                $planOne,
                $planTwo,
            ],
            total: 3,
            page: 2,
            perPage: 2,
            previousPage: 1,
            nextPage: 2,
            firstPage: 1,
            lastPage: 2,
        );
        $mockRepository->shouldReceive('search')
            ->once()
            ->with(
                null,
                null,
                null,
                2,
                2
            )
            ->andReturn($searchResult);
        $usecase = new ListPlanUsecase(
            planRepository: $mockRepository
        );
        $input = new ListPlanUsecaseInput(
            filterBy: null,
            sortBy: null,
            sortDir: null,
            page: 2,
            perPage: 2
        );

        $output = $usecase->execute($input);
        expect($output)->toBeInstanceOf(ListPlanUsecaseOutput::class);
        expect($output->items)->toBeArray();
        expect($output->items)->toHaveCount(2);
        expect($output->items[0])->toMatchArray([
            'planId' => $planOne->getId(),
            'name' => 'plan 1',
            'description' => 'descricao',
        ]);
        expect($output->items[1])->toMatchArray([
            'planId' => $planTwo->getId(),
            'name' => 'plan 2',
            'description' => 'descricao',
        ]);
        expect($output->total)->toBe(3);
        expect($output->page)->toBe(2);
        expect($output->perPage)->toBe(2);
        expect($output->previousPage)->toBe(1);
        expect($output->firstPage)->toBe(1);
        expect($output->lastPage)->toBe(2);
    });
});
