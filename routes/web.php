<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Models\Course;

/*
|--------------------------------------------------------------------------
| Web Routes - KursusKu
|--------------------------------------------------------------------------
*/

// Halaman Beranda (Publik)
Route::get('/', [HomeController::class, 'index'])
    ->name('home');

// Rute Administratif Course (Khusus Admin) — Ditempatkan sebelum courses/{course}
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{course}', [CourseController::class, 'update'])->name('courses.update');
    Route::patch('/courses/{course}', [CourseController::class, 'update']);
    Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');

    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
});

// Rute Publik Course (Guest, User, Admin)
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');

// Resource Routes Enrollment
Route::resource('enrollments', EnrollmentController::class)
    ->only(['index', 'create', 'store']);

// Kompatibilitas URL Pendaftaran sebelumnya
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

// Rute Autentikasi (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');

    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Rute Terproteksi Autentikasi (User & Admin)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});
