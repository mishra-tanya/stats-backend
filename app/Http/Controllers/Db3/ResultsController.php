<?php

namespace App\Http\Controllers\Db3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Db3\Result;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ResultsController extends Controller
{
    private $sdgGoals = [
        1 => 'No Poverty',
        2 => 'Zero Hunger',
        3 => 'Good Health and Well-being',
        4 => 'Quality Education',
        5 => 'Gender Equality',
        6 => 'Clean Water and Sanitation',
        7 => 'Affordable and Clean Energy',
        8 => 'Decent Work and Economic Growth',
        9 => 'Industry, Innovation and Infrastructure',
        10 => 'Reduced Inequality',
        11 => 'Sustainable Cities and Communities',
        12 => 'Responsible Consumption and Production',
        13 => 'Climate Action',
        14 => 'Life Below Water',
        15 => 'Life on Land',
        16 => 'Peace, Justice and Strong Institutions',
        17 => 'Partnerships for the Goals',
    ];

    public function getResultsWithEmail()
    {
        $results = Result::with('user:id,id,email')->get();

        $mappedResults = $results->map(function ($result) {
            return $this->transformResult($result);
        });

        return $this->handleSuccess($mappedResults, 'Results with user email and goal names fetched successfully');
    }

    public function resultsByUserId($id)
    {
        $results = Result::with('user:id,id,email')
            ->where('user_id', $id)
            ->get();

        $mappedResults = $results->map(function ($result) {
            return $this->transformResult($result);
        });

        return $this->handleSuccess($mappedResults, "Results for user ID $id fetched successfully");
    }

    public function resultsStats(Request $request)
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

        $stats = DB::connection('mysql3')
            ->table('results')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total_results')
            ->where('created_at', '>=', $fromDate)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        $data = collect($stats)->map(function ($item) {
            return [
                'name' => $item->date,
                'results' => $item->total_results,
            ];
        });

        return $this->handleSuccess($data, 'Result statistics fetched successfully');
    }

    private function transformResult($result)
    {
        $goalId = (int) $result->goal_id;
        $mappedGoalId = ($goalId % 17 === 0) ? 17 : $goalId % 17;
        $goalName = $this->sdgGoals[$mappedGoalId] ?? 'Unknown Goal';

        return [
            'id' => $result->id,
            'user_id' => $result->user_id,
            'user_email' => optional($result->user)->email,
            'class_id' => $result->class_id,
            'test_id' => $result->test_id,
            'goal_id' => $goalId,
            'goal_name' => $goalName,
            'score' => $result->score,
            'created_at' => $result->created_at,
        ];
    }
}
