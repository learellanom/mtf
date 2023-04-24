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
        Group::create(['name'=>'Master Grupo', 'phone'=>'+1 555-555 222', 'description'=>'Grupo para transferencias']);
    }
}
