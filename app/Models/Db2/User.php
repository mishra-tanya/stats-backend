<?php

namespace App\Models\Db2;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $connection = 'mysql2'; 
    protected $table = 'reg_users';

    public function scopeOnlyUsers($query)
    {
        return $query->where('is_admin', 0);
    }
}
