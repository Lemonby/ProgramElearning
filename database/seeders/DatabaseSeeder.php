<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\MasterData;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Memanggil seeder MasterData yang sudah kamu buat
        $this->call([
            UserSeeder::class,
            ClassSeeder::class,
            MeetingSeeder::class,
            MaterialSeeder::class,
            AttendanceSeeder::class,
        ]);
    }
}