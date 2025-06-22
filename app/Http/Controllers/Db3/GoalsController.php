<?php

namespace App\Http\Controllers\Db3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Db3\Goal;
use App\Models\Db3\GoalTest;

class GoalsController extends Controller
{
    public function getGoals()
    {
        return $this->fetchAll(Goal::class, 'Goals fetched successfully');
    }

    public function getGoalsTest()
    {
        return $this->fetchAll(GoalTest::class, 'Goal Test fetched successfully');
    }
}
