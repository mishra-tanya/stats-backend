<?php

namespace App\Http\Controllers\Db2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponseHelper;

use App\Models\Db2\LearningObjName;

class LearningObjNameController extends Controller
{
    // learning obj name
    public function getLearningObjName()
    {
        return $this->fetchAll(LearningObjName::class, 'Learning Objective name fetched successfully');
    }
}
