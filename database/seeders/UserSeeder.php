<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
        'name' => 'Agung',
        'email' => 'angung@gmail.com',
        'password' => Hash::make('password'),
        'role' => 'mentor',
        ]);

        User::create([
            'name' => 'Anggi',
            'email' => 'anggi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'mentor',
        ]);
    }
}
