<?php

namespace App\Services;
use Carbon\Carbon;

use App\Models\Db1\BlogCategories;
use App\Models\Db1\BlogPosts;
use App\Models\Db1\Magazines;
use App\Models\Db1\SubscribedUser;
use App\Models\Db1\User as Db1User;

use App\Models\Db2\User as Db2User;
use App\Models\Db2\ContactMessages;
use App\Models\Db2\FlashName;
use App\Models\Db2\FlashQuestion;
use App\Models\Db2\LearningObjName;
use App\Models\Db2\LearningObjQuestion;
use App\Models\Db2\LearningObjResult;
use App\Models\Db2\Notes;
use App\Models\Db2\QuestionLimit;
use App\Models\Db2\Results;
use App\Models\Db2\SCRQuestion;
use App\Models\Db2\TrialRequests;

use App\Models\Db3\Certificate;
use App\Models\Db3\ContactMessages as Db3Contact;
use App\Models\Db3\Goal;
use App\Models\Db3\GoalTest;
use App\Models\Db3\Payment;
use App\Models\Db3\Result as Db3Result;
use App\Models\Db3\TestQuestion;
use App\Models\Db3\User as Db3User;

use App\Models\Db4\EmissionFactor;
use App\Models\Db4\User as Db4User;

class StatsService
{
    public function getStatsDb1(): array
    {
        return [
            'categories_count' => BlogCategories::count(),
            'subscriptions_count' => SubscribedUser::count(),
            'magazines_count' => Magazines::count(),
            'blog_count' => BlogPosts::count(),
            'registered_users' => Db1User::count(),
        ];
    }

    public function getStatsDb2(): array
    {
        $now = Carbon::now();
        $startOfThisMonth = $now->copy()->startOfMonth();
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();

        $stats = [];

        $calcChange = function ($current, $previous) {
            if ($previous == 0) {
                return ['value' => 100, 'type' => 'increase'];
            }
            $change = (($current - $previous) / $previous) * 100;
            return [
                'value' => round(abs($change), 2),
                'type' => $change >= 0 ? 'increase' : 'decrease',
            ];
        };

        // Registered Users
        $current = Db2User::where('created_at', '>=', $startOfThisMonth)->count();
        $previous = Db2User::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $total = Db2User::count();
        $stats['registered_users'] = [
            'value' => $total,
            'change' => $calcChange($current, $previous),
        ];

        // Contact Messages
        $current = ContactMessages::where('created_at', '>=', $startOfThisMonth)->count();
        $previous = ContactMessages::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $total = ContactMessages::count();
        $stats['contact_messages'] = [
            'value' => $total,
            'change' => $calcChange($current, $previous),
        ];

        // Results
        $current = Results::where('created_at', '>=', $startOfThisMonth)->count();
        $previous = Results::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $total = Results::count();
        $stats['results'] = [
            'value' => $total,
            'change' => $calcChange($current, $previous),
        ];

        // Learning Objective Results
        $current = LearningObjResult::where('created_at', '>=', $startOfThisMonth)->count();
        $previous = LearningObjResult::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $total = LearningObjResult::count();
        $stats['learning_obj_result'] = [
            'value' => $total,
            'change' => $calcChange($current, $previous),
        ];

        // Remaining fields with only static counts
        $stats['paid_user'] = Db2User::where('payment_status', 1)->count();
        $stats['verified_user'] = Db2User::where('email_verified', 1)->count();
        $stats['flash_name'] = FlashName::count();
        $stats['flash_question'] = FlashQuestion::count();
        $stats['learning_obj_name'] = LearningObjName::count();
        $stats['learning_obj_question'] = LearningObjQuestion::count();
        $stats['notes'] = Notes::count();
        $stats['question_limit'] = QuestionLimit::count();
        $stats['scr_question'] = SCRQuestion::count();
        $stats['trial_request'] = TrialRequests::count();

        return $stats;
    }

    public function getStatsDb3(): array
    {
        $now = Carbon::now();
        $startOfThisMonth = $now->copy()->startOfMonth();
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();

        $calcChange = function ($current, $previous) {
            if ($previous == 0) {
                return ['value' => 100, 'type' => 'increase'];
            }
            $change = (($current - $previous) / $previous) * 100;
            return [
                'value' => round(abs($change), 2),
                'type' => $change >= 0 ? 'increase' : 'decrease',
            ];
        };

        $stats = [];

        // Registered Users
        $current = Db3User::where('created_at', '>=', $startOfThisMonth)->count();
        $previous = Db3User::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $total = Db3User::count();
        $stats['registered_users'] = [
            'value' => $total,
            'change' => $calcChange($current, $previous),
        ];

        // Contact Messages
        $current = Db3Contact::where('created_at', '>=', $startOfThisMonth)->count();
        $previous = Db3Contact::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $total = Db3Contact::count();
        $stats['contact_messages'] = [
            'value' => $total,
            'change' => $calcChange($current, $previous),
        ];

        // Payments
        $current = Payment::where('status', 'completed')->where('created_at', '>=', $startOfThisMonth)->count();
        $previous = Payment::where('status', 'completed')->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $total = Payment::where('status', 'completed')->count();
        $stats['payments'] = [
            'value' => $total,
            'change' => $calcChange($current, $previous),
        ];

        // Total Revenue (only completed payments)
        $current = Payment::where('status', 'completed')->where('created_at', '>=', $startOfThisMonth)->sum('amount');
        $previous = Payment::where('status', 'completed')->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->sum('amount');
        $total = Payment::where('status', 'completed')->sum('amount');
        $stats['total_revenue'] = [
            'value' => $total,
            'change' => $calcChange($current, $previous),
        ];

        // Results
        $current = Db3Result::where('created_at', '>=', $startOfThisMonth)->count();
        $previous = Db3Result::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $total = Db3Result::count();
        $stats['results'] = [
            'value' => $total,
            'change' => $calcChange($current, $previous),
        ];

        // Other Static Counts
        $stats['goal'] = Goal::count();
        $stats['goal_test'] = GoalTest::count();
        $stats['test_question'] = TestQuestion::count();

        return $stats;
    }

    public function getStatsDb4(): array
    {
        $now = Carbon::now();
        $startOfThisMonth = $now->copy()->startOfMonth();
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();

        $calcChange = function ($current, $previous) {
            if ($previous == 0) {
                return ['value' => 100, 'type' => 'increase'];
            }
            $change = (($current - $previous) / $previous) * 100;
            return [
                'value' => round(abs($change), 2),
                'type' => $change >= 0 ? 'increase' : 'decrease',
            ];
        };

        $stats = [];

        // Registered Users
        $current = Db4User::where('date_joined', '>=', $startOfThisMonth)->count();
        $previous = Db4User::whereBetween('date_joined', [$startOfLastMonth, $endOfLastMonth])->count();
        $total = Db4User::count();
        $stats['registered_users'] = [
            'value' => $total,
            'change' => $calcChange($current, $previous),
        ];

        // Financed Emissions
        $current = EmissionFactor::where('created_at', '>=', $startOfThisMonth)->count();
        $previous = EmissionFactor::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $total = EmissionFactor::count();
        $stats['financed_emission'] = [
            'value' => $total,
            'change' => $calcChange($current, $previous),
        ];

        return $stats;
    }

}
