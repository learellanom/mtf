<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Type_coin;

class Type_coinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Type_coin::create([
            'name' => "USD",
            'description' => "Dolar americano.",
            //'password' =>bcrypt('12345678'),
        ]);

        Type_coin::create([
            'name' => "EUR",
            'description' => "Moneda de Europa (Euro)",
            //'password' =>bcrypt('12345678'),
        ]);
        Type_coin::create([
            'name' => "RMB",
            'description' => "Moneda China",
            //'password' =>bcrypt('12345678'),
        ]);
        Type_coin::create([
            'name' => "BS",
            'description' => "Moneda Venezolana.",
            //'password' =>bcrypt('12345678'),
        ]);
        Type_coin::create([
            'name' => "Rial Brasileño",
            'description' => "Moneda de Brasil",
            //'password' =>bcrypt('12345678'),
        ]);
        Type_coin::create([
            'name' => "Peso Colombiano",
            'description' => "Moneda de Colombia",
            //'password' =>bcrypt('12345678'),
        ]);
        Type_coin::create([
            'name' => "Lira",
            'description' => "Moneda de Turquia",
            //'password' =>bcrypt('12345678'),
        ]);
        Type_coin::create([
            'name' => "Rublos",
            'description' => "Moneda de Rusia",
            //'password' =>bcrypt('12345678'),
        ]);
        Type_coin::create([
            'name' => "Peso Chileno",
            'description' => "Moneda de Chile",
            //'password' =>bcrypt('12345678'),
        ]);
        Type_coin::create([
            'name' => "Dólar canadiense",
            'description' => "Moneda de Canada",
            //'password' =>bcrypt('12345678'),
        ]);
        Type_coin::create([
            'name' => "Libra esterlina",
            'description' => "Moneda del Reino Unido",
            //'password' =>bcrypt('12345678'),
        ]);
        Type_coin::create([
            'name' => "Yenes (JPY)",
            'description' => "Moneda Japon",
            //'password' =>bcrypt('12345678'),
        ]);
        Type_coin::create([
            'name' => "USDT",
            'description' => "Tether (USDT)",
            //'password' =>bcrypt('12345678'),
        ]);
        Type_coin::create([
            'name' => "Ethereum (ETH)",
            'description' => "(ETH)",
            //'password' =>bcrypt('12345678'),
        ]);
        Type_coin::create([
            'name' => "Bitcoin (BTC)",
            'description' => "(BTC)",
            //'password' =>bcrypt('12345678'),
        ]);

    }
}
