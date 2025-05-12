<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Vehicles',
            'Immobiliaria',
            'Feina',
            'Tecnologia',
            'Moda i complements',
            'Llar i jardi',
            'Esports i oci',
            'Mascotes',
            'Serveis',
            'Altres'
        ];

        foreach ($categories as $description) {
            Category::updateOrCreate(
                ['name' => $description], // Fields to search
                ['name' => $description]  // Fields to create/update
            );
        }
    }
}
