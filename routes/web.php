<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\RegisterController;

    
    
Route::middleware('authcheck')->group(function () {
 Route::get('/', [LoginController::class,'index'])->name('index');
Route::post('/login',[LoginController::class,'login'])->name('login');
Route::post('/register',[RegisterController::class,'register'])->name('register');
 });
Route::group(['middleware'=>['auth']],function(){
       Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/wallet', [WalletController::class, 'index'])
        ->name('wallet.index');

    Route::get('/wallet/transfer', [WalletController::class, 'create'])
        ->name('wallet.transfer.form');

    Route::post('/wallet/transfer', [WalletController::class, 'store'])
        ->name('wallet.transfer');

    Route::get('/wallet/history', [TransactionController::class, 'index'])
        ->name('wallet.history');

    Route::get('/wallet/history/{id}', [TransactionController::class, 'show'])
        ->name('wallet.history.show');

    Route::get('/wallet/ledger', [WalletController::class, 'ledger'])
        ->name('wallet.ledger');
    Route::get('/logout',[LoginController::class,'logout'])->name('logout');
});