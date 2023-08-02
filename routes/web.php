<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::prefix('api')->group(function () {
        Route::get('countuser', [UserController::class, 'countuser']);
        Route::get('suggestions', [UserController::class, 'suggestions']);
        Route::post('connect/{user_id}', [UserController::class, 'connect']);
        Route::get('sent-requests', [UserController::class, 'sentRequests']);
        Route::delete('withdraw-request/{user_id}', [UserController::class, 'withdrawRequest']);
        Route::get('received-requests', [UserController::class, 'receivedRequests']);
        Route::post('accept-request/{user_id}', [UserController::class, 'acceptRequest']);
        Route::get('connections', [UserController::class, 'connections']);
        Route::delete('remove-connection/{user_id}', [UserController::class, 'removeConnection']);
        Route::get('common-connections/{user_id}', [UserController::class, 'commonConnections']);
    });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
