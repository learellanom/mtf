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
            'name'                      => "Pago en Transferencia",
            'description'               => "Pago en transferencias bancarias",
            'type_transaction'          => 'Transacciones',
            'type_transaction_wallet'   => '2',
            'type_transaction_group'    => '1',
        ]);
        Type_transaction::create([
            'name'                      => "Cobro en Transferencia",
            'description'               => "Cobro en transferencias bancarias",
            'type_transaction'          => 'Transacciones',
            'type_transaction_wallet'   => '1',
            'type_transaction_group'    => '2',

        ]);
        Type_transaction::create([
            'name'                      => "Pago Efectivo",
            'description'               => "Pagar en efectivo de caja ejectivo.",
            'type_transaction'          => 'Efectivo',
            'type_transaction_wallet'   => '2',
            'type_transaction_group'    => '1',

        ]);
        Type_transaction::create([
            'name'                      => "Cobro en efectivo",
            'description'               => "Recibe ingreso la caja en efectivo",
            'type_transaction'          => 'Efectivo',
            'type_transaction_wallet'   => '1',
            'type_transaction_group'    => '2',

        ]);
        Type_transaction::create([
            'name'                      => "Pago Mercancia",
            'description'               => "Pago en mercancia, equivalente al dinero.",
            'type_transaction'          => 'Transacciones',
            'type_transaction_wallet'   => '2',
            'type_transaction_group'    => '1',

        ]);
        Type_transaction::create([
            'name'                      => "Entrada de efectivo",
            'description'               => "Credito a la caja de efectivo.",
            'type_transaction'          => 'Credito',
            'type_transaction_wallet'   => '1',
            'type_transaction_group'    => '1',

        ]);
        Type_transaction::create([
            'name'                      => "Nota de Credito",
            'description'               => "Nota de Credito",
            'type_transaction'          => 'Credito',
            'type_transaction_wallet'   => '1',
            'type_transaction_group'    => '1',

        ]);
        Type_transaction::create([
            'name'                      => "Nota de debito",
            'description'               => "Nota de Debito",
            'type_transaction'          => 'Transacciones',
            'type_transaction_wallet'   => '2',
            'type_transaction_group'    => '2',

        ]);
        Type_transaction::create([
            'name'                      => "Swift",
            'description'               => "Ajustes del Swift",
            'type_transaction'          => 'Transacciones',
            'type_transaction_wallet'   => '2',
            'type_transaction_group'    => '1',

        ]);
        Type_transaction::create([
            'name'                      => "Cobro Mercancia",
            'description'               => "Cobro Mercancia",
            'type_transaction'          => 'Transacciones',
            'type_transaction_wallet'   => '1',
            'type_transaction_group'    => '2',

        ]);
        Type_transaction::create([
            'name'                      => "Pago USDT",
            'description'               => "Pago USDT",
            'type_transaction'          => 'Transacciones',
            'type_transaction_wallet'   => '2',
            'type_transaction_group'    => '1',

        ]);
        Type_transaction::create([
            'name'                      => "Salida de Efectivo",
            'description'               => "Salida de Efectivo",
            'type_transaction'          => 'Transacciones',
            'type_transaction_wallet'   => '2',
            'type_transaction_group'    => '2',

        ]);
        Type_transaction::create([
            'name'                      => "Cobro USDT",
            'description'               => "Cobro USDT",
            'type_transaction'          => 'Transacciones',
            'type_transaction_wallet'   => '1',
            'type_transaction_group'    => '2',

        ]);
        Type_transaction::create([
            'name'                      => "Pago RMB",
            'description'               => "Pago RMB",
            'type_transaction'          => 'Transacciones',
            'type_transaction_wallet'   => '2',
            'type_transaction_group'    => '1',
        ]);
        Type_transaction::create([
            'name'                      => "Pago Dubai",
            'description'               => "Pago Dubai",
            'type_transaction'          => 'Transacciones',
            'type_transaction_wallet'   => '2',
            'type_transaction_group'    => '1',
        ]);
        Type_transaction::create([
            'name'                      => "Pago Turkia",
            'description'               => "Pago Turkia",
            'type_transaction'          => 'Transacciones',
            'type_transaction_wallet'   => '2',
            'type_transaction_group'    => '1',
        ]);
        Type_transaction::create([
            'name'                      => "Pago Libano",
            'description'               => "Pago Libano",
            'type_transaction'          => 'Transacciones',
            'type_transaction_wallet'   => '2',
            'type_transaction_group'    => '1',
        ]);
        Type_transaction::create([
            'name'                      => "Pago USA",
            'description'               => "Pago USA",
            'type_transaction'          => 'Transacciones',
            'type_transaction_wallet'   => '2',
            'type_transaction_group'    => '1',
        ]);
        Type_transaction::create([
            'name'                      => "Cobro USA",
            'description'               => "Cobro USA",
            'type_transaction'          => 'Transacciones',
            'type_transaction_wallet'   => '1',
            'type_transaction_group'    => '2',
        ]);            
        Type_transaction::create([
            'name'                      => "Cobro Libano",
            'description'               => "Cobro Libano",
            'type_transaction'          => 'Transacciones',
            'type_transaction_wallet'   => '1',
            'type_transaction_group'    => '2',
        ]);
        Type_transaction::create([
            'name'                      => "Cobro Turkia",
            'description'               => "Cobro Turkia",
            'type_transaction'          => 'Transacciones',
            'type_transaction_wallet'   => '1',
            'type_transaction_group'    => '2',
        ]);
        Type_transaction::create([
            'name'                      => "Cobro RMB",
            'description'               => "Cobro RMB",
            'type_transaction'          => 'Transacciones',
            'type_transaction_wallet'   => '1',
            'type_transaction_group'    => '2',
        ]);
        Type_transaction::create([
            'name'                      => "Cobro Dubai",
            'description'               => "Cobro Dubai",
            'type_transaction'          => 'Transacciones',
            'type_transaction_wallet'   => '1',
            'type_transaction_group'    => '2',
        ]);
        Type_transaction::create([
            'name'                      => "Cobro en Boletos",
            'description'               => "Cobro en BOletos",
            'type_transaction'          => 'Transacciones',
            'type_transaction_wallet'   => '1',
            'type_transaction_group'    => '2',
        ]);        
        Type_transaction::create([
            'name'                      => "Pago Jordan",
            'description'               => "Pago Jordan",
            'type_transaction'          => 'Transacciones',
            'type_transaction_wallet'   => '2',
            'type_transaction_group'    => '1',
        ]);        
        Type_transaction::create([
            'name'                      => "Cobro Jordan",
            'description'               => "Cobro Jordan",
            'type_transaction'          => 'Transacciones',
            'type_transaction_wallet'   => '1',
            'type_transaction_group'    => '2',
        ]);        

        //Type_transaction::Factory(5)->create();
    }
}
