<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Meeting;

class MeetingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Meeting::create([
            'mentor_id' => 1,
            'title' => 'Laravel CRUD',
            'meeting_date' => '2026-05-20',
            'meeting_time' => '19:00:00',
            'meeting_link' => 'https://meet.google.com/test',
            'description' => 'Belajar CRUD Laravel',
        ]);
    }
}
