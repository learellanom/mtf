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
            'type_transaction' => 'Transacciones',
        ]);

        Type_transaction::create([
            'name' => "Pago Efectivo",
            'description' => "Pagar en efectivo de caja ejectivo.",
            'type_transaction' => 'Efectivo',
        ]);
        Type_transaction::create([
            'name' => "Cobro en efectivo",
            'description' => "Recibe ingreso la caja en efectivo",
            'type_transaction' => 'Efectivo',
        ]);
        Type_transaction::create([
            'name' => "Mercancia",
            'description' => "Pago en mercancia, equivalente al dinero.",
            'type_transaction' => 'Transacciones',
        ]);
        Type_transaction::create([
            'name' => "Credito de efectivo",
            'description' => "Credito a la caja de efectivo.",
            'type_transaction' => 'Credito',
        ]);
        Type_transaction::create([
            'name' => "Ajustes",
            'description' => "Ajustes del switch",
            'type_transaction' => 'Transacciones',
        ]);


        //Type_transaction::Factory(5)->create();
    }
}
