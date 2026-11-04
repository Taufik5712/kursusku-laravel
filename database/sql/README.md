# database/sql/

Tiga file bantu untuk Bagian A dan K panduan Pertemuan 10. Pilih salah satu
jalur di bawah — **Jalur A direkomendasikan** karena itulah yang diminta
panduan (belajar migration, bukan menulis SQL manual).

## Jalur A — Direkomendasikan (sesuai panduan)
1. Buat database kosong `kursusku` (lihat `01-create-database.sql`, atau
   buat lewat phpMyAdmin seperti dijelaskan di `PANDUAN-TERMINAL.md`).
2. `php artisan migrate` — tabel `courses` dibuat otomatis dari
   `database/migrations/2026_10_29_000000_create_courses_table.php`.
3. Tambah minimal satu data lewat form `/courses/create`.
4. Isi sisanya lewat form juga, **atau** jalankan
   `php artisan db:seed --class=CourseSeeder` untuk mempercepat.

File `02-reference-courses-table.sql` **bukan** untuk dijalankan di jalur
ini — ia hanya referensi untuk mencocokkan struktur tabel yang dihasilkan
migration.

## Jalur B — Cepat lewat phpMyAdmin (tanpa artisan)
Jika Anda ingin langsung punya database berisi data tanpa menjalankan
`php artisan migrate`/`db:seed` (misalnya untuk demo cepat), import ketiga
file ini berurutan lewat tab **Import** di phpMyAdmin:
1. `01-create-database.sql` — membuat database `kursusku`
2. `02-reference-courses-table.sql` — membuat tabel `courses`
3. `03-seed-8-courses.sql` — mengisi 8 data kursus

> Catatan: jalur B tetap TIDAK menggantikan kewajiban mencoba form
> `/courses/create` minimal satu kali — itu bagian dari capaian
> praktikum (memahami alur Route → Controller → Model → MySQL).
