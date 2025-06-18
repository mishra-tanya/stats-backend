<?php

namespace App\Services;

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
        return [
            'registered_users' => Db2User::count(),
            'contact_messages' => ContactMessages::count(),
            'flash_name' => FlashName::count(),
            'flash_question' => FlashQuestion::count(),
            'learning_obj_name' => LearningObjName::count(),
            'learning_obj_question' => LearningObjQuestion::count(),
            'learning_obj_result' => LearningObjResult::count(),
            'notes' => Notes::count(),
            'question_limit' => QuestionLimit::count(),
            'results' => Results::count(),
            'scr_question' => SCRQuestion::count(),
            'trial_request' => TrialRequests::count(),
        ];
    }
}
