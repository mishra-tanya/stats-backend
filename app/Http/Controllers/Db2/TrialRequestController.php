<?php

namespace App\Http\Controllers\Db2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponseHelper;

use App\Models\Db2\TrialRequests;

class TrialRequestController extends Controller
{
    //get trail requests from users
    public function getTrialRequests()
    {
        return $this->fetchAll(ContactMessages::class, 'Trial Requests fetched successfully');
    }
}
