<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Type_transaction_request;
use Illuminate\Support\Facades\DB;

class Type_transaction_request_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('type_transaction_requets')->insert([
            'name'          => "Solicitud USDT",
            'description'   => "Solicitud USDT",
        ]);
     
        DB::table('type_transaction_requets')->insert([
            'name'          => "Solicitud Dolares Efectivo",
            'description'   => "Solicitud Dolares Efectivo",
        ]);

        DB::table('type_transaction_requets')->insert([
            'name'          => "Solicitud Bs efectivo",
            'description'   => "Solicitud Bs efectivo",
        ]);
   
        DB::table('type_transaction_requets')->insert([
            'name'          => "Solicitud  de reales Brazil",
            'description'   => "Solicitud  de reales Brazil",
        ]);        

        DB::table('type_transaction_requets')->insert([
            'name'          => "Notificación de Pago en Efectivo dorales",
            'description'   => "Notificación de Pago en Efectivo dorales",
        ]);        

        DB::table('type_transaction_requets')->insert([
            'name'          => "Notificación de Pago en Efectivo bs",
            'description'   => "Notificación de Pago en Efectivo bs",
        ]);     

        DB::table('type_transaction_requets')->insert([
            'name'          => "Notificación de Pago en transferencia Dorales",
            'description'   => "Notificación de Pago en transferencia Dorales",
        ]);       
        
        DB::table('type_transaction_requets')->insert([
            'name'          => "Notificación de Pago en transferencia Dorales",
            'description'   => "Notificación de Pago en transferencia Bolívares",
        ]);          
    }
}
