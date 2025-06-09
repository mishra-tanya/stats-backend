<?php

namespace App\Models\Db1;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $connection = 'mysql'; 
    protected $table = 'login_reg';
}
