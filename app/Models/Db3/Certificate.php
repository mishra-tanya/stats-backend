<?php

namespace App\Models\Db3;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $connection = 'mysql3'; 
    protected $table = 'certificate';
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
