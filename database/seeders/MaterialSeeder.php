<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Material;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Material::create([
            'class_id' => 1,
            'title' => 'Pengenalan Laravel',
            'description' => 'Materi Dasar Laravel',
            'file_url' => 'materials/laravel.pdf',
        ]);
    }
}
