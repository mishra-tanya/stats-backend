<?php

namespace App\Http\Controllers\Db2;

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
}
