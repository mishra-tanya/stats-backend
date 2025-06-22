<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Db3\UserController;
use App\Http\Controllers\Db3\ContactController;
use App\Http\Controllers\Db3\StatsController;

Route::prefix('db3')->group(function () {
    Route::get('/users', [UserController::class, 'getUser']);

    Route::get('/contact-messages', [ContactController::class, 'getContactMessages']);

    Route::get('/get-stats', [StatsController::class, 'getStats']);
    Route::get('/daily-stats', [StatsController::class, 'getDailyStats']);
    Route::get('/weekly-stats', [StatsController::class, 'getWeeklyStats']);
    Route::get('/monthly-stats', [StatsController::class, 'getMonthlyStats']);
    Route::get('/registration-stats', [StatsController::class, 'registrationStats']);
    Route::get('/registration-trends', [StatsController::class, 'registrationTrends']);
    Route::get('/reg-stats', [StatsController::class, 'getUserCardStats']);


});
