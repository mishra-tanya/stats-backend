<?php

namespace App\Http\Controllers\Db2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponseHelper;

use App\Models\Db2\SCRQuestion;

class SCRQuestionController extends Controller
{
    // scr questions
    public function getSCRQuestion()
    {
        return $this->fetchAll(SCRQuestion::class, 'SCR Question fetched successfully');
    }
}
