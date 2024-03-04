<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
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

Route::group([
    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'profile'
], function ($router) {
    Route::get('/user', [AuthController::class, 'userProfile']);
    Route::post('/update', [AuthController::class, 'userProfileUpdate']);
});

Route::group([
    'middleware' => 'api',
], function ($router) {
    Route::apiResource('posts',PostController::class);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'logs'
], function ($router) {
    Route::get('/', [\App\Http\Controllers\LogActivityController::class, 'index']);
});

