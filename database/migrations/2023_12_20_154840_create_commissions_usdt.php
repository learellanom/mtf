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
        Schema::create('commissions_usdt', function (Blueprint $table) {

            $table->id();
            
            $table->bigInteger('transaction_id');

            $table->double('amount');                               //MONTO EN DOLARES
            $table->double('amount2');                               //MONTO EN DOLARES
            $table->double('amount_commission')->nullable();        //MONTO COMISION
            $table->double('percentage')->nullable();               //PORCENTAJE DE LA TRANSFERENCIA
        
            $table->foreignId('type_transaction_id')->references('id')->on('type_transactions');    // TIPO DE LA TRANSFERENCIA
            $table->foreignId('user_id')->references('id')->on('users');                            // USUARIO QUE REALIZO LA TRANSFERENCIA
            $table->foreignId('group_id')->nullable()->references('id')->on('groups');              // ORIGEN
            $table->foreignId('wallet_id')->nullable()->references('id')->on('groups');             // DESTINO
        
            $table->datetime('transaction_date');                           //FECHA DE LA TRANSACCIÓN
            $table->double('percentage_base')->nullable();                  //PORCENTAJE DE LA GANANCIA
            $table->double('amount_commission_base')->nullable();           //GANANCIA DE LA COMOSION
            $table->double('amount_commission_profit')->nullable();         //GANANCIA DE LA COMOSION
        
            $table->foreignId('reload_id')->references('id')->on('transactions');   // TIPO DE MONEDA DE LA TRANSFERENCIA
            $table->double('reload_amount')->nullable();                            //MONTO EN DOLARES
            $table->double('reload_percentage_base')->nullable();                   //PORCENTAJE DE LA GANANCIA
            $table->double('reload_balance')->nullable();                           //GANANCIA DE LA COMOSION
        
            $table->index('transaction_date');                                      // crea indice en transaction_date

            $table->timestamps();
            
            $table->foreignId('type_coin_balance_id')->default(1)->references('id')->on('type_coins');  //-> tipo de moneda en el que se llevara el balance de la transaccion

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commissions_usdt');
    }
};

