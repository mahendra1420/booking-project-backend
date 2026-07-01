<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * Return a success JSON response.
     */
    public static function success(
        mixed $data = null,
        string $message = 'Success',
        int $statusCode = 200
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $statusCode);
    }

    /**
     * Return an error JSON response.
     */
    public static function error(
        string $message = 'An error occurred',
        mixed $errors = null,
        int $statusCode = 400
    ): JsonResponse {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if (! is_null($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Return a 201 Created response.
     */
    public static function created(
        mixed $data = null,
        string $message = 'Created successfully'
    ): JsonResponse {
        return self::success($data, $message, 201);
    }

    /**
     * Return a 204 No Content response.
     */
    public static function noContent(): JsonResponse
    {
        return response()->json(null, 204);
    }

    /**
     * Return a 401 Unauthorized response.
     */
    public static function unauthorized(string $message = 'Unauthorized'): JsonResponse
    {
        return self::error($message, null, 401);
    }

    /**
     * Return a 403 Forbidden response.
     */
    public static function forbidden(string $message = 'Forbidden'): JsonResponse
    {
        return self::error($message, null, 403);
    }

    /**
     * Return a 404 Not Found response.
     */
    public static function notFound(string $message = 'Resource not found'): JsonResponse
    {
        return self::error($message, null, 404);
    }

    /**
     * Return a 422 Validation Error response.
     */
    public static function validationError(mixed $errors, string $message = 'Validation failed'): JsonResponse
    {
        return self::error($message, $errors, 422);
    }
}
