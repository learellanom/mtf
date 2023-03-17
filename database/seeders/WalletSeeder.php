<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Wallet;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Wallet::create([
            'name' => "Caja Master",
            'description' => "En esta caja se maneja el dinero en transferencias",
            'direction' =>"Suiza, Morgartenstrasse",
            'user_id'   => 2
        ]);

        Wallet::create([
            'name' => "Caja Efectivo",
            'description' => "En esta caja se manejae el dinero en efectivo.",
            'direction' =>"Venezuela, Caracas La Yaguara",
            'user_id' => 1
        ]);
    }
}
