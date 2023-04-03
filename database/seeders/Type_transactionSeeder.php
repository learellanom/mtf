<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Type_transaction;

class Type_transactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Type_transaction::create([
            'name' => "Transferencias",
            'description' => "Pago en transferencias bancarias",
            //'password' =>bcrypt('12345678'),
        ]);

        Type_transaction::create([
            'name' => "Pago Efectivo",
            'description' => "Pagar en efectivo de caja ejectivo.",
            //'password' =>bcrypt('12345678'),
        ]);
        Type_transaction::create([
            'name' => "Cobro en efectivo",
            'description' => "Recibe ingreso la caja en efectivo",
            //'password' =>bcrypt('12345678'),
        ]);
        Type_transaction::create([
            'name' => "Mercancia",
            'description' => "Pago en mercancia, equivalente al dinero.",
            //'password' =>bcrypt('12345678'),
        ]);
        Type_transaction::create([
            'name' => "Credito de efectivo",
            'description' => "Credito a la caja de efectivo.",
            //'password' =>bcrypt('12345678'),
        ]);
        Type_transaction::create([
            'name' => "Ajustes",
            'description' => "Ajustes del switch",
            //'password' =>bcrypt('12345678'),
        ]);


        //Type_transaction::Factory(5)->create();
    }
}
