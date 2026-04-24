<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;

Route::middleware('throttle:60,1')->group(function () {

    Route::prefix('products')->group(function () {

        Route::post('/{product}/stock', [ProductController::class, 'adjustStock']);

        Route::get('/low-stock', [ProductController::class, 'lowStock']);

        Route::get('/', [ProductController::class, 'index']);

        Route::post('/', [ProductController::class, 'store']);

        Route::get('/{product}', [ProductController::class, 'show']);

        Route::put('/{product}', [ProductController::class, 'update']);

        Route::delete('/{product}', [ProductController::class, 'destroy']);
    });
    
});