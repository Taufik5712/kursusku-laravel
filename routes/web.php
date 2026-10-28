<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Pertemuan 7 — Route, Controller, Blade
|--------------------------------------------------------------------------
| Landing page KursusKu dipindahkan dari closure sementara ke HomeController.
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Pertemuan 9 — Form pendaftaran (Blade + @csrf)
|--------------------------------------------------------------------------
| Data kursus untuk select masih berupa array sementara, selaras dengan
| data pada HomeController (belum memakai database).
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
| Pertemuan 9 — Route JSON dummy untuk jQuery Ajax
|--------------------------------------------------------------------------
| Sisa kursi dihitung dari quota - registered, memakai data yang sama
| dengan katalog di HomeController, lalu dikembalikan sebagai JSON.
*/
Route::get('/courses/{course}/availability', function (string $course) {
    $availability = [
        'WEB-01' => ['course' => 'Web Dasar', 'quota' => 30, 'registered' => 12],
        'PHP-01' => ['course' => 'PHP Dasar', 'quota' => 30, 'registered' => 18],
        'PHP-02' => ['course' => 'PHP Lanjutan', 'quota' => 25, 'registered' => 24],
        'LAR-01' => ['course' => 'Laravel Fundamental', 'quota' => 25, 'registered' => 25],
        'DB-01'  => ['course' => 'MySQL Dasar', 'quota' => 20, 'registered' => 0],
        'UI-01'  => ['course' => 'UI Web Dasar', 'quota' => 35, 'registered' => 9],
    ];

    abort_unless(isset($availability[$course]), 404);

    $item = $availability[$course];
    $remaining = $item['quota'] - $item['registered'];

    return response()->json([
        'course'    => $item['course'],
        'remaining' => $remaining,
    ]);
})->name('courses.availability');
