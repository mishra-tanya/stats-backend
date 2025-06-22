<?php

namespace App\Http\Controllers\Db2;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Controllers\Controller;
use App\Helpers\ApiResponseHelper;

use App\Services\StatsService;
use App\Services\DailyStatsService;
use App\Services\WeeklyStatsService;
use App\Services\MonthlyStatsService;

class StatsController extends Controller
{
    protected $stats;
    protected $dailyStats;
    protected $weeklyStats;
    protected $monthlyStats;

    public function __construct(
        StatsService $stats,
        DailyStatsService $dailyStats,
        WeeklyStatsService $weeklyStats,
        MonthlyStatsService $monthlyStats
    ) {
        $this->stats = $stats;
        $this->dailyStats = $dailyStats;
        $this->weeklyStats = $weeklyStats;
        $this->monthlyStats = $monthlyStats;
    }

    // general stats
    public function getStats()
    {
        $data = $this->stats->getStatsDb2();
        return $this->handleSuccess($data, 'General stats fetched successfully');
    }

    // daily stats
    public function getDailyStats()
    {
        $data = $this->dailyStats->getDailyStatsDb2();
        return $this->handleSuccess($data, 'Daily stats fetched successfully');
    }

    // weekly 
    public function getWeeklyStats()
    {
        $data = $this->weeklyStats->getWeeklyStatsDb2();
        return $this->handleSuccess($data, 'Weekly stats fetched successfully');
    }

    // mnontly 
    public function getMonthlyStats()
    {
        $data = $this->monthlyStats->getMonthlyStatsDb2();
        return $this->handleSuccess($data, 'Monthly stats fetched successfully');
    }

    public function countryDistribution()
    {
        $res = DB::connection('mysql2') 
            ->table('reg_users')
            ->select('country', DB::raw('COUNT(*) as value'))
            ->groupBy('country')
            ->orderByDesc('value')
            ->get();

        $colors = [
            '#10B981', '#06B6D4', '#3B82F6', '#8B5CF6', '#EC4899',
            '#F59E0B', '#EF4444', '#14B8A6', '#F97316', '#6366F1'
        ];

        $data = $res->map(function ($item, $index) use ($colors) {
            return [
                'name' => $item->country ?? 'Unknown',
                'value' => $item->value,
                'fill' => $colors[$index % count($colors)],
            ];
        });

        return $this->handleSuccess($data, 'Weekly stats fetched successfully');
    }

    public function registrationStats(Request $request)
    {
        $range = $request->query('range', '7'); 
        $days = match ($range) {
            '7' => 7,
            '15' => 15,
            '30' => 30,
            '90' => 90,
            '180' => 180,
            '365' => 365,
            default => 7
        };

        $fromDate = Carbon::now()->subDays($days)->startOfDay();

        $results = DB::connection('mysql2') 
            ->table('reg_users')       
            ->selectRaw('DATE(created_at) as date, COUNT(*) as users')
            ->where('created_at', '>=', $fromDate)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        $data = collect($results)->map(function ($item) {
            return [
                'name' => $item->date,
                'users' => $item->users,
            ];
        });

        return $this->handleSuccess($data, 'User track data fetched successfully');
    }

    public function loStats(Request $request)
    {
        $range = $request->query('range', '7'); 
        $days = match ($range) {
            '7' => 7,
            '15' => 15,
            '30' => 30,
            '90' => 90,
            '180' => 180,
            '365' => 365,
            default => 7
        };

        $fromDate = Carbon::now()->subDays($days)->startOfDay();

        $results = DB::connection('mysql2') 
            ->table('lo_results')       
            ->selectRaw('DATE(created_at) as date, COUNT(*) as users')
            ->where('created_at', '>=', $fromDate)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        $data = collect($results)->map(function ($item) {
            return [
                'name' => $item->date,
                'users' => $item->users,
            ];
        });

        return $this->handleSuccess($data, 'Lo results track data fetched successfully');
    }

    public function scrStats(Request $request)
    {
        $range = $request->query('range', '7'); 
        $days = match ($range) {
            '7' => 7,
            '15' => 15,
            '30' => 30,
            '90' => 90,
            '180' => 180,
            '365' => 365,
            default => 7
        };

        $fromDate = Carbon::now()->subDays($days)->startOfDay();

        $results = DB::connection('mysql2') 
            ->table('results')       
            ->selectRaw('DATE(created_at) as date, COUNT(*) as users')
            ->where('created_at', '>=', $fromDate)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        $data = collect($results)->map(function ($item) {
            return [
                'name' => $item->date,
                'users' => $item->users,
            ];
        });

        return $this->handleSuccess($data, 'SCR results track data fetched successfully');
    }
}
