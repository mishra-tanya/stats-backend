<?php

namespace App\Models\Db4;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $connection = 'mysql4'; 
    protected $table = 'auth_user';
}
