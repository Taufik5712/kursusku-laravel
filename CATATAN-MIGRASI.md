# Catatan Migrasi: Pertemuan 9 → Pertemuan 10

## Apa yang berubah dari project Pertemuan 9

| File | Status | Perubahan |
|---|---|---|
| `routes/web.php` | Diperbarui | Ditambah `Route::resource('courses', CourseController::class)`; endpoint `courses.availability` diganti total — sebelumnya array dummy, sekarang membaca `Course` dari database lewat route-model binding `{course:code}` |
| `resources/views/partials/navbar.blade.php` | Diperbarui | Ditambah link "Daftar Kursus" ke `courses.index` |
| `resources/css/app.css` | Diperbarui | Ditambah gaya `.table-dark` agar tabel daftar kursus konsisten dengan tema glassmorphism |

## File baru di Pertemuan 10

| File Laravel | Asal | Keterangan |
|---|---|---|
| `database/migrations/..._create_courses_table.php` | Blueprint panduan Pertemuan 10 | Mendefinisikan struktur tabel `courses` — belum pernah ada di prototype PHP lama (dulu data hanya array di `data-courses.php`) |
| `app/Models/Course.php` | — | Representasi tabel `courses` lewat Eloquent; `$fillable` membatasi field yang boleh diisi massal, `casts()` mengubah `start_date` jadi objek tanggal |
| `app/Http/Controllers/CourseController.php` | `HomeController` (P7) sebagai pola dasar | `index()` mengambil semua course dari DB; `create()` menampilkan form; `store()` memvalidasi lalu `Course::create($data)` |
| `resources/views/courses/index.blade.php` | `home.blade.php` (P7) sebagai pola card → diubah jadi tabel | Memakai `@extends('layouts.app')` dari P9 |
| `resources/views/courses/create.blade.php` | `enrollments/create.blade.php` (P9) sebagai pola form | Field disesuaikan dengan kolom tabel `courses`; `@error` dan `old()` ditambahkan untuk validasi |
| `database/seeders/CourseSeeder.php` | Data 8 kursus di `HomeController` (P7, sudah dengan quota/fee) | Dipakai sebagai jalan pintas mengisi data, opsional |

## Kenapa field `remaining` pada `courses.availability` sekarang = kuota penuh?

Sesuai batas scope Pertemuan 10: endpoint ini **cukup membaca** data
`Course`, belum menghitung sisa kursi berdasarkan jumlah pendaftar asli
(`Enrollment`), karena relasi Course–Enrollment baru dibangun pada
pertemuan berikutnya. Jadi untuk sementara `remaining` menampilkan kuota
penuh kursus tersebut, bukan `quota - jumlah_pendaftar`.

## Yang BELUM dimigrasikan
- Form pendaftaran (`/pendaftaran`) masih memakai array kursus sementara,
  belum menarik data dari tabel `courses`.
- Sisa kursi pada landing page (`home.blade.php`) masih dari array di
  `HomeController`, belum dari database.

Kedua hal ini direncanakan untuk tahap lanjutan setelah Update/Delete dan
relasi Enrollment selesai, supaya seluruh project memakai satu sumber
data yang sama (tabel `courses`).

## Konsep baru yang dipelajari
- Migration: mendefinisikan struktur tabel secara terkontrol dan dapat
  direproduksi (`up()`/`down()`)
- Model Eloquent: `$fillable`, `casts()`, query seperti `Course::latest()->get()`
- `Route::resource`: satu baris mendaftarkan pola URL CRUD standar
- Route-model binding kustom (`{course:code}`) — mengikat parameter route
  ke kolom tertentu, bukan hanya `id`
- Validasi di controller sebelum `Course::create()` — termasuk rule
  `unique`, `min`, `max`, `in`

## Perbaikan: SQLite → MySQL

Saat kode ini pertama kali dijalankan, project memakai `DB_CONNECTION=sqlite`
(default `laravel new`) dan sempat berhasil menyimpan 8 data percobaan di
`database/database.sqlite`. Ini **menyimpang dari panduan**, yang secara
eksplisit meminta MySQL lewat Laragon dengan nama database `kursusku`
(Bagian 4 & 5 Panduan Pertemuan 10).

Perbaikan yang dilakukan:
- `.env` diubah dari `DB_CONNECTION=sqlite` menjadi `DB_CONNECTION=mysql`
  dengan `DB_DATABASE=kursusku`.
- File `database/database.sqlite` lama dikeluarkan dari paket (data di
  dalamnya tidak ikut pindah otomatis — lihat `database/sql/` untuk
  mengisi ulang 8 data yang sama di MySQL).
- Ditambahkan `database/sql/01-create-database.sql`,
  `02-reference-courses-table.sql`, dan `03-seed-8-courses.sql` untuk
  mempercepat setup database MySQL dari nol.
- Kode aplikasi (migration, model, controller, view) **tidak diubah**
  karena sudah sesuai panduan — Eloquent bekerja sama persis di atas
  SQLite maupun MySQL, jadi tidak ada logika yang perlu ditulis ulang.
