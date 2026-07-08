<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegisterController;

    
    
Route::middleware('authcheck')->group(function () {
 Route::get('/', [LoginController::class,'index'])->name('index');
Route::post('/login',[LoginController::class,'login'])->name('login');
Route::post('/register',[RegisterController::class,'register'])->name('register');
 });
Route::group(['middleware'=>['auth']],function(){
    Route::get('/dashboard',[DashboardController::class,'dashboard'])->name('dashboard');
    Route::get('/wallet/transfer', [WalletController::class, 'transferPage'])->name('wallet.transfer');
    Route::get('/wallet/balance', [WalletController::class, 'balancePage'])->name('wallet.balance');
    Route::get('/wallet/history', [WalletController::class, 'historyPage'])->name('wallet.history');
    Route::get('/logout',[LoginController::class,'logout'])->name('logout');
});