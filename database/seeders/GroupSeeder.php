<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Group;
class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $group1 = Group::create(['name'=>'Master Grupo 1', 'phone'=>'+1 555-555 222', 'description'=>'Grupo para transferencias', 'client_id' => 1]);
        $group2 = Group::create(['name'=>'Efectivo Grupo 2', 'phone'=>'+1 555-555 3333', 'description'=>'Grupo para movimientos en efectivo','client_id' => 1 ]);

    }
}
