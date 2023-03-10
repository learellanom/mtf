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
            $table->double('amount');  //MONTO
            $table->double('amount_total');  //MONTO TOTAL
            $table->double('amount_total_transaction');  //MONTO TOTAL TRANSACCION
            $table->boolean('exonerate'); // EXONERADO SI|NO
            $table->string('percentage'); //PORCENTAJE DE LA TRANSFERENCIA
            $table->foreignId('type_coin_id')->references('id')->on('type_coins')->nullable(); // TIPO DE MONEDA DE LA TRANSFERENCIA
            $table->foreignId('type_transaction_id')->references('id')->on('type_transactions')->nullable();  //TIPO DE LA TRANSFERENCIA
            $table->foreignId('user_id')->references('id')->on('users')->nullable();  // USUARIO QUE REALIZO LA TRANSFERENCIA
            $table->foreignId('client_id')->references('id')->on('clients')->nullable(); //CLIENTE DE LA TRANSFERENCIA
            $table->foreignId('wallet_id')->references('id')->on('wallets')->nullable(); // MONEDERO O CUENTA DE DONDE SALE EL DINERO
            $table->string('status'); //ESTATUS
            $table->date('transaction_date'); //FECHA DE LA TRANSACCIÓN
            $table->timestamps(); //CREACION Y MODIFICACION POR DEFECTO (TOMADO POR EL SERVIDOR)
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
