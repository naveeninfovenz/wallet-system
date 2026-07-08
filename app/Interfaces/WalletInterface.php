<?php
namespace App\Interfaces;

interface WalletInterface{
    public function transfer($senderUserId, $receiverUserId, $amount, $referenceNo);
}