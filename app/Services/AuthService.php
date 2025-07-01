<?php

namespace App\Services;

class AuthService
{
    public function attemptLogin($credentials)
    {
        $adminEmail = env('ADMIN_EMAIL');
        $adminPassword = env('ADMIN_PASSWORD');

        if (
            $credentials['email'] === $adminEmail &&
            $credentials['password'] === $adminPassword
        ) {
            return [
                'user' => [
                    'email' => $adminEmail,
                    'role' => 'admin',
                ],
            ];
        }

        return null;
    }
}
