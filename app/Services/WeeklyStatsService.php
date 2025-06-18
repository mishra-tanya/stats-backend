<?php

namespace App\Services;
use Carbon\Carbon;

use App\Models\Db2\User as Db2User;
use App\Models\Db2\ContactMessages;
use App\Models\Db2\LearningObjResult;
use App\Models\Db2\Results;
use App\Models\Db2\TrialRequests;

class WeeklyStatsService
{

    public function getWeeklyStatsDb2(): array
    {
        $startOfWeek = Carbon::now()->startOfWeek();

        return [
            'registered_users' => Db2User::whereBetween('created_at', [$startOfWeek, now()])->count(),
            'contact_messages' => ContactMessages::whereBetween('created_at', [$startOfWeek, now()])->count(),
            'learning_obj_result' => LearningObjResult::whereBetween('created_at', [$startOfWeek, now()])->count(),
            'results' => Results::whereBetween('created_at', [$startOfWeek, now()])->count(),
            'trial_request' => TrialRequests::whereBetween('created_at', [$startOfWeek, now()])->count(),
         ];
    }
}
