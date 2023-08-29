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
        Schema::create('type_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->enum('type_transaction', ['Efectivo', 'Transacciones', 'Credito'])->nullable()->default('Transacciones'); //TIPO DE TRANSACCIONES
            $table->string('description');
            $table->enum('type_transaction_wallet', ['0', '1', '2'])->nullable()->default('0'); // tipo de transaction wallet 0 no asignado, 1: credito, 2: debito
            $table->enum('type_transaction_group',  ['0', '1', '2'])->nullable()->default('0'); // tipo de transaction group 0 no asignado, 1: credito, 2: debito
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_transactions');
    }
};
