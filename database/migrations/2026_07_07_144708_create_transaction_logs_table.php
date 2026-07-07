<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaction_logs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('transaction_id');

            $table->string('old_status');
            $table->string('new_status');

            $table->timestamps();

          
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaction_logs');
    }
};
