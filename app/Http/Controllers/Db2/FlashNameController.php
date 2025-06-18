<?php

namespace App\Http\Controllers\Db2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponseHelper;

use App\Models\Db2\FlashName;

class FlashNameController extends Controller
{
   // flash names
    public function getFlashName()
    {
        return $this->fetchAll(FlashName::class, 'Flash Name fetched successfully');
    }
}
