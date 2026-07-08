<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\LedgerEntry;
use App\Models\TransactionLog;

class TransactionController extends Controller
{
    // History
    public function index()
    {
        $wallet = Wallet::where('user_id', Auth::id())->first();
       if($wallet){
        $transactions = WalletTransaction::where('from_wallet_id', $wallet->id)
            ->orWhere('to_wallet_id', $wallet->id)
            ->orderBy('id', 'desc')
            ->paginate(10);
       }
       else{
        $transactions = WalletTransaction::whereRaw('1 = 0')->paginate(10);
       }


        return view('wallet.history', compact('transactions'));
    }

    // Transaction Details
   public function show($id)
      {
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
}