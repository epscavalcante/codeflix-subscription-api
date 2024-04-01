<?php

namespace App\Http\Controllers;

use App\Http\Presenters\PlanCollectionPresenter;
use Core\Plan\Application\Usecases\Dto\ListPlanUsecaseInput;
use Core\Plan\Application\Usecases\ListPlanUsecase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlanController extends Controller
{
    public function list(Request $request, ListPlanUsecase $listUseCase)
    {
        $input = new ListPlanUsecaseInput(
            filterBy: $request->get('filter_by', null),
            sortBy: $request->get('sort_by'),
            sortDir: $request->get('sort_dir', null),
            page: $request->get('page', null),
            perPage: $request->get('per_page', null),
        );
        $output = $listUseCase->execute($input);
        $presenter = new PlanCollectionPresenter($output);

        return $presenter->toJSON(
            Response::HTTP_OK
        );
    }
}
