<?php

namespace App\Services\Response;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function json(array $data = [], int $status = 200, string $message = ''): JsonResponse
    {
        $status = $status > 0 ? $status : 200;
        if (strlen($message) > 0) {
            $responseData['message'] = $message;
        }

        $responseData['status'] = $status;
        $responseData['data'] = $data;

        return response()->json($responseData, $status);
    }
}
