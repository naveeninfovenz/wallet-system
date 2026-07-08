<?php
namespace App\Services;



use App\Interfaces\WalletInterface;
use App\Repositories\WalletRepository;
class WalletService implements WalletInterface
{
     protected $walletRepository;

    public function __construct() {
        $this->walletRepository = new WalletRepository();
    }

    public function transfer($senderUserId, $receiverUserId, $amount, $referenceNo)
    {
        return $this->walletRepository->transfer($senderUserId, $receiverUserId, $amount, $referenceNo);
    }
}