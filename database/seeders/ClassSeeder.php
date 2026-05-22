<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ClassModel;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ClassModel::create([
            'mentor_id' => 1,
            'name' => 'Laravel Fundamental',
            'description' => 'Belajar CRUD Laravel',
        ]);

        ClassModel::create([
            'mentor_id' => 2,
            'name' => 'UI UX Design',
            'description' => 'Belajar desain aplikasi',
        ]);
    }
}
