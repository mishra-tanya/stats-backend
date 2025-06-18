<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Db2\UserController;
use App\Http\Controllers\Db2\ContactMessageController;
use App\Http\Controllers\Db2\FlashNameController;
use App\Http\Controllers\Db2\FlashQuestionController;
use App\Http\Controllers\Db2\LearningObjNameController;
use App\Http\Controllers\Db2\LearningObjQuestionController;
use App\Http\Controllers\Db2\LearningObjResultController;
use App\Http\Controllers\Db2\NotesController;
use App\Http\Controllers\Db2\QuestionLimitController;
use App\Http\Controllers\Db2\ResultsController;
use App\Http\Controllers\Db2\SCRQuestionController;
use App\Http\Controllers\Db2\StatsController;
use App\Http\Controllers\Db2\TrialRequestController;

Route::prefix('db2')->group(function () {

    Route::get('/users', [UserController::class, 'getUser']);
    Route::get('/users/{id}', [UserController::class, 'getUserById']);
    
    Route::get('/contact-messages', [ContactMessageController::class, 'getContactMessages']);

    Route::get('/flash-name', [FlashNameController::class, 'getFlashName']);

    Route::get('/notes', [NotesController::class, 'getNotes']);

    Route::get('/flash-question', [FlashQuestionController::class, 'getFlashQuestion']);

    Route::get('/lo-name', [LearningObjNameController::class, 'getLearningObjName']);

    Route::get('/lo-question', [LearningObjQuestionController::class, 'getLearningObjQuestion']);

    Route::get('/lo-result', [LearningObjResultController::class, 'getLearningObjResult']);

    Route::get('/scr-result', [ResultsController::class, 'getSCRResult']);

    Route::get('/question-limit', [QuestionLimitController::class, 'getQuestionLimit']);

    Route::get('/scr-question', [SCRQuestionController::class, 'getSCRQuestion']);

    Route::get('/trial-request', [TrialRequestController::class, 'getTrialRequests']);

    Route::get('/get-stats', [StatsController::class, 'getStats']);
    Route::get('/daily-stats', [StatsController::class, 'getDailyStats']);
    Route::get('/weekly-stats', [StatsController::class, 'getWeeklyStats']);
    Route::get('/monthly-stats', [StatsController::class, 'getMonthlyStats']);

});
