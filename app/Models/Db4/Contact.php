<?php

namespace App\Models\Db4;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $connection = 'mysql4'; 
    protected $table = 'finance_contactmessages';
}
