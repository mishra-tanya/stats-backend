<?php

namespace App\Services;

use Carbon\Carbon;

use App\Traits\CalculatesSpikes;

use App\Models\Db2\User as Db2User;
use App\Models\Db2\ContactMessages;
use App\Models\Db2\LearningObjResult;
use App\Models\Db2\Results;
use App\Models\Db2\TrialRequests;

use App\Models\Db3\ContactMessages as Db3Contact;
use App\Models\Db3\Goal;
use App\Models\Db3\GoalTest;
use App\Models\Db3\Payment;
use App\Models\Db3\Result as Db3Result;
use App\Models\Db3\TestQuestion;
use App\Models\Db3\User as Db3User;

use App\Models\Db4\EmissionFactor;
use App\Models\Db4\User as Db4User;

class DailyStatsService
{
    use CalculatesSpikes;

    public function getDailyStatsDb2(): array
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        $metrics = [
            'registered_users' => [Db2User::class, 'created_at'],
            'contact_messages' => [ContactMessages::class, 'created_at'],
            'learning_obj_result' => [LearningObjResult::class, 'created_at'],
            'results' => [Results::class, 'created_at'],
            'trial_request' => [TrialRequests::class, 'created_at'],
        ];

        $stats = [];

        foreach ($metrics as $key => [$model, $dateField]) {
            $current = $model::whereDate($dateField, $today)->count();
            $previous = $model::whereDate($dateField, $yesterday)->count();

            $stats[$key] = [
                'current' => $current,
                'previous' => $previous,
                'spike_percentage' => $this->calculateSpike($current, $previous),
            ];
        }

        return $stats;
    }

    public function getDailyStatsDb3(): array
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        $metrics = [
            'registered_users' => [Db3User::class, 'created_at'],
            'contact_messages' => [Db3Contact::class, 'created_at'],
            'goal' => [Goal::class, 'created_at'],
            'goal_test' => [GoalTest::class, 'created_at'],
            'payment' => [Payment::class, 'created_at'],
            'Db3Result' => [Db3Result::class, 'created_at'],
            'test_question' => [TestQuestion::class, 'created_at'],
        ];

        $stats = [];

        foreach ($metrics as $key => [$model, $dateField]) {
            $current = $model::whereDate($dateField, $today)->count();
            $previous = $model::whereDate($dateField, $yesterday)->count();

            $stats[$key] = [
                'current' => $current,
                'previous' => $previous,
                'spike_percentage' => $this->calculateSpike($current, $previous),
            ];
        }

        $todayRevenue = Payment::where('status', 'completed')
            ->whereDate('created_at', $today)
            ->sum('amount');

        $yesterdayRevenue = Payment::where('status', 'completed')
            ->whereDate('created_at', $yesterday)
            ->sum('amount');

        $stats['total_revenue'] = [
            'current' => $todayRevenue,
            'previous' => $yesterdayRevenue,
            'spike_percentage' => $this->calculateSpike($todayRevenue, $yesterdayRevenue),
        ];

        return $stats;
    }

    public function getDailyStatsDb4(): array
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        $metrics = [
            'registered_users' => [Db4User::class, 'date_joined'],
            'financed_emission' => [EmissionFactor::class, 'created_at'],
        ];

        $stats = [];

        foreach ($metrics as $key => [$model, $dateField]) {
            $current = $model::whereDate($dateField, $today)->count();
            $previous = $model::whereDate($dateField, $yesterday)->count();

            $stats[$key] = [
                'current' => $current,
                'previous' => $previous,
                'spike_percentage' => $this->calculateSpike($current, $previous),
            ];
        }

        return $stats;
    }
}
