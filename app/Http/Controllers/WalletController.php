<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Wallet;
use App\Models\LedgerEntry;
use App\Services\WalletService;
use Illuminate\Support\Facades\DB;
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
        return $this->walletService->transfer(
            Auth::id(),
            $request->receiver_id,
            $request->amount,
            $request->reference_no
        );
    }

    // Ledger
  public function ledger()
        {
            $wallet = Wallet::where('user_id', Auth::id())->first();

            if (!$wallet) {
                return view('wallet.ledger', [
                    'ledger' => collect(),
                    'wallet' => null,
                    'totalCredit' => 0,
                    'totalDebit' => 0
                ]);
            }

            $totalCredit = LedgerEntry::where('wallet_id', $wallet->id)
                ->where('type', 'credit')
                ->sum('amount');

            $totalDebit = LedgerEntry::where('wallet_id', $wallet->id)
                ->where('type', 'debit')
                ->sum('amount');

            $ledger = DB::table('ledger_entries')
                ->join(
                    'wallet_transactions',
                    'wallet_transactions.id',
                    '=',
                    'ledger_entries.wallet_transaction_id'
                )
                ->where('ledger_entries.wallet_id', $wallet->id)
                ->select(
                    'ledger_entries.*',
                    'wallet_transactions.reference_no'
                )
                ->latest('ledger_entries.id')
                ->paginate(10);

            return view('wallet.ledger', compact(
                'wallet',
                'ledger',
                'totalCredit',
                'totalDebit'
            ));
        }
}