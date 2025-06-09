<?php

if (!function_exists('apiSuccess')) {
    /**
     * Standard success response
     *
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    function apiSuccess($data = null, string $message = 'Success', int $statusCode = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $statusCode);
    }
}

if (!function_exists('apiError')) {
    /**
     * Standard error response
     *
     * @param string $message
     * @param int $statusCode
     * @param mixed $errors Optional error details or validation errors
     * @return \Illuminate\Http\JsonResponse
     */
    function apiError(string $message = 'Error', int $statusCode = 400, $errors = null)
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);
    }
}
