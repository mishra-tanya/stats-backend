<?php

namespace App\Http\Controllers\Db2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponseHelper;

use App\Models\Db2\Results;

class ResultsController extends Controller
{
    // results scr
    public function getSCRResult()
    {
        return $this->fetchAll(Results::class, 'SCR Results fetched successfully');
    }
}
