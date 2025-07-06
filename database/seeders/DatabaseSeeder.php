<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Grade;
use App\Models\Attendance;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        // For grades
        for( $i = 0; $i < 12; $i++) {
            Grade::create([
                'gradeId' => ($i + 1),
                'gradeName' => 'Grade-' . ($i + 1),
            ]);
        }
        // for attendance
        Attendance::create(['attendanceTypeId' => 1, 'attendanceType' => 'Present']);
        Attendance::create(['attendanceTypeId' => 2, 'attendanceType' => 'Absent with leave']);
        Attendance::create(['attendanceTypeId' => 3, 'attendanceType' => 'Absent without leave']);
        Attendance::create(['attendanceTypeId' => 4, 'attendanceType' => 'Weather']);

    }
}
