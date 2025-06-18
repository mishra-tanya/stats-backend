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
        return $this->fetchAll(User::class, 'Users fetched successfully');
    }
    
    // users from subscribed
    public function subscribed()
    {
        return $this->fetchAll(SubscribedUser::class, 'Users fetched successfully');
    }
    
}
