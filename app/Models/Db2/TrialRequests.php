<?php

namespace App\Models\Db2;

use Illuminate\Database\Eloquent\Model;

class TrialRequests extends Model
{
    protected $connection = 'mysql2'; 
    protected $table = 'trial_requests';
}
