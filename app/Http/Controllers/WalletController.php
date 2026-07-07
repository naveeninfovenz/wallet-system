<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class WalletController extends Controller
{
    /**
     * Dashboard
     */
    public function index()
    {
        $users = User::orderBy('name')->get();
    
        $totalUsers = User::count();
    
        $totalWallets = Wallet::count();
    
        $totalTransactions = WalletTransaction::count();
    
        $transactions = DB::table('wallet_transactions as wt')
            ->join('wallets as sw','wt.from_wallet_id','=','sw.id')
            ->join('users as sender','sw.user_id','=','sender.id')
            ->join('wallets as rw','wt.to_wallet_id','=','rw.id')
            ->join('users as receiver','rw.user_id','=','receiver.id')
            ->select(
                'wt.reference_no',
                'sender.name as sender_name',
                'receiver.name as receiver_name',
                'wt.amount',
                'wt.status',
                'wt.created_at'
            )
            ->latest('wt.id')
            ->limit(10)
            ->get();
    
        return view('wallet.index', compact(
            'users',
            'totalUsers',
            'totalWallets',
            'totalTransactions',
            'transactions'
        ));
    }

    /**
     * Transfer Page
     */
    public function transferPage()
    {
        $users = User::orderBy('name')->get();

        return view('wallet.transfer', compact('users'));
    }

    /**
     * Balance Page
     */
    public function balancePage()
    {
        $wallets = Wallet::select('wallets.*', 'users.name')
            ->join('users', 'users.id', '=', 'wallets.user_id')
            ->orderBy('users.name')
            ->get();

        return view('wallet.balance', compact('wallets'));
    }

    /**
     * History Page
     */
    public function historyPage()
    {
        $transactions = DB::table('wallet_transactions as wt')
            ->join('wallets as sw', 'wt.from_wallet_id', '=', 'sw.id')
            ->join('users as sender', 'sw.user_id', '=', 'sender.id')
            ->join('wallets as rw', 'wt.to_wallet_id', '=', 'rw.id')
            ->join('users as receiver', 'rw.user_id', '=', 'receiver.id')
            ->select(
                'wt.id',
                'wt.reference_no',
                'sender.name as sender_name',
                'receiver.name as receiver_name',
                'wt.amount',
                'wt.status',
                'wt.created_at'
            )
            ->orderByDesc('wt.id')
            ->paginate(10);
    
        return view('wallet.history', compact('transactions'));
    }
}