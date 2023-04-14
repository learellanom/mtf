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
            'type_wallet' => 'Transacciones'

        ]);

        Wallet::create([
            'name' => "Caja Efectivo",
            'description' => "En esta caja se maneja el dinero en efectivo.",
            'direction' =>"Venezuela, Caracas La Yaguara",
            'type_wallet' => 'Efectivo'
        ]);

        Wallet::create([
            'name' => "Caja (Saldo)",
            'description' => "En esta caja se mueven notas de debito y credito.",
            'direction' =>"Venezuela",
            'type_wallet' => 'Transacciones'
        ]);
    }
}
