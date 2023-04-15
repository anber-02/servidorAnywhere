<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Comentarios;
use App\Models\Hoteles;
use App\Models\Restaurantes;
use App\Models\Tiendas;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // \App\Models\Tiendas::factory(20)->create();
        \App\Models\Tiendas::factory(20)
        ->has(Comentarios::factory(10))
        ->create();
        \App\Models\Restaurantes::factory(20)->create();
        \App\Models\Hoteles::factory(20)->create();
        // \App\Models\Comentarios::factory(50)->create();


        // Tiendas::factory()
        // ->has(Comentarios::factory()->count(3))
        // ->create();

    }
}
