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
        Wallet::create([
            'name' => "Caja Puente",
            'description' => "Caja Puente",
            'direction' =>"Venezuela, Caracas La Yaguara",
            'type_wallet' => 'Efectivo'
        ]);
        Wallet::create([
            'name' => "CAJA PRUEBA1",
            'description' => "recargas de usdt",
            'direction' => "CAJA PRUEBA1",
            'type_wallet' => 'Transacciones'
        ]);
        Wallet::create([
            'name' => "CAJA PRUEBA2",
            'description' => "recargas de PRUEBA2",
            'direction' => "CAJA PRUEBA2",
            'type_wallet' => 'Transacciones'
        ]);
        Wallet::create([
            'name' => "CAJA PRUEBA3",
            'description' => "recargas de PRUEBA3",
            'direction' => "CAJA PRUEBA3",
            'type_wallet' => 'Transacciones'
        ]);
        Wallet::create([
            'name' => "CAJA PRUEBA4",
            'description' => "recargas de PRUEBA4",
            'direction' => "CAJA PRUEBA4",
            'type_wallet' => 'Transacciones'
        ]);
        Wallet::create([
            'name' => "CAJA PRUEBA5",
            'description' => "recargas de PRUEBA5",
            'direction' => "CAJA PRUEBA5",
            'type_wallet' => 'Transacciones'
        ]);
        Wallet::create([
            'name' => "CAJA PRUEBA6",
            'description' => "recargas de PRUEBA6",
            'direction' => "CAJA PRUEBA6",
            'type_wallet' => 'Transacciones'
        ]);
    }
}
