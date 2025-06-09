<?php

use Illuminate\Support\Facades\Route;

Route::prefix('db4')->group(function () {
    Route::get('/test', fn () => response()->json(['db4' => 'working']));
});
