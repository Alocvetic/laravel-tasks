<?php

namespace App\Services\Response;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class BuildResponseHelper
{
    public static function buildResponseData(LengthAwarePaginator|Collection $response): array
    {
        if ($response instanceof LengthAwarePaginator) {
            return [
                'items' => $response->items(),
                'meta' => [
                    'lastPage' => $response->lastPage(),
                    'currentPage' => $response->currentPage(),
                    'currentSize' => $response->perPage()
                ]
            ];
        }

        return $response->toArray();
    }
}
