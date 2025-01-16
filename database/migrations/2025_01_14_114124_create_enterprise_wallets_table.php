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
        Schema::create('enterprise_wallets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('enterprise_id')
            ->references('id')
            ->on('enterprises');  

            $table->foreignId('group_id')
            ->references('id')
            ->on('groups');      
                  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enterprise_wallets');
    }
};
