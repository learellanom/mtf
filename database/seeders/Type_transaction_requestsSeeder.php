<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Type_transaction_request;

class Type_transaction_requestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Type_transaction_request::create([
            'name'                      => "Solicitud USDT",
            'description'               => "Solicitud USDT",
            'type_request'              => '1',
        ]);
        
        Type_transaction_request::create([
            'name'                      => "Solicitud Dolares Efectivo",
            'description'               => "Solicitud Dolares Efectivo",
            'type_request'              => '1',
        ]);
    
        Type_transaction_request::create([
            'name'                      => "Solicitud Bs efectivo",
            'description'               => "Solicitud Bs efectivo",
            'type_request'              => '1',
        ]);

        Type_transaction_request::create([
            'name'                      => "Solicitud  de reales Brazi",
            'description'               => "Solicitud  de reales Brazi",
            'type_request'              => '1',
        ]);





        Type_transaction_request::create([
            'name'                      => "Solicitud USDT",
            'description'               => "Solicitud USDT",
            'type_request'              => '1',
        ]);
        
        Type_transaction_request::create([
            'name'                      => "Notificación de Pago en Efectivo dorales",
            'description'               => "Notificación de Pago en Efectivo dorales",
            'type_request'              => '2',
        ]);
    
        Type_transaction_request::create([
            'name'                      => "Notificación de Pago en Efectivo bs",
            'description'               => "Notificación de Pago en Efectivo bs",
            'type_request'              => '2',
        ]);

        Type_transaction_request::create([
            'name'                      => "Notificación de Pago en transferencia Dorales",
            'description'               => "Notificación de Pago en transferencia Dorales",
            'type_request'              => '2',
        ]);        

        Type_transaction_request::create([
            'name'                      => "Notificación de Pago en transferencia Bolívares",
            'description'               => "Notificación de Pago en transferencia Bolívares",
            'type_request'              => '2',
        ]);       

        Type_transaction_request::create([
            'name'                      => "Notificación de entrega de Mercancia",
            'description'               => "Notificación de entrega de Mercancia",
            'type_request'              => '2',
        ]);       


    }
}
