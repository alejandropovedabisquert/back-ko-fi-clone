<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\Role\PermissionController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api.key', 'throttle:60,1'])->group(function () {

    Route::get('/', fn() => 'Ok');

    /*
    |--------------------------------------------------------------------------
    | AUTH
    |--------------------------------------------------------------------------
    */

    Route::prefix('auth')->group(function () {

        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
        });
    });

    /*
    |--------------------------------------------------------------------------
    | PUBLIC POSTS
    |--------------------------------------------------------------------------
    */

    Route::prefix('posts')->group(function () {

        Route::get('/', [PostController::class, 'index']);
        Route::get('/{post}', [PostController::class, 'show']);
    });

    /*
    |--------------------------------------------------------------------------
    | PUBLIC USERS
    |--------------------------------------------------------------------------
    */

    Route::prefix('users')->group(function () {
        Route::get('/{slug}', [UserController::class, 'getUserBySlug']);
    });

    /*
    |--------------------------------------------------------------------------
    | AUTHENTICATED
    |--------------------------------------------------------------------------
    */

    Route::middleware('auth:sanctum')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | PROFILE
        |--------------------------------------------------------------------------
        */

        Route::prefix('users')->group(function () {

            Route::get('/me', [UserController::class, 'me']);
            Route::put('/me', [UserController::class, 'updateMe']);
        });

        /*
        |--------------------------------------------------------------------------
        | POSTS
        |--------------------------------------------------------------------------
        */

        Route::prefix('posts')->group(function () {

            Route::post('/', [PostController::class, 'store']);
            Route::put('/{post}', [PostController::class, 'update']);
            Route::delete('/{post}', [PostController::class, 'destroy']);

            Route::get('/me/list', [PostController::class, 'myPosts']);
        });

        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        Route::middleware('role:admin')->group(function () {

            /*
            |--------------------------------------------------------------------------
            | USERS
            |--------------------------------------------------------------------------
            */

            Route::prefix('users')->group(function () {

                Route::get('/', [UserController::class, 'index']);
                Route::put('/{user}', [UserController::class, 'update']);
                Route::delete('/{user}', [UserController::class, 'destroy']);
            });

            /*
            |--------------------------------------------------------------------------
            | ROLES
            |--------------------------------------------------------------------------
            */

            Route::apiResource('roles', RoleController::class);

            /*
            |--------------------------------------------------------------------------
            | ROLE MANAGEMENT
            |--------------------------------------------------------------------------
            */

            Route::post('/roles/{role}/permissions', [RoleController::class, 'syncPermissions']);

            Route::post('/users/{user}/roles', [UserController::class, 'syncRoles']);

            /*
            |--------------------------------------------------------------------------
            | PERMISSION MANAGEMENT
            |--------------------------------------------------------------------------
            */
            Route::apiResource('permissions', PermissionController::class)
                ->only([
                    'index',
                    'show'
                ]);
        });
    });
});
