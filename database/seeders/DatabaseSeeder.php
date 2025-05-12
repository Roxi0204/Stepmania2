<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
             CategorySeeder::class,
                UserSeeder::class,
         ]);
         
        /* User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/
    }
}


/*
 canciones N----1 albums
albums N----1  artistas
albums N----1 generos
canciones N----1  artistas
canciones 1--N cacion_genero N--1 generos
*/

