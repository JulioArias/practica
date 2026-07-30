<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario de prueba para iniciar sesión
        User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@boutique.com',
            'password' => bcrypt('password'),
        ]);

        $this->call([
            CategoriaSeeder::class,
        ]);
    }
}
