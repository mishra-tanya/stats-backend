<?php

use Illuminate\Support\Facades\Route;

Route::prefix('db3')->group(function () {
    Route::get('/test', fn () => response()->json(['db3' => 'working']));
});
