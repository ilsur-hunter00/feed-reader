<?php

use App\Http\Controllers\FeedController;
use Illuminate\Support\Facades\Route;

Route::prefix('feeds')->group(function () {
    Route::get('/', [FeedController::class, 'index']);
});
