<?php

namespace App\Models\Db4;

use Illuminate\Database\Eloquent\Model;

class EmissionFactor extends Model
{
    protected $connection = 'mysql4'; 
    protected $table = 'finance_emissionfactor';
}
