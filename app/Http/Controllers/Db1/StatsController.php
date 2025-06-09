<?php

namespace App\Http\Controllers\Db1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Db1\BlogCategories;
use App\Models\Db1\BlogPosts;
use App\Models\Db1\Magazines;
use App\Models\Db1\SubscribedUser;
use App\Models\Db1\User;

class StatsController extends Controller
{
     public function getStats()
    {
        try {
            $categoriesCount = BlogCategories::count();
            $blogCount = BlogPosts::count();
            $registeredUsers = User::count();
            $subscriptionsCount = SubscribedUser::count();
            $magazinesCount = Magazines::count();

            $data = [
                'categories_count' => $categoriesCount,
                'subscriptions_count' => $subscriptionsCount,
                'magazines_count' => $magazinesCount,
                'blog_count' => $blogCount,
                'registered_users' => $registeredUsers,
            ];

            return apiSuccess($data, 'Stats fetched successfully');

        } catch (\Exception $e) {
            \Log::error('StatsController@getStats error: ' . $e->getMessage());

            return apiError('Failed to fetch stats', 500, $e->getMessage());
        }
    }

}
