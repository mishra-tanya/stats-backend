<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponseHelper;
use Illuminate\Http\JsonResponse;

abstract class Controller
{
    // try catch handle
    protected function handleSuccess($data, string $message = 'Success')
    {
        try {
            return apiSuccess($data, $message);
        } catch (\Exception $e) {
            return apiError('Something went wrong', 500, $e->getMessage());
        }
    }

    // fetching whole data from tbale
    protected function fetchAll(string $modelClass, string $successMessage = 'Data fetched successfully'): JsonResponse
    {
        try {
            $data = $modelClass::all();
            return apiSuccess($data, $successMessage);
        } catch (Exception $e) {
            return apiError('Failed to fetch data', 500, $e->getMessage());
        }
    }
    
}
