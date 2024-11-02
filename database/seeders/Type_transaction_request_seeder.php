<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Type_transaction_request;

class Type_transaction_request_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Type_transaction_request::create([
            'name'          => "Solicitud USDT",
            'description'   => "Solicitud USDT",
        ]);

        Type_transaction_request::create([
            'name'          => "Solicitud Dolares Efectivo",
            'description'   => "Solicitud Dolares Efectivo",
        ]);

        Type_transaction_request::create([
            'name'          => "Solicitud Bs efectivo",
            'description'   => "Solicitud Bs efectivo",
        ]);
   
        Type_transaction_request::create([
            'name'          => "Solicitud  de reales Brazil",
            'description'   => "Solicitud  de reales Brazil",
        ]);        

        Type_transaction_request::create([
            'name'          => "Notificación de Pago en Efectivo dorales",
            'description'   => "Notificación de Pago en Efectivo dorales",
        ]);        

        Type_transaction_request::create([
            'name'          => "Notificación de Pago en Efectivo bs",
            'description'   => "Notificación de Pago en Efectivo bs",
        ]);     

        Type_transaction_request::create([
            'name'          => "Notificación de Pago en transferencia Dorales",
            'description'   => "Notificación de Pago en transferencia Dorales",
        ]);       
        
        Type_transaction_request::create([
            'name'          => "Notificación de Pago en transferencia Dorales",
            'description'   => "Notificación de Pago en transferencia Bolívares",
        ]);          
    }
}
