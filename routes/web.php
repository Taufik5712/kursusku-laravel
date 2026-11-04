<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;
use App\Models\Course;

/*
|--------------------------------------------------------------------------
| Pertemuan 7 — Route, Controller, Blade
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Pertemuan 9 — Form pendaftaran (Blade + @csrf)
|--------------------------------------------------------------------------
| Daftar kursus pada form ini masih array sementara. Migrasi ke database
| direncanakan pada tahap lanjutan (lihat CATATAN-MIGRASI.md Pertemuan 10).
*/
Route::get('/pendaftaran', function () {
    $courses = [
        'WEB-01' => ['name' => 'Web Dasar'],
        'PHP-01' => ['name' => 'PHP Dasar'],
        'PHP-02' => ['name' => 'PHP Lanjutan'],
        'LAR-01' => ['name' => 'Laravel Fundamental'],
        'DB-01'  => ['name' => 'MySQL Dasar'],
        'UI-01'  => ['name' => 'UI Web Dasar'],
    ];

    return view('enrollments.create', compact('courses'));
})->name('enrollments.create');

Route::post('/pendaftaran/preview', function (Request $request) {
    $data = $request->validate([
        'name'      => ['required', 'string', 'min:3', 'max:100'],
        'email'     => ['required', 'email'],
        'course_id' => ['required', 'string'],
    ]);

    return back()
        ->with('success', 'Form lolos validasi. Database akan ditambahkan pada pertemuan berikutnya.')
        ->withInput();
})->name('enrollments.preview');

/*
|--------------------------------------------------------------------------
| Pertemuan 10 — Resource route Course (Database & Eloquent)
|--------------------------------------------------------------------------
| Route::resource menyiapkan pola CRUD lengkap (index, create, store, show,
| edit, update, destroy). Minggu ini hanya index(), create(), store() yang
| diimplementasikan di CourseController; show/edit/update/destroy menjadi
| materi pertemuan berikutnya.
*/
Route::resource('courses', CourseController::class);

/*
|--------------------------------------------------------------------------
| Pertemuan 10 — Availability sekarang membaca dari database
|--------------------------------------------------------------------------
| Menggantikan endpoint dummy Pertemuan 9. URL sengaja dipertahankan sama
| (/courses/{kode}/availability) agar resources/js/app.js dari Pertemuan 9
| tidak perlu diubah. {course:code} memakai route-model binding Laravel
| berdasarkan kolom 'code', bukan id numerik.
|
| Batas minggu ini: sisa kursi BELUM dihitung dari tabel Enrollment (relasi
| itu baru dibangun pada pertemuan berikutnya). Untuk sementara field
| 'remaining' menampilkan kuota penuh kursus tersebut.
*/
Route::get('/courses/{course:code}/availability', function (Course $course) {
    return response()->json([
        'course'    => $course->name,
        'remaining' => $course->quota,
        'status'    => $course->status,
    ]);
})->name('courses.availability');
