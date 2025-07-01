<?php

namespace App\Http\Controllers\Db4;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Db4\User;

class UserController extends Controller
{
    public function getUser()
    {
        $users = User::get();
        return $this->handleSuccess($users, 'Users fetched successfully');
    }
}
