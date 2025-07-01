<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Db4\UserController;
use App\Http\Controllers\Db4\StatsController;
use App\Http\Controllers\Db4\EmissionController;


Route::middleware(['admin.auth'])->prefix('db4')->group(function () {
    Route::get('/users', [UserController::class, 'getUser']);

    Route::get('/get-stats', [StatsController::class, 'getStats']);
    Route::get('/daily-stats', [StatsController::class, 'getDailyStats']);
    Route::get('/weekly-stats', [StatsController::class, 'getWeeklyStats']);
    Route::get('/monthly-stats', [StatsController::class, 'getMonthlyStats']);
    Route::get('/registration-stats', [StatsController::class, 'registrationStats']);
    Route::get('/emission-stats', [StatsController::class, 'emission']);

    Route::get('finance-emissions', [EmissionController::class, 'index']);
    Route::get('finance-emissions/{userId}', [EmissionController::class, 'show']);


});
