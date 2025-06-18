<?php

namespace App\Http\Controllers\Db2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponseHelper;

use App\Models\Db2\User;

class UserController extends Controller
{
    // users from login
    public function getUser()
    {
        $users = User::onlyUsers()->get();
        return $this->handleSuccess($users, 'Users fetched successfully');
    }

    // by id
    public function getUserById($id)
    {
        $users = User::onlyUsers()->find($id);
        return $this->handleSuccess($users, 'User Data fetched successfully');
    }
    
}
