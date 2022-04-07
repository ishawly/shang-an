<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')
    ->group( function () {
        Route::post('/login', [AuthController::class, 'login'])->name('api.auth.login');
        Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
        Route::middleware('auth:sanctum')->get('/user-profile', [AuthController::class, 'userProfile']);
    });

Route::controller(UserController::class)
    ->group(function() {

    });

Route::middleware(['auth:sanctum'])
    ->apiResource('activities', \App\Http\Controllers\Api\ActivityController::class);

Route::middleware(['auth:sanctum'])
    ->apiResource('topics', \App\Http\Controllers\Api\TopicController::class)
    ->except(['destroy']);
