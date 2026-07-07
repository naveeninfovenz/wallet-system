<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LedgerEntry extends Model
{
    protected $fillable = [
        'wallet_transaction_id',
        'wallet_id',
        'type',
        'amount'
    ];
}
