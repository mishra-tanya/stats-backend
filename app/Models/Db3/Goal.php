<?php

namespace App\Models\Db3;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $connection = 'mysql3'; 
    protected $table = 'goals';
}
