<?php

namespace App\Models\Db1;

use Illuminate\Database\Eloquent\Model;

class BlogPosts extends Model
{
    protected $connection = 'mysql'; 
    protected $table = 'blog_post';
    
    public function category()
    {
        return $this->belongsTo(BlogCategories::class, 'cat_id');
    }
}
