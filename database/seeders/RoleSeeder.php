<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder 
{
    public function run(): void
    {
        // Insertar roles solo si no existen
        if (DB::table('roles')->count() === 0) {
            DB::table('roles')->insert([
                ['name' => 'admin'],
                ['name' => 'editor'],
                ['name' => 'viewer'],
            ]);
        }
    }
}
