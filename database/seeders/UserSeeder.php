<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => "Antonio Puerta",
            'email' => "antoniolenovo115@gmail.com",
            'password' =>bcrypt('12345678'),
        ])->assignRole('Administrador');

        User::create([
            'name' => "Luis Arellano",
            'email' => "luis.e.arellano@gmail.com",
            'password' =>bcrypt('12345678'),
        ])->assignRole('Administrador');

        User::Factory(5)->create();
    }
}
