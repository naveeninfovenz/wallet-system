<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\LedgerEntry;
use App\Models\TransactionLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class TransactionController extends Controller
{
    // History
    public function index()
    {
        try{
        $wallet = Wallet::where('user_id', Auth::id())->first();

        if (!$wallet) {
            return view('wallet.history', [
                'transactions' => collect(),
                'wallet' => null,
                'totalSent' => 0,
                'totalReceived' => 0
            ]);
        }

        $walletId = $wallet->id;

        $totalSent = DB::table('ledger_entries')
            ->where('wallet_id', $walletId)
            ->where('type', 'debit')
            ->sum('amount');

        $totalReceived = DB::table('ledger_entries')
            ->where('wallet_id', $walletId)
            ->where('type', 'credit')
            ->sum('amount');

        $transactions = DB::table('wallet_transactions')
            ->join('wallets as sender_wallet', 'sender_wallet.id', '=', 'wallet_transactions.from_wallet_id')
            ->join('users as sender', 'sender.id', '=', 'sender_wallet.user_id')
            ->join('wallets as receiver_wallet', 'receiver_wallet.id', '=', 'wallet_transactions.to_wallet_id')
            ->join('users as receiver', 'receiver.id', '=', 'receiver_wallet.user_id')
            ->where(function ($q) use ($walletId) {
                $q->where('wallet_transactions.from_wallet_id', $walletId)
                ->orWhere('wallet_transactions.to_wallet_id', $walletId);
            })
            ->select(
                'wallet_transactions.*',
                'sender.name as sender_name',
                'receiver.name as receiver_name'
            )
            ->latest('wallet_transactions.id')
            ->paginate(10);

        return view('wallet.history', compact(
            'transactions',
            'wallet',
            'totalSent',
            'totalReceived'
        ));
        }
        catch(\Exception $e){
            Log::info([
                'function'=>'TransactionController@index',
                'line'=>$e->getLine(),
                'message'=>$e->getMessage()
            ]);
        }
    }
    // Transaction Details
   public function show($id)
      {
        try{
      $transaction = WalletTransaction::where('wallet_transactions.id', $id)
        ->join('wallets as sender_wallet', 'sender_wallet.id', '=', 'wallet_transactions.from_wallet_id')
        ->join('users as sender', 'sender.id', '=', 'sender_wallet.user_id')
        ->join('wallets as receiver_wallet', 'receiver_wallet.id', '=', 'wallet_transactions.to_wallet_id')
        ->join('users as receiver', 'receiver.id', '=', 'receiver_wallet.user_id')
        ->select(
            'wallet_transactions.*',
            'sender.name as sender_name',
            'sender.email as sender_email',
            'receiver.name as receiver_name',
            'receiver.email as receiver_email'
        )
        ->firstOrFail();
        $ledger = LedgerEntry::where('wallet_transaction_id', $id)
            ->join('wallets', 'wallets.id', '=', 'ledger_entries.wallet_id')
            ->join('users', 'users.id', '=', 'wallets.user_id')
            ->select(
                'ledger_entries.*',
                'users.name'
            )
            ->get();

    $logs = TransactionLog::where('transaction_id', $id)->get();

    return view('wallet.show', compact(
        'transaction',
        'ledger',
        'logs'
    ));
        }
        catch(\Exception $e){
            Log::info([
                'function'=>'TransactionController@show',
                'line'=>$e->getLine(),
                'message'=>$e->getMessage()
            ]);
        }
  }
}