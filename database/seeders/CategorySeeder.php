<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Ingresos
            ['name' => 'Salario', 'type' => 'income', 'color' => '#10B981'],
            ['name' => 'Freelance', 'type' => 'income', 'color' => '#059669'],
            ['name' => 'Inversiones', 'type' => 'income', 'color' => '#047857'],
            
            // Gastos
            ['name' => 'Alimentación', 'type' => 'expense', 'color' => '#EF4444'],
            ['name' => 'Transporte', 'type' => 'expense', 'color' => '#F97316'],
            ['name' => 'Vivienda', 'type' => 'expense', 'color' => '#EAB308'],
            ['name' => 'Entretenimiento', 'type' => 'expense', 'color' => '#8B5CF6'],
            ['name' => 'Salud', 'type' => 'expense', 'color' => '#EC4899'],
            ['name' => 'Educación', 'type' => 'expense', 'color' => '#3B82F6'],
            ['name' => 'Otros', 'type' => 'expense', 'color' => '#6B7280'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}