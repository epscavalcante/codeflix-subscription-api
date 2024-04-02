<?php

namespace App\Http\Presenters;

class PlanCollectionPresenter
{
    public function __construct(
        private readonly object $data
    ) {
    }

    public function toJSON(int $statusCode = 200, $headers = [])
    {
        return response()->json(
            data: [
                'data' => array_map(
                    callback: function ($item) {
                        return [
                            'plan_id' => $item->planId,
                            'name' => $item->name,
                            'description' => $item->description,
                        ];
                    },
                    array: $this->data->items
                ),
                'meta' => [
                    'total' => $this->data->total,
                    'page' => $this->data->page,
                    'per_page' => $this->data->perPage,
                    'previous_page' => $this->data->previousPage,
                    'next_page' => $this->data->nextPage,
                    'first_page' => $this->data->firstPage,
                    'last_page' => $this->data->lastPage,
                ],
            ],
            status: $statusCode,
            headers: $headers
        );
    }
}
