<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ledger_entries', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('wallet_transaction_id');
            $table->unsignedBigInteger('wallet_id');

            $table->enum('type', [
                'debit',
                'credit'
            ]);

            $table->decimal('amount', 15, 2);

            $table->timestamps();

          
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ledger_entries');
    }
};