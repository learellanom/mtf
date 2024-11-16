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
        Schema::create('transaction_requests', function (Blueprint $table) {
            $table->bigIncrements('id');                                //-> Identificador de la tabla
            $table->double('amount')->nullable();                       //-> Monto en Dorales
            $table->enum('status', 
                    [
                    'Pendiente', 
                    'Procesada',
                    'Anulada',                    
                    'Rechazada',                    
                    'Procesada con Ajustes',                    
                    ])
                    ->nullable()
                    ->default('Pendiente');                             // Status
            $table->longText('description');                            //DESCRIPCION DE LA TRANSFERENCIA
            $table->datetime('transaction_date');                       //FECHA DE LA TRANSACCIÓN
            $table->foreignId('user_id')
                    ->references('id')
                    ->on('users');                                      // Usuario que realiza la operacion
            $table->foreignId('group_id')
                    ->nullable()
                    ->references('id')
                    ->on('groups');                                     // Grupo que solicita transaccion
            $table->foreignId('type_coin_id')
                    ->nullable()
                    ->default(1)
                    ->references('id')
                    ->on('type_coins');                                 //Tipo de moneda de la transferencia
            $table->foreignId('type_transaction_requests_id')
                    ->references('id')
                    ->on('type_transaction_requests');                 // tipo de transaccion
            $table->string('note');                                     // Notas del Operador

            $table->index('transaction_date');                         // crea indice en transaction_date

            $table->timestamps();       

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_requests');
    }
};
