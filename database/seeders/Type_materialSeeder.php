<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Type_materialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Type_material::create([
            'name' => "Oro",
            'description' => "Oro en Gramos",
            //'password' =>bcrypt('12345678'),
        ]);

    }
}
