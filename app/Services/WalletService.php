<?php

namespace App\Services;

use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\LedgerEntry;
use App\Models\TransactionLog;
use Illuminate\Support\Facades\DB;


class WalletService
{
    public function transfer($request)
    {

        if($request->sender_id==$request->receiver_id){

            return response()->json([
                'status'=>false,
                'message'=>'Sender and Receiver cannot be same.'
            ],422);

        }

        // Idempotency
        $exists=WalletTransaction::where('reference_no','=',$request->reference_no)->first();

        if($exists){

            return response()->json([
                'status'=>true,
                'message'=>'Duplicate Request',
                'transaction'=>$exists
            ]);

        }

        try{

            DB::beginTransaction();

            // Always lock in ascending wallet id order
            $walletIds = [$request->sender_id, $request->receiver_id];
            sort($walletIds);

            $lockedWallets = Wallet::whereIn('user_id', $walletIds)
                ->orderBy('user_id')
                ->lockForUpdate()
                ->get()
                ->keyBy('user_id');

            $sender = $lockedWallets[$request->sender_id] ?? null;
            $receiver = $lockedWallets[$request->receiver_id] ?? null;

            if(!$sender || !$receiver){

                DB::rollBack();

                return response()->json([
                    'status'=>false,
                    'message'=>'Wallet not found.'
                ],404);

            }

            if($sender->balance < $request->amount){

                DB::rollBack();

                return response()->json([
                    'status'=>false,
                    'message'=>'Insufficient Balance.'
                ],422);

            }

            $transaction = WalletTransaction::create([

                'reference_no'=>$request->reference_no,
                'from_wallet_id'=>$sender->id,
                'to_wallet_id'=>$receiver->id,
                'amount'=>$request->amount,
                'status'=>'pending'

            ]);

            $sender->balance -= $request->amount;
            $sender->version += 1;
            $sender->save();

            $receiver->balance += $request->amount;
            $receiver->version += 1;
            $receiver->save();

            LedgerEntry::create([
                'wallet_transaction_id'=>$transaction->id,
                'wallet_id'=>$sender->id,
                'type'=>'debit',
                'amount'=>$request->amount
            ]);

            LedgerEntry::create([
                'wallet_transaction_id'=>$transaction->id,
                'wallet_id'=>$receiver->id,
                'type'=>'credit',
                'amount'=>$request->amount
            ]);

            $transaction->status='completed';
            $transaction->save();

            TransactionLog::create([
                'transaction_id'=>$transaction->id,
                'old_status'=>'pending',
                'new_status'=>'completed'
            ]);

            DB::commit();

            return response()->json([
                'status'=>true,
                'transaction_id'=>$transaction->id,
                'message'=>'Transfer Successful'
            ]);

        }catch(\Throwable $e){

            DB::rollBack();

            return response()->json([
                'status'=>false,
                'message'=>$e->getMessage()
            ],500);

        }

    }

    public function balance($userId)
    {

    }

    public function history($userId)
    {

    }
}