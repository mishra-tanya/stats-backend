<?php

namespace App\Models\Db2;

use Illuminate\Database\Eloquent\Model;

class LearningObjQuestion extends Model
{
    protected $connection = 'mysql2'; 
    protected $table = 'lo_question_paper';
}
