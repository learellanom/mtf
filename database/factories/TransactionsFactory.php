<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TransactionsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'type_coin_id' => '1',               // tipo moneda
            'amount' => '0',                     // monto en moneda tipo

            'amount_total' => 100,               // monto transaccion en dorales       
            'percentage' => 10,                  // comision
            'exonerate' => 0,                     // indicador de exoneracion
            'amount_total_transaction' => 110,   // monto transaccion en dorales + monto comision

            'type_transaction_id' => 1,          // tipo de transaccion

            'user_id' => 1,                      // user o agente
            'client_id' => 1,                    // cliente al que se hace la transaccion
            'wallet_id' => 1,                    // wallet de la transaccion
            'status' => '1',                     // estado de la transaccion
            'transaction_date' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        
    }
}
