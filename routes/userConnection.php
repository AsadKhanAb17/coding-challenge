<?php

// routes/userConnection.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::middleware('auth')->group(function () {
    Route::prefix('api')->group(function () {
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
