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
        Schema::create('group_roles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('wallet_id')->unsigned()->nullable();
            $table->unsignedBigInteger('group_id')->unsigned()->nullable();
            $table->enum('group_type', [1, 2, 3])->nullable()->default(1); // 1 : grupo , 2 : wallet, 3: Wallet y grupo
            $table->enum('all_wallets', [0, 1])->nullable()->default(0); // 0 : grupos puntuales , 1: todos los grupos -- todos los grupos
            $table->enum('all_groups',  [0, 1])->nullable()->default(0); // 0 : grupos puntuales , 1: todos los grupos -- todos los grupos
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('group_id')->references('id')->on('groups');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_roles');
    }
};
