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
        // Memanggil seeder MasterData dan MeetingSeeder
        $this->call([
            MasterData::class,
            MeetingSeeder::class,
        ]);
    }
}