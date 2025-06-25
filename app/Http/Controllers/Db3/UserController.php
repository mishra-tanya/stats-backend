<?php

namespace App\Http\Controllers\Db3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Db3\User;

class UserController extends Controller
{
    
    public function getUser()
    {
        return $this->fetchAll(User::class, 'Users fetched successfully');
    }

     public function getClassWiseUserData()
    {
        $rawData = User::selectRaw('class, COUNT(*) as count')
            ->groupBy('class')
            ->get();

        $colors = [
            '#34d399', // emerald
            '#22d3ee', // cyan
            '#3b82f6', // blue
            '#f59e0b', // amber
            '#ef4444', // red
            '#8b5cf6', // violet
            '#10b981', // green
        ];

        $data = $rawData->map(function ($item, $index) use ($colors) {
            return [
                'name' => 'Class ' . $item->class,
                'value' => $item->count,
                'fill' => $colors[$index % count($colors)],
            ];
        });

        return $this->handleSuccess($data, 'Class-wise user data fetched successfully');
    }

    public function getGoalCompletionStatsByClass()
    {
        $requiredGoals = range(1, 17);

        $results = DB::connection('mysql3')
            ->table('results')
            ->select('user_id', 'class_id', 'goal_id')
            ->get();

        $grouped = $results->groupBy(function ($item) {
            return $item->user_id . '_' . $item->class_id;
        });

        $qualifiedUsersPerClass = [];

        foreach ($grouped as $key => $userResults) {
            $sample = $userResults->first();
            $classId = $sample->class_id;

            $goalCounts = $userResults->groupBy(function ($item) {
                $gid = (int) $item->goal_id;
                return ($gid % 17 === 0) ? 17 : $gid % 17;
            })->map(fn($items) => count($items));

            $hasAllGoals = collect($requiredGoals)->every(function ($goalId) use ($goalCounts) {
                return isset($goalCounts[$goalId]) && $goalCounts[$goalId] >= 3;
            });

            if ($hasAllGoals) {
                $qualifiedUsersPerClass[$classId] = ($qualifiedUsersPerClass[$classId] ?? 0) + 1;
            }
        }

        $colors = ['#34d399', '#22d3ee', '#3b82f6', '#f59e0b', '#ef4444', '#8b5cf6', '#10b981'];
        $chartData = [];

        foreach (range(4, 10) as $i => $classId) {
            $chartData[] = [
                'name' => "Class $classId",
                'value' => $qualifiedUsersPerClass[$classId] ?? 0,
                'fill' => $colors[$i % count($colors)]
            ];
        }

        return $this->handleSuccess($chartData, 'Users who completed all 17 goals (3 times each) by class');
    }

    public function getGoalWiseUserCompletion()
    {
        $goalNames = [
            1 => 'No Poverty', 2 => 'Zero Hunger', 3 => 'Good Health and Well-being',
            4 => 'Quality Education', 5 => 'Gender Equality', 6 => 'Clean Water and Sanitation',
            7 => 'Affordable and Clean Energy', 8 => 'Decent Work and Economic Growth',
            9 => 'Industry, Innovation and Infrastructure', 10 => 'Reduced Inequality',
            11 => 'Sustainable Cities and Communities', 12 => 'Responsible Consumption and Production',
            13 => 'Climate Action', 14 => 'Life Below Water', 15 => 'Life on Land',
            16 => 'Peace, Justice and Strong Institutions', 17 => 'Partnerships for the Goals',
        ];

        $results = DB::connection('mysql3')
            ->table('results')
            ->select('user_id', 'class_id', 'goal_id')
            ->get();

        $goalUserCounts = array_fill_keys(range(1, 17), []);

        $grouped = $results->groupBy(function ($item) {
            return $item->user_id . '_' . $item->class_id;
        });

        foreach ($grouped as $group) {
            $userId = $group->first()->user_id;
            $classId = $group->first()->class_id;

            $goalCounts = $group->groupBy(function ($item) {
                $gid = (int) $item->goal_id;
                return ($gid % 17 === 0) ? 17 : $gid % 17;
            })->map(fn($items) => count($items));

            foreach (range(1, 17) as $goalId) {
                if (isset($goalCounts[$goalId]) && $goalCounts[$goalId] >= 3) {
                    $goalUserCounts[$goalId][] = "$userId-$classId"; 
                }
            }
        }

        $chartData = [];
        foreach (range(1, 17) as $goalId) {
            $uniqueUsers = array_unique($goalUserCounts[$goalId]);
            $chartData[] = [
                'name' => $goalNames[$goalId],
                'value' => count($uniqueUsers),
            ];
        }

        return $this->handleSuccess($chartData, 'Users who comp');
    }

}
