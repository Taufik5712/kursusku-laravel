<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Menampilkan landing page KursusKu.
     *
     * Data kursus dipindahkan dari data-courses.php (prototype PHP biasa,
     * Pertemuan 4) ke dalam controller Laravel. Struktur enam key
     * (code, name, fee, quota, registered, start_date) dipertahankan
     * sehingga logika "sisa kursi" dari prototype lama tetap relevan.
     */
    public function index()
    {
        $siteName = 'KursusKu';

        $featured = [
            [
                'code'       => 'WEB-01',
                'name'       => 'Web Dasar cepat',
                'description' => 'Belajar struktur HTML dan CSS dasar untuk membangun halaman web pertama Anda.',
                'fee'        => 200000,
                'quota'      => 30,
                'registered' => 12,
                'start_date' => '2026-09-21',
            ],
            [
                'code'       => 'PHP-01',
                'name'       => 'PHP Dasar',
                'description' => 'Belajar variabel, function, form, dan logika PHP dari nol.',
                'fee'        => 250000,
                'quota'      => 30,
                'registered' => 18,
                'start_date' => '2026-09-22',
            ],
            [
                'code'       => 'PHP-02',
                'name'       => 'PHP Lanjutan',
                'description' => 'Array, function reusable, dan validasi data pada studi kasus nyata.',
                'fee'        => 300000,
                'quota'      => 25,
                'registered' => 24,
                'start_date' => '2026-09-24',
            ],
            [
                'code'       => 'LAR-01',
                'name'       => 'Laravel Fundamental',
                'description' => 'Belajar route, controller, Blade, dan MVC bersama project KursusKu.',
                'fee'        => 350000,
                'quota'      => 25,
                'registered' => 25,
                'start_date' => '2026-09-28',
            ],
            [
                'code'       => 'DB-01',
                'name'       => 'MySQL Dasar',
                'description' => 'Merancang tabel dan query dasar sebagai bekal fase database.',
                'fee'        => 275000,
                'quota'      => 20,
                'registered' => 0,
                'start_date' => '2026-10-01',
            ],
            [
                'code'       => 'UI-01',
                'name'       => 'UI Web Dasar',
                'description' => 'Prinsip tampilan web yang rapi: layout, warna, dan tipografi.',
                'fee'        => 225000,
                'quota'      => 35,
                'registered' => 9,
                'start_date' => '2026-10-03',
            ],
        ];

        return view('home', compact('siteName', 'featured'));
    }
}
