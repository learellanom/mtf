<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TransactionFactory extends Factory
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
            'type_coin_id' => 1,               // tipo moneda
            'amount_foreign_currency' => '0',                     // monto en moneda tipo
            'exchange_rate' => '0',                     // monto en moneda tipo

            'amount' => 1500,                     // monto transaccion en dorales

            'percentage' => 10,                  // porcentaje comision
            'exonerate' => 1,                    // indicador de exoneracion
            'amount_commission' => 110,            // monto comision

            'amount_total' => 100,               // monto transaccion en dorales + monto comision


            'type_transaction_id' => 1,          // tipo de transaccion

            'description' => fake()->text(),          // tipo de transaccion

            'user_id' => 1,                      // user o agente
            'client_id' => 1,
            'group_id' => 1,                      // Grupo al que se hace la transaccion
            'wallet_id' => 1,                    // wallet de la transaccion
            'status' => '1',                     // estado de la transaccion
            'transaction_date' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];

    }
}
