<?php
namespace App\Services;

use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\LedgerEntry;
use App\Models\TransactionLog;
use Illuminate\Support\Facades\DB;

class WalletService
{
    public function transfer($senderUserId, $receiverUserId, $amount, $referenceNo)
    {
        if ($senderUserId == $receiverUserId) {
            return response()->json([
                'status' => false,
                'message' => 'Sender and Receiver cannot be same.'
            ], 422);
        }
        $existingTransaction = WalletTransaction::where('reference_no', $referenceNo)->first();
        if ($existingTransaction) {
            return response()->json([
                'status' => true,
                'message' => 'Duplicate Request',
                'transaction_id' => $existingTransaction->id,
                'transaction_status' => $existingTransaction->status
            ]);
        }
        try {
            DB::transaction(function () use (
                $senderUserId,
                $receiverUserId,
                $amount,
                $referenceNo,
                &$transaction
            ) {
                $senderWallet = Wallet::where('user_id', $senderUserId)
                    ->lockForUpdate()
                    ->first();
                $receiverWallet = Wallet::where('user_id', $receiverUserId)
                    ->lockForUpdate()
                    ->first();
                if (!$senderWallet) {
                    throw new \Exception("Sender wallet not found.");
                }
                if (!$receiverWallet) {
                    throw new \Exception("Receiver wallet not found.");
                }
                if ($senderWallet->balance < $amount) {
                    throw new \Exception("Insufficient Balance.");
                }
                // Create Transaction
                $transaction = WalletTransaction::create([
                    'reference_no' => $referenceNo,
                    'from_wallet_id' => $senderWallet->id,
                    'to_wallet_id' => $receiverWallet->id,
                    'amount' => $amount,
                    'status' => 'pending'
                ]);
                // Debit Sender
                $senderWallet->balance -= $amount;
                $senderWallet->version += 1;
                $senderWallet->save();
                // Credit Receiver
                $receiverWallet->balance += $amount;
                $receiverWallet->version += 1;
                $receiverWallet->save();
                // Debit Ledger
                LedgerEntry::create([
                    'wallet_transaction_id' => $transaction->id,
                    'wallet_id' => $senderWallet->id,
                    'type' => 'debit',
                    'amount' => $amount
                ]);
                // Credit Ledger
                LedgerEntry::create([
                    'wallet_transaction_id' => $transaction->id,
                    'wallet_id' => $receiverWallet->id,
                    'type' => 'credit',
                    'amount' => $amount
                ]);
                // Transaction Log
                TransactionLog::create([
                    'transaction_id' => $transaction->id,
                    'old_status' => 'pending',
                    'new_status' => 'completed'
                ]);
                // Update Transaction Status
                $transaction->status = 'completed';
                $transaction->save();
            }, 5); // Retry 5 Times on Deadlock
            return response()->json([
                'status' => true,
                'transaction_id' => $transaction?$transaction->id:"",
                'transaction_status' => 'completed'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);

        }
    }
}