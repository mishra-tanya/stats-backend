<?php

namespace App\Models\Db1;

use Illuminate\Database\Eloquent\Model;

class SubscribedUser extends Model
{
    protected $connection = 'mysql'; 
    protected $table = 'subscribed';
}
