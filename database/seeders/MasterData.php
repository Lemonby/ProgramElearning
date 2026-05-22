<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Classes;
use App\Models\Material;
use App\Models\Meeting;
use App\Models\Assignments;
use App\Models\Submission;
use App\Models\Attendances;

class MasterData extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        // ============================================================
        // AKUN FIXED UNTUK TESTING
        // mentor: mentor@test.com / password
        // member: member@test.com / password
        // ============================================================

        // ============================================================
        // CLASSES
        // ============================================================

        $classNames = ['Web Development', 'UI/UX Design', 'Data Science'];
        $classes = [];

        foreach ($classNames as $name) {
            $classes[] = Classes::create([
                'name'        => $name,
                'description' => $faker->paragraph(3),
            ]);
        }

        // ============================================================
        // USERS — MENTOR (1 per kelas)
        // ============================================================

        $mentors = [];
        $isFirstMentor = true;

        foreach ($classes as $index => $class) {
            if ($isFirstMentor) {
                // Akun mentor fixed untuk testing
                $mentors[] = User::create([
                    'name'     => 'Mentor Test',
                    'email'    => 'mentor@test.com',
                    'password' => Hash::make('password'),
                    'role'     => 'mentor',
                    'class_id' => $class->id,
                ]);
                $isFirstMentor = false;
            } else {
                $mentors[] = User::create([
                    'name'     => $faker->name(),
                    'email'    => $faker->unique()->safeEmail(),
                    'password' => Hash::make('password'),
                    'role'     => 'mentor',
                    'class_id' => $class->id,
                ]);
            }
        }

        // ============================================================
        // USERS — MEMBER (10 per kelas)
        // ============================================================

        $membersByClass = [];
        $isFirstMember  = true;

        foreach ($classes as $index => $class) {
            $membersByClass[$class->id] = [];

            for ($n = 0; $n < 10; $n++) {
                if ($isFirstMember) {
                    // Akun member fixed untuk testing
                    $member = User::create([
                        'name'     => 'Member Test',
                        'email'    => 'member@test.com',
                        'password' => Hash::make('password'),
                        'role'     => 'member',
                        'class_id' => $class->id,
                    ]);
                    $isFirstMember = false;
                } else {
                    $member = User::create([
                        'name'     => $faker->name(),
                        'email'    => $faker->unique()->safeEmail(),
                        'password' => Hash::make('password'),
                        'role'     => 'member',
                        'class_id' => $class->id,
                    ]);
                }

                $membersByClass[$class->id][] = $member;
            }
        }

        // ============================================================
        // MATERIALS (5 per kelas)
        // ============================================================

        $materialTopics = [
            'Web Development' => ['HTML & CSS Dasar', 'JavaScript Fundamentals', 'Laravel Framework', 'REST API', 'Deployment & CI/CD'],
            'UI/UX Design'    => ['Prinsip Desain', 'Figma Fundamentals', 'User Research', 'Prototyping', 'Usability Testing'],
            'Data Science'    => ['Python untuk Data', 'Statistik Dasar', 'Pandas & NumPy', 'Machine Learning', 'Visualisasi Data'],
        ];

        foreach ($classes as $class) {
            $topics = $materialTopics[$class->name];
            foreach ($topics as $topic) {
                Material::create([
                    'class_id'    => $class->id,
                    'title'       => $topic,
                    'description' => $faker->paragraph(2),
                    'file_url'    => 'https://storage.example.com/materials/' . \Str::slug($topic) . '.pdf',
                ]);
            }
        }

        // ============================================================
        // MEETINGS (4 per kelas)
        // ============================================================

        $meetingsByClass = [];

        foreach ($classes as $index => $class) {
            $mentor = $mentors[$index];
            $meetingsByClass[$class->id] = [];

            for ($k = 1; $k <= 4; $k++) {
                $date = now()->addWeeks($k);

                $meeting = Meeting::create([
                    'class_id'     => $class->id,
                    'mentor_id'    => $mentor->id,
                    'title'        => "Pertemuan {$k} — {$class->name}",
                    'meeting_date' => $date->toDateString(),
                    'meeting_time' => '19:00:00',
                    'meeting_link' => 'https://meet.google.com/' . $faker->lexify('???-????-???'),
                    'description'  => $faker->sentence(10),
                ]);

                $meetingsByClass[$class->id][] = $meeting;
            }
        }

        // ============================================================
        // ASSIGNMENTS (3 per kelas)
        // ============================================================

        $assignmentsByClass = [];

        foreach ($classes as $class) {
            $assignmentsByClass[$class->id] = [];

            $assignmentTitles = [
                "Tugas 1 — Praktik Dasar {$class->name}",
                "Tugas 2 — Studi Kasus {$class->name}",
                "Tugas Akhir — Project {$class->name}",
            ];

            foreach ($assignmentTitles as $i => $title) {
                $assignment = Assignments::create([
                    'class_id'    => $class->id,
                    'title'       => $title,
                    'description' => $faker->paragraph(3),
                    'deadline'    => now()->addWeeks($i + 2)->toDateTimeString(),
                    'file_path'   => null,
                ]);

                $assignmentsByClass[$class->id][] = $assignment;
            }
        }

        // ============================================================
        // SUBMISSIONS (setiap member submit semua assignment kelasnya)
        // ============================================================

        $statusOptions = ['sudah', 'sudah', 'sudah', 'belum']; // 75% sudah submit

        foreach ($classes as $class) {
            $members     = $membersByClass[$class->id];
            $assignments = $assignmentsByClass[$class->id];

            foreach ($assignments as $assignment) {
                foreach ($members as $member) {
                    // 75% chance submit
                    if ($faker->boolean(75)) {
                        Submission::create([
                            'assignment_id' => $assignment->id,
                            'member_id'     => $member->id,
                            'file_url'      => 'https://storage.example.com/submissions/' . $faker->lexify('????????') . '.pdf',
                            'is_upload'     => true,
                            'submitted_at'  => $faker->dateTimeBetween('-2 weeks', 'now'),
                            'graded_at'     => $faker->boolean(60) ? $faker->dateTimeBetween('-1 week', 'now') : null,
                        ]);
                    }
                }
            }
        }

        // ============================================================
        // ATTENDANCES (setiap member di setiap meeting kelasnya)
        // ============================================================

        $attendanceStatus = ['hadir', 'hadir', 'hadir', 'izin', 'sakit', 'alpa'];

        foreach ($classes as $index => $class) {
            $mentor   = $mentors[$index];
            $members  = $membersByClass[$class->id];
            $meetings = $meetingsByClass[$class->id];

            foreach ($meetings as $meeting) {
                foreach ($members as $member) {
                    Attendances::create([
                        'meeting_id' => $meeting->id,
                        'member_id'  => $member->id,
                        'status'     => $faker->randomElement($attendanceStatus),
                        'input_by'   => $mentor->id,
                    ]);
                }
            }
        }

        $this->command->info('✅ Seeder selesai!');
        $this->command->info('   mentor@test.com  / password');
        $this->command->info('   member@test.com  / password');
    }
}