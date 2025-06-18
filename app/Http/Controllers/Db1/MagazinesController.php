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
        return $this->fetchAll(Magazines::class, 'Magazines fetched successfully');
    }
    
}
