<?php

namespace App\Http\Controllers\Db3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\StatsService;
use App\Services\DailyStatsService;
use App\Services\WeeklyStatsService;
use App\Services\MonthlyStatsService;

use App\Models\Db3\User;
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
        $data = $this->stats->getStatsDb3();
        return $this->handleSuccess($data, 'General stats fetched successfully');
    }

    // daily stats
    public function getDailyStats()
    {
        $data = $this->dailyStats->getDailyStatsDb3();
        return $this->handleSuccess($data, 'Daily stats fetched successfully');
    }

    // weekly 
    public function getWeeklyStats()
    {
        $data = $this->weeklyStats->getWeeklyStatsDb3();
        return $this->handleSuccess($data, 'Weekly stats fetched successfully');
    }

    // mnontly 
    public function getMonthlyStats()
    {
        $data = $this->monthlyStats->getMonthlyStatsDb3();
        return $this->handleSuccess($data, 'Monthly stats fetched successfully');
    }

    public function registrationTrends(Request $request)
    {
        $range = $request->query('range', '30'); 
        $range = in_array($range, ['7', '15', '30', '90', '180', '365']) ? (int)$range : 30;

        $data = [];
        $now = Carbon::now();
        $startDate = $now->copy()->subDays($range - 1);

        for ($i = 0; $i < $range; $i++) {
            $date = $startDate->copy()->addDays($i);
            $label = $date->format('M d');

            $count = User::whereDate('created_at', $date->toDateString())->count();

            $data[] = [
                'name' => $label,
                'users' => $count,
                'date' => $date->toDateString()
            ];
        }

        return $this->handleSuccess($data, ' Stats fetched successfully');
    }

    public function getUserCardStats()
    {
        $now = Carbon::now();
        $lastWeek = $now->copy()->subDays(7);
        $lastMonth = $now->copy()->subMonth();

        $weeklyCount = User::where('created_at', '>=', $lastWeek)->count();
        $monthlyCount = User::where('created_at', '>=', $lastMonth)->count();

        $data = [
            'weekly' => $weeklyCount,
            'monthly' => $monthlyCount,
        ];

        return $this->handleSuccess($data, 'Weekly stats fetched successfully');
    }

}
