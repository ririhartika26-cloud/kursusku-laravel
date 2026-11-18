<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            [
                'code' => 'WEB-101',
                'name' => 'Web Dasar',
                'description' => 'Mempelajari dasar HTML5, CSS3, dan konsep dasar web modern.',
                'fee' => 300000,
                'quota' => 25,
                'start_date' => '2026-12-01',
                'status' => 'open',
            ],
            [
                'code' => 'PHP-101',
                'name' => 'PHP Fundamental',
                'description' => 'Sintaks dasar PHP, kontrol alur, fungsi, pemrosesan formulir, dan penanganan data.',
                'fee' => 400000,
                'quota' => 25,
                'start_date' => '2026-12-05',
                'status' => 'open',
            ],
            [
                'code' => 'LRV-101',
                'name' => 'Laravel Dasar',
                'description' => 'Arsitektur MVC, Blade templating, routing, controller, Eloquent ORM, dan migrasi.',
                'fee' => 500000,
                'quota' => 20,
                'start_date' => '2026-12-10',
                'status' => 'open',
            ],
            [
                'code' => 'SQL-101',
                'name' => 'MySQL Dasar',
                'description' => 'Perancangan basis data relasional, DDL, DML, relasi antar tabel, dan optimasi query.',
                'fee' => 350000,
                'quota' => 30,
                'start_date' => '2026-12-08',
                'status' => 'open',
            ],
            [
                'code' => 'UI-101',
                'name' => 'Bootstrap UI',
                'description' => 'Membangun antarmuka web responsif dan profesional menggunakan komponen Bootstrap 5.',
                'fee' => 300000,
                'quota' => 25,
                'start_date' => '2026-12-15',
                'status' => 'draft',
            ],
            [
                'code' => 'JS-101',
                'name' => 'JavaScript Dasar',
                'description' => 'Dasar pemrograman JavaScript, manipulasi DOM, event handling, dan ES6 modern.',
                'fee' => 400000,
                'quota' => 20,
                'start_date' => '2026-12-12',
                'status' => 'open',
            ],
            [
                'code' => 'AJAX-101',
                'name' => 'jQuery dan Ajax',
                'description' => 'Komunikasi asynchronous dengan server, pertukaran data JSON, dan update DOM tanpa reload.',
                'fee' => 450000,
                'quota' => 20,
                'start_date' => '2026-12-18',
                'status' => 'draft',
            ],
            [
                'code' => 'API-101',
                'name' => 'REST API Dasar',
                'description' => 'Konsep perancangan endpoint RESTful API, HTTP status code, autentikasi token, dan JSON formatting.',
                'fee' => 550000,
                'quota' => 18,
                'start_date' => '2026-12-20',
                'status' => 'closed',
            ],
        ];

        foreach ($courses as $course) {
            Course::firstOrCreate(
                ['code' => $course['code']],
                $course
            );
        }
    }
}
