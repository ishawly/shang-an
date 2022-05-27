<?php

use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ParticipantController;
use App\Http\Controllers\Api\TopicController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    ->group(function () {
        Route::post('/login', [AuthController::class, 'login'])->name('api.auth.login');
        Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
        Route::middleware('auth:sanctum')->get('/user-profile', [AuthController::class, 'userProfile']);
    });

Route::controller(UserController::class)
    ->group(function () {
    });

Route::middleware(['auth:sanctum'])
    ->apiResource('topics', TopicController::class)
    ->except(['edit']);

Route::middleware(['auth:sanctum'])
    ->group(function () {
        Route::get('/activities/today', [ActivityController::class, 'getTodayActivity']);
        Route::get('/activities/user-participated', [ActivityController::class, 'getUserParticipated']);
    });
Route::middleware(['auth:sanctum'])
    ->apiResource('activities', ActivityController::class);

Route::middleware(['auth:sanctum'])
    ->apiResource('activities.participants', ParticipantController::class)
    ->scoped()
    ->except(['index']);
