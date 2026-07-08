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
        $transaction = WalletTransaction::findOrFail($id);

        $ledger = LedgerEntry::where('wallet_transaction_id', $id)->get();

        $logs = TransactionLog::where('transaction_id', $id)->get();

        return view('wallet.show', compact(
            'transaction',
            'ledger',
            'logs'
        ));
    }
}