<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ClassModel;
use App\Models\Meeting;
use App\Models\Attendances;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MeetingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all mentors and classes
        $mentors = User::where('role', 'mentor')->get();
        $classes = ClassModel::all();

        if ($mentors->isEmpty() || $classes->isEmpty()) {
            $this->command->info('No mentors or classes found. Skipping MeetingSeeder.');
            return;
        }

        $meetingTitles = [
            'Pertemuan 1 - Pengenalan',
            'Pertemuan 2 - Dasar-Dasar',
            'Pertemuan 3 - Implementasi',
            'Pertemuan 4 - Studi Kasus',
            'Pertemuan 5 - Q&A & Review',
        ];

        $statuses = ['hadir', 'izin', 'sakit', 'alpa'];

        // Create meetings for each mentor and class combination
        foreach ($mentors as $mentor) {
            foreach ($classes as $class) {
                foreach ($meetingTitles as $index => $title) {
                    $meeting = Meeting::create([
                        'mentor_id' => $mentor->id,
                        'class_id' => $class->id,
                        'title' => $title,
                        'meeting_date' => now()->addDays($index + 1)->toDateString(),
                        'meeting_time' => now()->addDays($index + 1)->setHour(10)->setMinute(0),
                        'meeting_link' => 'https://meet.google.com/' . Str::random(12),
                        'description' => 'Pertemuan ke-' . ($index + 1) . ' untuk kelas ' . $class->name,
                    ]);

                    // Add sample attendance data
                    $members = $class->members()
                        ->whereIn('role', ['member', 'student'])
                        ->get();

                    foreach ($members as $member) {
                        // Randomly assign attendance status
                        $status = $statuses[array_rand($statuses)];

                        Attendances::create([
                            'meeting_id' => $meeting->id,
                            'member_id' => $member->id,
                            'status' => $status,
                            'input_by' => $mentor->id,
                        ]);
                    }

                    $this->command->info("Created meeting: {$meeting->title} for {$class->name} by {$mentor->name}");
                }
            }
        }

        $this->command->info('MeetingSeeder completed successfully!');
    }
}

