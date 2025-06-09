<?php

namespace App\Http\Controllers\Db1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponseHelper;

use App\Models\Db1\BlogPosts;

class BlogsController extends Controller
{
    // get all blogs with categories
    public function getBlogs()
    {
        try {
            $blogs = BlogPosts::with('category')->get();
            return apiSuccess($blogs, 'Blogs fetched successfully');

        } catch (\Exception $e) {
            return apiError('Failed to fetch blogs', 500);
        }
    }

}
