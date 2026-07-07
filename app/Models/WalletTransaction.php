<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    protected $fillable = [
        'reference_no',
        'from_wallet_id',
        'to_wallet_id',
        'amount',
        'status'
    ];
}
