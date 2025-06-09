<?php

namespace App\Http\Controllers\Db1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponseHelper;

use App\Models\Db1\User;
use App\Models\Db1\SubscribedUser;


class UserController extends Controller
{
    // users from login
    public function login()
    {
        try {
            $users = User::all();
            return apiSuccess($users, 'Users fetched successfully');

        } catch (\Exception $e) {
            return apiError('Failed to fetch Users', 500);
        }
    }
    
    // users from subscribed
    public function subscribed()
    {
        try {
            $users = SubscribedUser::all();
            return apiSuccess($users, 'Users fetched successfully');
         
        } catch (\Exception $e) {
            return apiError('Failed to fetch Users', 500);
        }
    }
}
