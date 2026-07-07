<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WalletController;


    Route::get('/', [WalletController::class, 'index'])->name('dashboard');
    
    Route::get('/wallet/transfer', [WalletController::class, 'transferPage'])->name('wallet.transfer');
    
    Route::get('/wallet/balance', [WalletController::class, 'balancePage'])->name('wallet.balance');
    
    Route::get('/wallet/history', [WalletController::class, 'historyPage'])->name('wallet.history');
