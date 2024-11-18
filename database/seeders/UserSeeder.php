<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Crear un usuario administrador
        User::create([
            'name' => 'Gerardo',
            'surname' => 'Piñero',
            'email' => 'gerardop@sustemia.com.ar',
            'password' => Hash::make('password123'),
            'role_id' => 1,
        ]);

        // Crear un usuario editor
        User::create([
            'name' => 'Sofia',
            'surname' => 'Parikh',
            'email' => 'sofiap@sustemia.com.ar',
            'password' => Hash::make('password123'),
            'role_id' => 2,
        ]);

        // Crear un usuario visualizador
        User::create([
            'name' => 'Francis',
            'surname' => 'Underwood',
            'email' => 'francisu@sustemia.com.ar',
            'password' => Hash::make('password123'),
            'role_id' => 3,
        ]);
    }
}
