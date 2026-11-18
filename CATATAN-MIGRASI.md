# Catatan Migrasi: Pertemuan 11 → Pertemuan 12

## Apa yang berubah dari project Pertemuan 11

| File | Status | Perubahan |
|---|---|---|
| `routes/web.php` | Diperbarui | Closure `/pendaftaran` dan `/pendaftaran/preview` (sisa Pertemuan 9) **dihapus total**, diganti `Route::resource('enrollments', EnrollmentController::class)->only(['index','create','store'])`. Endpoint `courses.availability` diubah dari `{course:code}` menjadi `{course}` (default id) karena dropdown course di form enrollment sekarang mengirim `course_id`, bukan `code` |
| `app/Models/Course.php` | Diperbarui | Ditambah relasi `enrollments()` (hasMany) dan `participants()` (belongsToMany lewat tabel `enrollments`). `$fillable` dan `casts()` lama tidak diubah |
| `resources/views/enrollments/create.blade.php` | Ditulis ulang | Dulu: field teks bebas `name` + `email` + dropdown course (value = `code`). Sekarang: dropdown `participant_id` (ambil dari tabel `participants`) + dropdown `course_id` (value = `id`, hanya course berstatus `open`). Widget "cek sisa kursi" (jQuery Ajax di `resources/js/app.js`) **tidak diubah sama sekali** — otomatis tetap jalan karena hanya mengikuti `this.value` dari `<select id="course_id">` |
| `resources/views/partials/navbar.blade.php` | Diperbarui | Ditambah link "Laporan Enrollment" ke `enrollments.index` |

## File baru di Pertemuan 12

| File Laravel | Asal | Keterangan |
|---|---|---|
| `database/migrations/..._create_participants_table.php` | Panduan Pertemuan 12 | Master data peserta: `name`, `email` (unique), `phone` (nullable) |
| `database/migrations/..._create_enrollments_table.php` | Panduan Pertemuan 12 | Tabel penghubung; `participant_id` & `course_id` keduanya `foreignId()->constrained()->cascadeOnDelete()`, plus `unique(['participant_id','course_id'])` agar satu participant tidak bisa daftar dua kali ke course yang sama |
| `app/Models/Participant.php` | — | `enrollments()` (hasMany) dan `courses()` (belongsToMany convenience) |
| `app/Models/Enrollment.php` | — | `participant()` dan `course()` (keduanya belongsTo) |
| `app/Http/Controllers/EnrollmentController.php` | `CourseController` (P10) sebagai pola dasar | `create()` mengambil participant + course berstatus `open`; `store()` validasi `exists` + `Rule::unique('enrollments')->where(...)` berpasangan; `index()` laporan dengan eager load `with(['participant','course'])` |
| `resources/views/enrollments/index.blade.php` | `courses/index.blade.php` (P11) sebagai pola tabel | Laporan relasional: nama participant, email, course, tanggal mulai, status |
| `database/seeders/ParticipantSeeder.php` | `CourseSeeder` (P10) sebagai pola | 3 data dummy (Alya, Bima, Citra), opsional, dipakai `firstOrCreate` agar aman dijalankan ulang |

## Penyesuaian dari panduan generik ke project nyata

Panduan Pertemuan 12 memakai contoh `Course::where('status', 'active')`.
Project KursusKu **tidak punya** status `active` — enum `courses.status`
sejak Pertemuan 10 adalah `draft`, `open`, `closed` (lihat migration
`create_courses_table`). Semua kode di pertemuan ini memakai `'open'`
sebagai padanan "course yang bisa didaftarkan", termasuk pada
`EnrollmentController::create()` dan skrip cascade test di evidence.

## Kenapa field `remaining` pada `courses.availability` masih kuota penuh?

Masih sama seperti catatan Pertemuan 10: `remaining` belum dihitung dari
`quota - jumlah_enrollment_terdaftar`. Sekarang relasi `Course::enrollments()`
sudah ada, jadi penghitungan riil (`$course->quota - $course->enrollments()->count()`)
bisa dikerjakan di pertemuan berikutnya tanpa migration tambahan.

## Yang BELUM dimigrasikan
- Halaman `edit`/`update`/`delete` untuk Enrollment belum dibuka
  (`Route::resource(...)->only(['index','create','store'])`), sesuai
  scope panduan Pertemuan 12.
- Tidak ada form untuk menambah Participant baru lewat browser —
  data participant saat ini hanya dari `php artisan tinker` atau
  `ParticipantSeeder`.
- `remaining` pada `courses.availability` dan landing page masih kuota
  penuh, belum dikurangi jumlah enrollment aktif.

## Konsep baru yang dipelajari
- Migration dengan dua foreign key + `cascadeOnDelete()` dan
  composite `unique()` pada kombinasi dua kolom
- Relasi Eloquent `hasMany`/`belongsTo` dua arah, dan `belongsToMany`
  konseptual lewat tabel pivot yang punya model sendiri (`Enrollment`),
  bukan tabel pivot polos
- `Rule::unique('table')->where(fn ($q) => ...)` untuk validasi unique
  bersyarat pada kombinasi field (bukan `Rule::unique()->ignore()`
  seperti update biasa)
- Eager loading `with([...])` untuk menghindari N+1 query pada laporan
  relasional
- Efek `cascadeOnDelete()` diuji langsung lewat Tinker, bukan diasumsikan

---

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
