<?php

namespace App\Http\Controllers\Db2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Db2\LearningObjResult;

class LearningObjResultController extends Controller
{
    // learnign obj results
    public function getLearningObjResult()
    {
        return $this->fetchAll(LearningObjResult::class, 'Learning Obj result fetched successfully');
    }
}
