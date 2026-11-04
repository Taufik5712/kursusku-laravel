# KursusKu (Laravel) — Pertemuan 10

Lanjutan dari project Pertemuan 9. Menambahkan database MySQL, migration,
model `Course`, dan fitur Create + Read (tambah kursus & lihat daftar
kursus) berbasis Eloquent.

**Paket ini bukan project baru** — file di dalamnya dirancang untuk
ditambahkan/menimpa project `kursusku` dari Pertemuan 9 yang sudah
berjalan. Lihat `PANDUAN-TERMINAL.md` untuk langkah lengkap, urut dari
membuat database sampai 8 data tersimpan.

## Fitur yang ditambahkan
- `database/migrations/..._create_courses_table.php` — schema tabel `courses`
  (code, name, description, fee, quota, start_date, status, timestamps)
- `app/Models/Course.php` — `$fillable` + cast `start_date` ke `date`
- `app/Http/Controllers/CourseController.php` — `index()`, `create()`, `store()`
- `routes/web.php` — **diperbarui**: `Route::resource('courses', ...)`,
  dan endpoint `courses.availability` sekarang membaca `Course` dari
  database (menggantikan array dummy Pertemuan 9)
- `resources/views/courses/index.blade.php` — tabel daftar kursus dari MySQL
- `resources/views/courses/create.blade.php` — form tambah kursus (`@csrf`,
  validasi, `@error`, `old()`)
- `resources/views/partials/navbar.blade.php` — **diperbarui**, tambah
  link "Daftar Kursus"
- `resources/css/app.css` — **diperbarui**, tambah gaya tabel gelap
- `database/seeders/CourseSeeder.php` — opsional, 8 data contoh

## Belum Dikerjakan
- Update dan Delete (show/edit/update/destroy pada resource route)
- Relasi Enrollment/Participant (sisa kursi belum dihitung dari pendaftar
  asli — endpoint availability masih menampilkan kuota penuh)
- Pagination dan searching
- Migrasi form pendaftaran (`/pendaftaran`) ke data Course dari database

Fase berikutnya: Update/Delete, lalu relasi Enrollment.
