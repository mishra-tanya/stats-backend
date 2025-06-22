<?php

namespace App\Models\Db4;

use Illuminate\Database\Eloquent\Model;
use App\Models\Db4\User; 

class EmissionFactor extends Model
{
    protected $connection = 'mysql4'; 
    protected $table = 'finance_emissionfactor';
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id_id');
    }
}
