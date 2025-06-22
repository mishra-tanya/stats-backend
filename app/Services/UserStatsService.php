<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class UserStatsService
{
    public function getStats($model, $dateColumn = 'created_at', $period = 'daily', $connection = null): array
    {
        $query = $model::on($connection)->newQuery();
        $now = Carbon::now();

        switch ($period) {
            case 'weekly':
                $from = $now->copy()->subWeeks(8);
                $format = '%Y-%u'; 
                break;
            case 'monthly':
                $from = $now->copy()->subMonths(12);
                $format = '%Y-%m'; 
                break;
            case 'yearly':
                $from = $now->copy()->subYears(5);
                $format = '%Y';
                break;
            case 'daily':
            default:
                $from = $now->copy()->subDays(14);
                $format = '%Y-%m-%d'; 
                break;
        }

        $records = $query
            ->where($dateColumn, '>=', $from)
            ->selectRaw("DATE_FORMAT($dateColumn, '{$format}') as period, COUNT(*) as users")
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        return $records->map(function ($row) {
            return [
                'name' => $row->period,
                'date' => $row->period,
                'users' => (int) $row->users,
                'revenue' => rand(200, 1000), 
            ];
        })->toArray();
    }
}
