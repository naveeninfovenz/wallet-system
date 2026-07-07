<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WalletController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
// Route::middleware('auth:sanctum')->group(function () {

    Route::post('/wallet/transfer', [WalletController::class, 'transfer']);

    Route::get('/wallet/balance', [WalletController::class, 'balance']);

    Route::get('/wallet/history', [WalletController::class, 'history']);

// });