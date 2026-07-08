<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct() {
      
    }

    public function index(){
        $userId = Auth::user()->id;
      $wallet = Wallet::where('user_id', Auth::id())->first();

        return view('dashboard', compact('wallet'));
    }
}
