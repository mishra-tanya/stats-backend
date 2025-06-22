<?php
namespace App\Services;

use App\Models\Db4\EmissionFactor;

class FinanceEmissionService
{
    public function getAllEmissions()
    {
        return EmissionFactor::with('user:id,username,first_name,last_name')
            ->orderByDesc('created_at')
            ->get();
    }

    public function getEmissionByUser($userId)
    {
        return EmissionFactor::with('user:id,username,first_name,last_name')
            ->where('user_id_id', $userId)
            ->first();
    }
}
