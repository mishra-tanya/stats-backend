<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Db3\UserController;
use App\Http\Controllers\Db3\ContactController;
use App\Http\Controllers\Db3\StatsController;
use App\Http\Controllers\Db3\CertificateController;
use App\Http\Controllers\Db3\PaymentController;
use App\Http\Controllers\Db3\ResultsController;

Route::prefix('db3')->group(function () {
    Route::get('/users', [UserController::class, 'getUser']);
    Route::get('/class-wise', [UserController::class, 'getClassWiseUserData']);
    Route::get('/all-goal-completion', [UserController::class, 'getGoalCompletionStatsByClass']);
    Route::get('/goal-completion', [UserController::class, 'getGoalWiseUserCompletion']);

    Route::get('/contact-messages', [ContactController::class, 'getContactMessages']);

    Route::get('/get-stats', [StatsController::class, 'getStats']);
    Route::get('/daily-stats', [StatsController::class, 'getDailyStats']);
    Route::get('/weekly-stats', [StatsController::class, 'getWeeklyStats']);
    Route::get('/monthly-stats', [StatsController::class, 'getMonthlyStats']);
    // Route::get('/registration-stats', [StatsController::class, 'registrationStats']);
    Route::get('/registration-trends', [StatsController::class, 'registrationTrends']);
    Route::get('/reg-stats', [StatsController::class, 'getUserCardStats']);

    Route::get('/certificate', [CertificateController::class, 'getCertificate']);
    Route::get('/certificate-stats', [CertificateController::class, 'certificateStats']);

    Route::get('/payment', [PaymentController::class, 'getPayment']);
    Route::get('/payment-stats', [PaymentController::class, 'paymentStats']);

    Route::get('/results', [ResultsController::class, 'getResultsWithEmail']);
    Route::get('/results/{id}', [ResultsController::class, 'resultsByUserId']);
    Route::get('/results-stats', [ResultsController::class, 'resultsStats']);



});
