<?php

namespace App\Http\Controllers\Db2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponseHelper;

use App\Models\Db2\LearningObjQuestion;

class LearningObjQuestionController extends Controller
{
     // learning obj questions
    public function getLearningObjQuestion()
    {
        return $this->fetchAll(LearningObjQuestion::class, 'Learning Obj question fetched successfully');
    }
}
