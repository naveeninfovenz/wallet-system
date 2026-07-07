<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\WalletService;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    protected $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    public function transfer(Request $request)
    {
        return $this->walletService->transfer($request);
    }
    public function balance()
    {
        //
    }

    public function history()
    {
        //
    }
}