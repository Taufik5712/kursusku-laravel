<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Pertemuan 7 — Route, Controller, Blade
|--------------------------------------------------------------------------
| Landing page KursusKu. Awalnya route ini berupa closure sementara
| (lihat PANDUAN-TERMINAL.md langkah 6), lalu dipindahkan ke HomeController
| agar alur Route -> Controller -> View terbentuk dengan benar.
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
