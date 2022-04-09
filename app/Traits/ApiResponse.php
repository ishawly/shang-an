<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{
    private static int $CODE_OK = 0;
    private static int $CODE_ERR = 1;

    public function success($data, $message = 'ok'): JsonResponse
    {
        return response()->json([
            'code' => self::$CODE_OK,
            'message' => $message,
            'data' => $data,
        ]);
    }

    public function successMessage($message): JsonResponse
    {
        return $this->success(null, $message);
    }

    public function error($message, ?int $httpCode, $data = null): JsonResponse
    {
        $statusCode = $httpCode && $httpCode >= Response::HTTP_BAD_REQUEST && $httpCode < 600
            ? $httpCode : Response::HTTP_BAD_REQUEST;
        return response()->json([
            'code' => $httpCode ?: self::$CODE_ERR,
            'message' => $message,
            'data' => $data,
        ])->setStatusCode($statusCode);
    }
}
