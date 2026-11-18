<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Models\Course;

/*
|--------------------------------------------------------------------------
| Web Routes - KursusKu
|--------------------------------------------------------------------------
*/

// Halaman Beranda (Pertemuan 7, 9 & 10)
Route::get('/', [HomeController::class, 'index'])
    ->name('home');

// Resource Routes Kursus (CRUD Lengkap - Pertemuan 11)
Route::resource('courses', CourseController::class);

// Resource Routes Enrollment (Pertemuan 12 - Relasional Database)
Route::resource('enrollments', EnrollmentController::class)
    ->only(['index', 'create', 'store']);

// Kompatibilitas URL Pendaftaran sebelumnya (Redirect ke Route Pendaftaran Baru)
Route::get('/pendaftaran', function () {
    return redirect()->route('enrollments.create');
});

// Endpoint JSON Ketersediaan Kursus (Ajax GET - Model Course & MySQL)
Route::get('/availability/{course}', function (Course $course) {
    return response()->json([
        'id' => $course->id,
        'code' => $course->code,
        'name' => $course->name,
        'quota' => $course->quota,
        'status' => $course->status,
    ]);
})->name('courses.availability');

// Fallback alias untuk ketersediaan kursus
Route::get('/courses/{course}/availability', function (Course $course) {
    return response()->json([
        'id' => $course->id,
        'code' => $course->code,
        'name' => $course->name,
        'quota' => $course->quota,
        'status' => $course->status,
    ]);
});
