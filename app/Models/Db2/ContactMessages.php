<?php

namespace App\Models\Db2;

use Illuminate\Database\Eloquent\Model;

class ContactMessages extends Model
{
    protected $connection = 'mysql2'; 
    protected $table = 'contact_messages';
}
