<?php

namespace App\Http\Controllers\Db1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StatsService;

class StatsController extends Controller
{
    protected $statsService;

    public function __construct(StatsService $statsService)
    {
        $this->statsService = $statsService;
    }

    public function getStats()
    {
        $data = $this->statsService->getStatsDb1();
        return $this->handleSuccess($data, 'Stats fetched successfully');
    }

}
