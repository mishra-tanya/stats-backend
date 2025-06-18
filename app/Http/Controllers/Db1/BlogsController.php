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
        return $this->fetchAll(BlogPosts::class, 'Blogs fetched successfully');
    }
}
