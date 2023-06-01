<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ClientSeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(WalletSeeder::class);
        $this->call(Type_transactionSeeder::class);
        $this->call(Type_coinSeeder::class);
        //$this->call(SupplierSeeder::class);
        //$this->call(TransactionSeeder::class);
    }
}
