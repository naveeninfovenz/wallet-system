<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WalletService;
use App\Models\User;

class AutoWalletTransfer extends Command
{
    protected $signature = 'wallet:auto-transfer';

    protected $description = 'Automatically transfer money from User Naveen to User Arun';

    public function handle(WalletService $walletService)
    {
        // Sender
        $sender = User::find(1);

        // Receiver
        $receiver = User::find(2);

        if (!$sender || !$receiver) {
            $this->error('Users not found.');
            return;
        }

        $amount = 100;

        $referenceNo = 'AUTO-' . now()->format('YmdHis');

        try {

            $walletService->transfer(
                $sender->id,
                $receiver->id,
                $amount,
                $referenceNo
            );

            $this->info("₹{$amount} transferred from {$sender->name} to {$receiver->name}");

        } catch (\Exception $e) {

            $this->error($e->getMessage());

        }
    }
}