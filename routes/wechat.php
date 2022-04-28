<?php

use Illuminate\Support\Facades\Route;

Route::post('/mini-app/login', [\App\Http\Controllers\Wechat\MiniAppController::class, 'login']);
