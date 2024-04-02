<?php

namespace App\Http\Presenters;

class PlanPresenter
{
    public function __construct(
        private readonly object $data
    ) {
    }

    public function toJSON(int $statusCode = 200, $headers = [])
    {
        return response()->json(
            data: [
                'data' => $this->data,
            ],
            status: $statusCode,
            headers: $headers
        );
    }
}
