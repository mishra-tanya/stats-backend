<?php

namespace App\Models\Db2;

use Illuminate\Database\Eloquent\Model;

class LearningObjName extends Model
{
    protected $connection = 'mysql2'; 
    protected $table = 'test_name';
}
