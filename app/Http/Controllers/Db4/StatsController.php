<?php

namespace App\Http\Controllers\Db4;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ApiResponseHelper;

use App\Services\StatsService;
use App\Services\DailyStatsService;
use App\Services\WeeklyStatsService;
use App\Services\MonthlyStatsService;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        $data = $this->stats->getStatsdb4();
        return $this->handleSuccess($data, 'General stats fetched successfully');
    }

    // daily stats
    public function getDailyStats()
    {
        $data = $this->dailyStats->getDailyStatsdb4();
        return $this->handleSuccess($data, 'Daily stats fetched successfully');
    }

    // weekly 
    public function getWeeklyStats()
    {
        $data = $this->weeklyStats->getWeeklyStatsdb4();
        return $this->handleSuccess($data, 'Weekly stats fetched successfully');
    }

    // mnontly 
    public function getMonthlyStats()
    {
        $data = $this->monthlyStats->getMonthlyStatsdb4();
        return $this->handleSuccess($data, 'Monthly stats fetched successfully');
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

        $results = DB::connection('mysql4') 
            ->table('auth_user')       
            ->selectRaw('DATE(date_joined) as date, COUNT(*) as users')
            ->where('date_joined', '>=', $fromDate)
            ->groupBy(DB::raw('DATE(date_joined)'))
            ->orderBy('date')
            ->get();

        $data = collect($results)->map(function ($item) {
            return [
                'name' => $item->date,
                'users' => $item->users,
                'revenue' => $item->users * 100 
            ];
        });

        return $this->handleSuccess($data, 'User track data fetched successfully');
    }

    public function emission(Request $request)
    {
        $range = (int) $request->query('range', 7); 
        $startDate = now()->subDays($range)->startOfDay();

        $data = DB::connection('mysql4') 
            ->table('finance_emissionfactor')  
            ->selectRaw('DATE(created_at) as date, COUNT(*) as emissions_count')
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($record) use ($range) {
                $carbonDate = Carbon::parse($record->date);

                return [
                    'name' => match (true) {
                        $range <= 30 => $carbonDate->format('M d'),
                        $range <= 180 => 'W' . $carbonDate->weekOfYear,
                        default => $carbonDate->format('M')
                    },
                    'users' => (int) $record->emissions_count,
                    'date' => $record->date,
                ];
            });

        return $this->handleSuccess($data, 'Emission track data fetched successfully');
    }
}
