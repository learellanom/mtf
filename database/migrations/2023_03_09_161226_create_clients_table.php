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
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id'); //IDENITIFICADOR DE LA TABLA
            $table->string('name'); // NOMBRE DEL CLIENTE
            $table->string('email')->unique(); //EMAIL DEL CLIENTE
            $table->string('phone')->nullable(); //TELEFONO
            //$table->foreignId('user_id')->references('id')->on('users')->nullable(); //USUARIO RELACIONADO CON EL CLIENTE
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
