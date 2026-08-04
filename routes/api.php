<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// PROTECTED BY API KEY
Route::middleware(['api.key', 'throttle:60,1'])->group(function () {
    Route::get('/', function () {
        return "Ok";
    });

    // AUTH ROUTES
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);

        // PROTECTED BY AUTH SANCTUM
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
        });
    });
    // USERS ROUTES
    Route::prefix('users')->group(function () {
        // PROTECTED BY AUTH SANCTUM
        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/me', [UserController::class, 'me']);
            Route::put('/me', [UserController::class, 'updateMe']);
            
            Route::put('/{user}', [UserController::class, 'update']);
        });
    });


});
