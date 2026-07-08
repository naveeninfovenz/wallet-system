<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class DashboardController extends Controller
{
    public function __construct() {
      
    }

 public function index()
{
  try{
     $wallet = Wallet::firstOrCreate(
        ['user_id' => Auth::id()],
        [
            'balance' => 0,
            'version' => 1
        ]
    );

    $walletId = $wallet->id;

    $totalSent = DB::table('ledger_entries')
        ->where('wallet_id', $walletId)
        ->where('type', 'debit')
        ->sum('amount');

    $totalReceived = DB::table('ledger_entries')
        ->where('wallet_id', $walletId)
        ->where('type', 'credit')
        ->sum('amount');

    $sentTransactions = DB::table('wallet_transactions')
        ->join('wallets', 'wallets.id', '=', 'wallet_transactions.to_wallet_id')
        ->join('users', 'users.id', '=', 'wallets.user_id')
        ->where('wallet_transactions.from_wallet_id', $walletId)
        ->select(
            'wallet_transactions.reference_no',
            'wallet_transactions.amount',
            'wallet_transactions.status',
            'wallet_transactions.created_at',
            'users.name as receiver_name'
        )
        ->latest('wallet_transactions.id')
        ->limit(5)
        ->get();

    $receivedTransactions = DB::table('wallet_transactions')
        ->join('wallets', 'wallets.id', '=', 'wallet_transactions.from_wallet_id')
        ->join('users', 'users.id', '=', 'wallets.user_id')
        ->where('wallet_transactions.to_wallet_id', $walletId)
        ->select(
            'wallet_transactions.reference_no',
            'wallet_transactions.amount',
            'wallet_transactions.status',
            'wallet_transactions.created_at',
            'users.name as sender_name'
        )
        ->latest('wallet_transactions.id')
        ->limit(5)
        ->get();

    return view('dashboard', compact(
        'wallet',
        'totalSent',
        'totalReceived',
        'sentTransactions',
        'receivedTransactions'
    ));
  }
  catch(\Exception $e){
        Log::info([
            'function'=>'DashboardController@index',
            'line'=>$e->getLine(),
            'message'=>$e->getMessage()
        ]);
    }
}
}
