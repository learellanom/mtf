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
            $table->bigIncrements('id');                            // IDENTIFICADOR DE LA TABLA
            $table->string('transfer_number')->nullable();          //NUMERO DE REFEENCIA PARA TRANSFERENCIAS ENTRE CAJAS
            $table->string('pay_number')->nullable();               //NUMERO DE REFEENCIA PARA PAGOS ENTRE CAJAS
            $table->double('amount');                               //MONTO EN DOLARES
            $table->double('amount_foreign_currency')->nullable();  //MONTO MONEDA EXTRANJERA
            $table->double('amount_total');                         //MONTO TOTAL
            $table->double('amount_commission')->nullable();        //MONTO COMISION
            $table->double('exchange_rate')->nullable();            //TASA DE CAMBIO
            $table->double('exchange_rate_base')->nullable();       //TASA BASE
            $table->enum('exonerate', [1, 2, 3])->nullable()->default(2); //DESCUENTO, EXONERADO E INCLUIR COMOSIÓN
            $table->double('percentage')->nullable();               //PORCENTAJE DE LA TRANSFERENCIA
            $table->foreignId('type_coin_id')->default(1)->references('id')->on('type_coins'); // TIPO DE MONEDA DE LA TRANSFERENCIA
            $table->foreignId('type_transaction_id')->references('id')->on('type_transactions');  //TIPO DE LA TRANSFERENCIA
            $table->foreignId('user_id')->references('id')->on('users');  // USUARIO QUE REALIZO LA TRANSFERENCIA
            $table->foreignId('group_id')->nullable()->references('id')->on('groups'); //ORIGEN
            $table->foreignId('wallet_id')->nullable()->references('id')->on('groups'); //DESTINO
            $table->enum('status', ['Activo', 'Anulado'])->nullable()->default('Activo'); //ESTATUS
            $table->string('token')->nullable();                            //TOKEN
            $table->longText('description');                                //DESCRIPCION DE LA TRANSFERENCIA
            $table->datetime('transaction_date');                           //FECHA DE LA TRANSACCIÓN
            $table->enum('exonerate_base', [1, 2, 3])->nullable()->default(2); //DESCUENTO, EXONERADO E INCLUIR COMISÓN BASE
            $table->double('percentage_base')->nullable();                  //PORCENTAJE DE LA GANANCIA
            $table->double('amount_commission_base')->nullable();           //GANANCIA DE LA COMOSION
            $table->double('amount_base')->nullable();                      //MONTO BASE PARA CALCULAR COMISION POR TASA
            $table->double('amount_total_base')->nullable();                //GANANCIA DE LA COMOSION
            $table->double('amount_commission_profit')->nullable();         //GANANCIA DE LA COMOSION

            $table->timestamps();            
            
            $table->index('transaction_date');                              // crea indeice en transaction_date

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
