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
