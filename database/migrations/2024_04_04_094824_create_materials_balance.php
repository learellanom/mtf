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
        Schema::create('materials_balance', function (Blueprint $table) {
            $table->id();

            $table->foreignId('adquisicion_id')->references('id')->on('transactions');              // id de la adquisicion
            $table->foreignId('wallet_id')->references('id')->on('groups');                         // wallet
            $table->foreignId('group_id')->references('id')->on('groups');                          // grupo
            $table->foreignId('type_transaction_id')->references('id')->on('type_transactions');    // tipo de transaccion
            $table->foreignId('type_material_id')->references('id')->on('type_materials');          // Tipo de material
            $table->datetime('transaction_date');                                                   // FECHA DE LA TRANSACCIÓN
            $table->double('material_price');                                                       // precion de la adquisicion por unidad
            $table->double('material_amount');                                                      // cantidad de la adquisicion 
            $table->double('material_amount_total');                                                // monto de la adquisicion
            $table->double('material_saldo');                                                       // saldo
            $table->double('material_saldo2');                                                      // saldo2
            $table->double('adquisicion_cierre_cant');                                              // acumulado cantidad al cierre
            $table->double('adquisicion_cierre_amount');                                            // acumulado monto al cierre
            $table->foreignId('recepcion_id')->references('id')->on('transactions');                // id e la recepcion
            $table->datetime('recepcion_transaction_date');                                         // fecha de la recepcion
            $table->double('recepcion_material_amount');                                            // cantidad de la recepcion
            $table->double('recepcion_material_amount2');                                           // cantidad asignada de la recepcion a la adquisicion
            $table->double('recepcion_saldo');                                                      // cantiad que queda por asignar de esta recepcion
            $table->double('recepcion_balance');                                                    // acumulado de cantidad recibida
            $table->foreignId('user_id')->references('id')->on('users');                            // usuario que genera el cierre

            $table->index('transaction_date');                                                      // crea indice en transaction_date

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials_balance');
    }
};
