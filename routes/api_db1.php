<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Db1\UserController;
use App\Http\Controllers\Db1\BlogsController;
use App\Http\Controllers\Db1\CategoriesController;
use App\Http\Controllers\Db1\MagazinesController;
use App\Http\Controllers\Db1\StatsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\GAnalyticsController;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['admin.auth'])->group(function () {

    Route::get('/analytics/site/{site}', [GAnalyticsController::class, 'getSiteAnalytics']);
    Route::get('/analytics/city/{site}', [GAnalyticsController::class, 'getUsersByCity']);
});

Route::middleware(['admin.auth'])->prefix('db1')->group(function () {

    Route::get('/users', [UserController::class, 'login']);
    Route::get('/subscribed-users', [UserController::class, 'subscribed']);

    Route::get('/get-blogs', [BlogsController::class, 'getBlogs']);

    Route::get('/get-blog-categories', [CategoriesController::class, 'getCategories']);

    Route::get('/get-magazines', [MagazinesController::class, 'getMagazines']);

    Route::get('/get-stats', [StatsController::class, 'getStats']);

    Route::get('notifications/milestones', [NotificationController::class, 'getMilestoneNotifications']);
    Route::get('notifications/contacts', [NotificationController::class, 'getContactMessages']);

});
