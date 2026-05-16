<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Classes;
use App\Models\Material;
use App\Models\Meeting;
use App\Models\Assignments;
use App\Models\Submission;
use App\Models\Attendances;
use App\Models\Notification;

class MasterData extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        // buat 3 kelas
        for ($i = 0; $i < 3; $i++) {
            Classes::create([
                'name' => $faker->sentence(3),
                'description' => $faker->paragraph(),
            ]);
        }
        $classes = Classes::all(); 

        // buat 18 user member per kelas (total 54 member)
        foreach ($classes as $class) {
            for ($n = 0; $n < 18; $n++) {
                User::create([
                    'name' => $faker->name(),
                    'email' => $faker->unique()->safeEmail(),
                    'password' => bcrypt('password'),
                    'role' => 'member',
                    'class_id' => $class->id,
                ]);
            }
        }

        // buat 3 user mentor (1 mentor per kelas)
        foreach ($classes as $class) {
            User::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'password' => bcrypt('password'),
                'role' => 'mentor',
                'class_id' => $class->id,
            ]);
        }

        // // buat 5 materi untuk setiap kelas
        // foreach ($classes as $class) {
        //     for ($j = 0; $j < 5; $j++) {
        //         Material::create([
        //             'class_id' => $class->id,
        //             'title' => $faker->sentence(4),
        //             'description' => $faker->paragraph(),
        //             'file_url' => $faker->url(),
        //         ]);
        //     }
        // }

        // // buat 3 pertemuan untuk setiap kelas
        // foreach ($classes as $class) {
        //     for ($k = 0; $k < 3; $k++) {
        //         Meeting::create([
        //             'class_id' => $class->id,
        //             'title' => $faker->sentence(4),
        //             'meeting_time' => $faker->dateTimeBetween('+1 week', '+1 month'),
        //             'meeting_link' => $faker->url(),
        //         ]);
        //     }
        // }

        // // buat 2 assessment untuk setiap kelas
        // foreach ($classes as $class) {
        //     for ($l = 0; $l < 2; $l++) {
        //         Assignments::create([
        //             'class_id' => $class->id,
        //             'title' => $faker->sentence(4),
        //             'description' => $faker->paragraph(),
        //             'deadline' => $faker->dateTimeBetween('+1 week', '+1 month'),
        //         ]);
        //     }
        // }

        // // =======================================================================
        // // 4. TERAKHIR DATA SUBMISSION DAN ATTENDANCE (Aman karena User ID nya sudah ada)
        // // =======================================================================

        // // buat 10 submission untuk setiap assessment
        // $assignments = Assignments::all();
        // foreach ($assignments as $assignment) {
        //     for ($m = 0; $m < 10; $m++) {
        //         Submission::create([
        //             'assignment_id' => $assignment->id, // Pastikan kolom ini match dengan database (assignment_id vs assessment_id)
        //             'member_id' => $faker->numberBetween(2, 50), // ID dimulai dari 2, karena ID 1 adalah 'Agung' (mentor)
        //             'file_url' => $faker->url(),
        //             'submitted_at' => $faker->dateTimeBetween('-1 week', 'now'),
        //             'graded_at' => $faker->dateTimeBetween('now', '+1 week'),
        //         ]);
        //     }
        // }

        // // buat 5 attendance untuk setiap pertemuan
        // $meetings = Meeting::all();
        // foreach ($meetings as $meeting) {
        //     for ($o = 0; $o < 5; $o++) {
        //         Attendances::create([
        //             'meeting_id' => $meeting->id,
        //             'member_id' => $faker->numberBetween(2, 50), 
        //             'status' => $faker->randomElement(['present', 'absent', 'late']),
        //             'input_by' => $faker->numberBetween(51, 54), // Id mentor yang buat disesuaikan dengan urutan id mentor (biasanya di ID besar paling akhir)
        //         ]);
        //     }
        // }
    }
}
