<?php

namespace App\Services;
use Carbon\Carbon;

use App\Models\Db2\User as Db2User;
use App\Models\Db2\ContactMessages;
use App\Models\Db2\LearningObjResult;
use App\Models\Db2\Results;
use App\Models\Db2\TrialRequests;

class DailyStatsService
{

    public function getDailyStatsDb2(): array
    {
        $today = Carbon::today();

        return [
            'registered_users' => Db2User::whereDate('created_at', $today)->count(),
            'contact_messages' => ContactMessages::whereDate('created_at', $today)->count(),
            'learning_obj_result' => LearningObjResult::whereDate('created_at', $today)->count(),
            'results' => Results::whereDate('created_at', $today)->count(),
            'trial_request' => TrialRequests::whereDate('created_at', $today)->count(),
         ];
    }
}
