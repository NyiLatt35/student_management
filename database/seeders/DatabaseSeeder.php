<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Grade;
use App\Models\Attendance;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => Hash::make('password123')
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
