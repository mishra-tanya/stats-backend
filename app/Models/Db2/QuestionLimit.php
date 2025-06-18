<?php

namespace App\Models\Db2;

use Illuminate\Database\Eloquent\Model;

class QuestionLimit extends Model
{
    protected $connection = 'mysql2'; 
    protected $table = 'question_limits';
}
