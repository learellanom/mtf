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
        Schema::create('transaction_suppliers', function (Blueprint $table) {
            $table->bigIncrements('id'); // IDENTIFICADOR DE LA TABLA
            $table->double('amount');  //MONTO EN DOLARES
            $table->double('amount_foreign_currency')->nullable();  //MONTO MONEDA EXTRANJERA
            $table->double('amount_total');  //MONTO TOTAL
            $table->double('amount_commission')->nullable();  //MONTO COMISION
            $table->double('exchange_rate')->nullable(); // TAZA DE CAMBIO
            $table->enum('exonerate', [1, 2, 3])->nullable()->default(1); //DESCUENTO, EXONERADO E INCLUIR COMOSIÓN
            $table->double('percentage')->nullable(); //PORCENTAJE DE LA TRANSFERENCIA
            $table->foreignId('type_coin_id')->default(1)->references('id')->on('type_coins'); // TIPO DE MONEDA DE LA TRANSFERENCIA
            $table->foreignId('type_transaction_id')->references('id')->on('type_transactions');  //TIPO DE LA TRANSFERENCIA
            $table->foreignId('user_id')->references('id')->on('users');  // USUARIO QUE REALIZO LA TRANSFERENCIA
            $table->foreignId('wallet_id')->references('id')->on('wallets'); // MONEDERO O CUENTA DE DONDE SALE EL DINERO
            $table->foreignId('supplier_id')->nullable()->references('id')->on('suppliers')->onUpdate('cascade')->onDelete('cascade'); //PROVEEDORES DE LA TRANSFERENCIA
            $table->enum('status', ['Activo', 'Anulado'])->nullable()->default('Activo'); //ESTATUS
            $table->longText('description')->nullable(); // DESCRIPCION DE LA TRANSFERENCIA
            $table->string('token')->nullable(); //TOKEN
            $table->datetime('transaction_date'); // FECHA DE LA TRANSACCIÓN
            $table->timestamps(); //CREACION Y MODIFICACION POR DEFECTO (TOMADO POR EL SERVIDOR)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_suppliers');
    }
};
