<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Helpers\ApiResponseHelper;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $result = $this->authService->attemptLogin($request->only('email', 'password'));

        if (!$result) {
            return apiError('Invalid credentials', 401);
        }

        if ($result['user']['role'] !== 'admin') {
            return apiError('Access denied. Admins only.', 403);
        }

        return apiSuccess($result, 'Login successful');
    }
}
