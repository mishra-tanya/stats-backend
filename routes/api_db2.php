<?php

use Illuminate\Support\Facades\Route;

Route::prefix('db2')->group(function () {
    Route::get('/test', fn () => response()->json(['db2' => 'working']));
});
