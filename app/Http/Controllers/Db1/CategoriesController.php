<?php

namespace App\Http\Controllers\Db1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponseHelper;

use App\Models\Db1\BlogCategories;

class CategoriesController extends Controller
{
    // get all blog categories
    public function getCategories()
    {
        return $this->fetchAll(BlogCategories::class, 'Categories fetched successfully');
    }

}
