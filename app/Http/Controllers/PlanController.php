<?php

namespace App\Http\Controllers;

use Core\Plan\Application\Usecases\Dto\ListPlanUsecaseInput;
use Core\Plan\Application\Usecases\ListPlanUsecase;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function list(Request $request, ListPlanUsecase $listUseCase)
    {
        $input = new ListPlanUsecaseInput(
            filterBy: $request->get('filterBy', null),
            sortBy: $request->get('sortBy'),
            sortDir: $request->get('sortDir', null),
            page: $request->get('page', null),
            perPage: $request->get('perPage', null),
        );
        $output = $listUseCase->execute($input);

        return response()->json([
            'data' => $output->items,
            'meta' => [
                'page' => $output->page,
                'per_page' => $output->perPage,
                'next_page' => $output->nextPage,
                'previous_page' => $output->previousPage,
                'first_page' => $output->firstPage,
                'last_page' => $output->lastPage,
            ]
        ], 200);
    }
}
