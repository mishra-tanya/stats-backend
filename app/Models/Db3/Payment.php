<?php

namespace App\Models\Db3;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $connection = 'mysql3'; 
    protected $table = 'payments';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
