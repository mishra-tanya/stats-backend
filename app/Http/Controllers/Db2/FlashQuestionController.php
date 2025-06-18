<?php

namespace App\Http\Controllers\Db2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponseHelper;

use App\Models\Db2\FlashQuestion;

class FlashQuestionController extends Controller
{
    // flash questions
    public function getFlashQuestion()
    {
        return $this->fetchAll(FlashQuestion::class, 'Flash Question fetched successfully');
    }
}
