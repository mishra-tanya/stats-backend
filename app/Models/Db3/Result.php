<?php

namespace App\Models\Db3;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $connection = 'mysql3'; 
    protected $table = 'results';
    
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
