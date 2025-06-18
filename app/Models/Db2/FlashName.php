<?php

namespace App\Models\Db2;

use Illuminate\Database\Eloquent\Model;

class FlashName extends Model
{
    protected $connection = 'mysql2'; 
    protected $table = 'flash_test';
}
