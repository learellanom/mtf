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
        Schema::create('transaction_masters', function (Blueprint $table) {
            $table->bigIncrements('id'); // IDENTIFICADOR DE LA TABLA
            $table->double('amount');  //MONTO EN DOLARES
            $table->double('amount_foreign_currency')->nullable();  //MONTO MONEDA EXTRANJERA
            $table->double('amount_total');  //MONTO TOTAL
            $table->double('amount_commission')->nullable();  //MONTO COMISION
            $table->double('exchange_rate')->nullable(); // TAZA DE CAMBIO
            $table->enum('exonerate', [1, 2, 3])->nullable()->default(1); //DESCUENTO, EXONERADO E INCLUIR COMOSIÓN
            $table->double('percentage')->nullable(); //PORCENTAJE DE LA TRANSFERENCIA
            $table->foreignId('type_coin_id')->default(1)->references('id')->on('type_coins'); // TIPO DE MONEDA DE LA TRANSFERENCIA
            $table->foreignId('type_transaction_id')->references('id')->on('type_transactions')->nullable();  //TIPO DE LA TRANSFERENCIA
            $table->foreignId('user_id')->references('id')->on('users')->nullable();  // USUARIO QUE REALIZO LA TRANSFERENCIA
            $table->foreignId('group_id')->references('id')->on('groups')->onUpdate('cascade')->onDelete('cascade'); //CLIENTE DE LA TRANSFERENCIA
            $table->foreignId('wallet_id')->default(3)->references('id')->on('wallets')->nullable(); // MONEDERO O CUENTA DE DONDE SALE EL DINERO
            $table->enum('status', ['Activo', 'Anulado'])->nullable()->default('Activo'); //ESTATUS
            $table->string('description'); //DESCRIPCION DE LA TRANSFERENCIA
            $table->string('token')->nullable(); //TOKEN
            $table->datetime('transaction_date'); //FECHA DE LA TRANSACCIÓN
            $table->double('percentage_base')->nullable(); //PORCENTAJE DE LA GANANCIA
            $table->double('amount_commission_base')->nullable(); //GANANCIA DE LA COMOSION
            $table->timestamps(); //CREACION Y MODIFICACION POR DEFECTO (TOMADO POR EL SERVIDOR)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_masters');
    }
};
