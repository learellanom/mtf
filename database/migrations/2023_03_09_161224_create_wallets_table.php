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
        Schema::create('wallets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name'); // NOMBRE DE LA CAJA
            $table->string('description'); // DESCRIPCION DE LA CAJA
            $table->string('direction'); //UBICACION DE LA CAJA
            $table->enum('type_wallet', ['Efectivo', 'Transacciones'])->nullable()->default('Efectivo'); //TIPO DE CAJA
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
