<?php

namespace App\Http\Controllers\Db2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponseHelper;

use App\Models\Db2\QuestionLimit;

class QuestionLimitController extends Controller
{
     // question limit for mock and basic tests 
    public function getQuestionLimit()
    {
        return $this->fetchAll(QuestionLimit::class, 'Questions Limit fetched successfully');
    }
}
