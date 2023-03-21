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
            $table->bigIncrements('id'); // IDENTIFICADOR DE LA TABLA
            $table->double('amount');  //MONTO EN DOLARES
            $table->double('amount_foreign_currency')->nullable();  //MONTO MONEDA EXTRANJERA
            $table->double('amount_total');  //MONTO TOTAL
            $table->double('amount_commission');  //MONTO COMISION
            $table->double('exchange_rate')->nullable(); // TAZA DE CAMBIO
            $table->boolean('exonerate')->default(False); // EXONERADO SI|NO
            $table->boolean('discount')->default(False); //DESCUENTO EN LA TRANSFERENCIA
            $table->integer('percentage'); //PORCENTAJE DE LA TRANSFERENCIA
            $table->foreignId('type_coin_id')->references('id')->on('type_coins')->nullable(); // TIPO DE MONEDA DE LA TRANSFERENCIA
            $table->foreignId('type_transaction_id')->references('id')->on('type_transactions')->nullable();  //TIPO DE LA TRANSFERENCIA
            $table->foreignId('user_id')->references('id')->on('users')->nullable();  // USUARIO QUE REALIZO LA TRANSFERENCIA
            $table->foreignId('client_id')->references('id')->on('clients')->nullable(); //CLIENTE DE LA TRANSFERENCIA
            $table->foreignId('wallet_id')->references('id')->on('wallets')->nullable(); // MONEDERO O CUENTA DE DONDE SALE EL DINERO
            $table->enum('status', ['Activo', 'Anulado'])->nullable()->default('Activo'); //ESTATUS
            $table->string('description'); //DESCRIPCION DE LA TRANSFERENCIA
            $table->date('transaction_date'); //FECHA DE LA TRANSACCIÓN
            $table->integer('percentage_winner')->nullable(); //PORCENTAJE DE LA GANANCIA
            $table->double('comission_winner')->nullable(); //GANANCIA DE LA COMOSION
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
