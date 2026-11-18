<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Models\Course;

/*
|--------------------------------------------------------------------------
| Pertemuan 7 — Route, Controller, Blade
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Pertemuan 11 — Resource Course CRUD lengkap
|--------------------------------------------------------------------------
| Route::resource sudah mendaftarkan index, create, store, show, edit,
| update, dan destroy. Show/edit/update memakai route model binding.
| Validasi store/update ada di StoreCourseRequest dan UpdateCourseRequest.
|
| Jangan ubah migration. Schema courses tetap dari pertemuan 10.
*/
Route::resource('courses', CourseController::class);

/*
|--------------------------------------------------------------------------
| Pertemuan 12 — Enrollment nyata (Participant + Course lewat Enrollment)
|--------------------------------------------------------------------------
| Menggantikan closure /pendaftaran sementara dari Pertemuan 9 (lihat
| CATATAN-MIGRASI.md, bagian "Yang BELUM dimigrasikan" di Pertemuan 10 —
| ini tahap lanjutan yang dimaksud).
|
| Route::resource(...)->only(['index','create','store']) otomatis membuat:
|   GET  /enrollments/create  -> enrollments.create
|   POST /enrollments         -> enrollments.store
|   GET  /enrollments         -> enrollments.index  (laporan relasional)
| update/destroy sengaja tidak dibuka di pertemuan ini — scope-nya hanya
| create + store + report sesuai panduan.
*/
Route::resource('enrollments', EnrollmentController::class)
    ->only(['index', 'create', 'store']);

/*
|--------------------------------------------------------------------------
| Pertemuan 10 — Availability membaca dari database
|--------------------------------------------------------------------------
| Diperbarui di Pertemuan 12: dropdown course pada form enrollment sekarang
| mengirim course_id (foreign key numerik), bukan code lagi — karena
| course_id itulah yang disimpan ke tabel enrollments. Supaya widget "cek
| sisa kursi" di resources/js/app.js tetap jalan tanpa diubah, binding
| kolom diganti dari {course:code} menjadi {course} (default = id).
*/
Route::get('/courses/{course}/availability', function (Course $course) {
    return response()->json([
        'course'    => $course->name,
        'remaining' => $course->quota,
        'status'    => $course->status,
    ]);
})->name('courses.availability');
