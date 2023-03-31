<?php

namespace Database\Seeders;

use Database\Factories\Transaction_masterFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transaction_master;
class TransactionMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Transaction_master::Factory(50)->create();
    }
}
