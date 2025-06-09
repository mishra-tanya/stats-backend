<?php

namespace App\Models\Db1;

use Illuminate\Database\Eloquent\Model;

class Magazines extends Model
{
    protected $connection = 'mysql'; 
    protected $table = 'magazine_downloads';
}
