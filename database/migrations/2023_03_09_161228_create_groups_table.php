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
        Schema::create('groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('phone');
            $table->string('description');
<<<<<<< HEAD:database/migrations/2023_03_09_161225_create_groups_table.php
            $table->string('client_id');
=======
            $table->foreignId('client_id')->references('id')->on('clients')->nullable(); //USUARIO RELACIONADO CON EL CLIENTE
>>>>>>> aa0f89fdff12674bb56c5e58254a3fb71716cb11:database/migrations/2023_03_09_161228_create_groups_table.php
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
