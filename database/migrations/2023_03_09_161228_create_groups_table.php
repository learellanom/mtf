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
            $table->string('phone')->nullable();
            $table->string('description');
            $table->enum('type', [1, 2, 3])->nullable()->default(1); // 1 : grupo , 2 : wallet, 3: Wallet y grupo
            $table->enum('type_wallet', ['Efectivo','Transacciones'])->nullable();
            $table->boolean('provider')->nullable();
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
