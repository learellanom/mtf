<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('amount');
            $table->string('percentage');
            $table->string('type_coins');
            $table->string('type_transactions');
            $table->foreignId('user_id')->references('id')->on('users')->nullable();
            $table->foreignId('client_id')->references('id')->on('clients')->nullable();
            $table->foreignId('wallet_id')->references('id')->on('wallets')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
