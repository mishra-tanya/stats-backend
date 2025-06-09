<?php

namespace App\Models\Db1;

use Illuminate\Database\Eloquent\Model;

class BlogCategories extends Model
{
    protected $connection = 'mysql'; 
    protected $table = 'category_name';
    
    public function blogPosts()
    {
        return $this->hasMany(BlogPosts::class, 'cat_id');
    }
}
