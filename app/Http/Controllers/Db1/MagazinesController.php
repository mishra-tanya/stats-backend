<?php

namespace App\Http\Controllers\Db1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponseHelper;

use App\Models\Db1\Magazines;

class MagazinesController extends Controller
{
    // get all magazines with download counts
    public function getMagazines()
    {
        try {
            $magazines = Magazines::all();
            return apiSuccess($magazines, 'Magazines fetched successfully');

        } catch (\Exception $e) {
            return apiError('Failed to fetch Magazines', 500);
        }
    }
    
}
