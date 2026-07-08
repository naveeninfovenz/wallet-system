<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Wallet;
use App\Models\LedgerEntry;
use App\Services\WalletService;

class WalletController extends Controller
{
    protected $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    // Wallet Balance
    public function index()
    {
        $wallet = Wallet::where('user_id', Auth::id())->first();
        return view('wallet.index', compact('wallet'));
    }

    // Transfer Page
  public function create()
    {
        $wallet = Wallet::where('user_id', Auth::id())->first();
        $users = User::where('users.id', '!=', Auth::id())
            ->join('wallets', 'wallets.user_id', '=', 'users.id')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'wallets.balance'
            )
            ->get();
        return view('wallet.transfer', compact('users', 'wallet'));
    }

    // Transfer Money
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1',
            'reference_no' => 'required'
        ]);
        $response = $this->walletService->transfer(
            Auth::id(),
            $request->receiver_id,
            $request->amount,
            $request->reference_no
        );
        dd($response);
    }

    // Ledger
    public function ledger()
    {
        $wallet = Wallet::where('user_id', Auth::id())->first();
       if($wallet){
        $ledger = LedgerEntry::where('wallet_id', $wallet->id)
                    ->orderBy('id','desc')
                    ->paginate(20);
         }
       else{
        $ledger = LedgerEntry::whereRaw('1 = 0')->paginate(10);
       }
        return view('wallet.ledger', compact('ledger'));
    }
}