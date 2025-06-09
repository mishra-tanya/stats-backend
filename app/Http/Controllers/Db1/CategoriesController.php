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
        try {
            $categories = BlogCategories::all();
            return apiSuccess($categories, 'Categories fetched successfully');

        } catch (\Exception $e) {
            return apiError('Failed to fetch Categories', 500);
        }
    }

}
