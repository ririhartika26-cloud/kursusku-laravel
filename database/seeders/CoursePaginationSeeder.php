<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Participant;
use Illuminate\Database\Seeder;

class CoursePaginationSeeder extends Seeder
{
    public function run(): void
    {
        $extraCourses = [
            [
                'code' => 'GIT-101',
                'name' => 'Version Control Dasar',
                'description' => 'Konsep pencatatan versi proyek perangkat lunak dan kolaborasi tim.',
                'fee' => 250000,
                'quota' => 25,
                'start_date' => '2026-12-21',
                'status' => 'open',
            ],
            [
                'code' => 'LAR-201',
                'name' => 'Laravel Lanjutan',
                'description' => 'Eloquent relasi lanjut, queue, event listener, dan optimasi query.',
                'fee' => 600000,
                'quota' => 20,
                'start_date' => '2026-12-22',
                'status' => 'open',
            ],
            [
                'code' => 'LAR-202',
                'name' => 'Laravel Testing & QA',
                'description' => 'Penulisan feature test, unit test, dan validasi otomatis pada Laravel.',
                'fee' => 550000,
                'quota' => 15,
                'start_date' => '2026-12-23',
                'status' => 'open',
            ],
            [
                'code' => 'WEB-201',
                'name' => 'Web Performance Optimization',
                'description' => 'Optimasi aset frontend, caching, dan kecepatan pemuatan halaman web.',
                'fee' => 420000,
                'quota' => 20,
                'start_date' => '2026-12-24',
                'status' => 'open',
            ],
            [
                'code' => 'UIX-201',
                'name' => 'UI/UX Prototyping',
                'description' => 'Pembuatan wireframe interaktif dan evaluasi usability antarmuka.',
                'fee' => 480000,
                'quota' => 18,
                'start_date' => '2026-12-26',
                'status' => 'closed',
            ],
            [
                'code' => 'DAT-201',
                'name' => 'Data Visualization',
                'description' => 'Penyajian grafik informatif dan dashboard pelaporan bisnis.',
                'fee' => 500000,
                'quota' => 22,
                'start_date' => '2026-12-27',
                'status' => 'draft',
            ],
            [
                'code' => 'SEC-101',
                'name' => 'Web Security Fundamental',
                'description' => 'Pencegahan SQL Injection, XSS, CSRF, dan validasi input aman.',
                'fee' => 520000,
                'quota' => 20,
                'start_date' => '2026-12-28',
                'status' => 'open',
            ],
        ];

        foreach ($extraCourses as $course) {
            Course::firstOrCreate(
                ['code' => $course['code']],
                $course
            );
        }

        $alya = Participant::where('email', 'alya@example.test')->first();
        $bima = Participant::where('email', 'bima@example.test')->first();
        $web = Course::where('code', 'WEB-101')->first();
        $php = Course::where('code', 'PHP-101')->first();

        if ($alya && $web) {
            Enrollment::firstOrCreate([
                'participant_id' => $alya->id,
                'course_id' => $web->id,
            ], ['status' => 'registered']);
        }
        if ($alya && $php) {
            Enrollment::firstOrCreate([
                'participant_id' => $alya->id,
                'course_id' => $php->id,
            ], ['status' => 'registered']);
        }
        if ($bima && $web) {
            Enrollment::firstOrCreate([
                'participant_id' => $bima->id,
                'course_id' => $web->id,
            ], ['status' => 'registered']);
        }
    }
}
