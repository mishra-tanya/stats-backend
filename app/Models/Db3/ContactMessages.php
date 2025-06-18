<?php

namespace App\Models\Db3;

use Illuminate\Database\Eloquent\Model;

class ContactMessages extends Model
{
    protected $connection = 'mysql3'; 
    protected $table = 'contacts';
}
