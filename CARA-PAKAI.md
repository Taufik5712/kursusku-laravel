# Paket Siap Pakai — Pertemuan 12 (Enrollment & Participant)

Paket ini berisi file siap tempel untuk melengkapi project `kursusku-laravel` Anda sesuai Panduan Praktikum Pertemuan 12.

## Isi Paket
1. `database/sql/04-seed-participants-enrollments.sql` — File SQL siap import di phpMyAdmin untuk mengisi tabel `participants` (3 peserta dummy) dan `enrollments` (3 contoh pendaftaran).
2. `database/seeders/EnrollmentSeeder.php` — Seeder Laravel untuk tabel `enrollments`.
3. `database/seeders/DatabaseSeeder.php` — Seeder utama yang menjalankan `CourseSeeder`, `ParticipantSeeder`, dan `EnrollmentSeeder` sekaligus.

## Catatan Penting pada Project Anda
Di folder `database/migrations/` project Anda terdapat dua file migration `create_enrollments_table`:
- `2026_11_15_000002_create_enrollments_table.php` (benar — berisi foreign key & composite unique)
- `2026_11_15_165759_create_enrollments_table.php` (file kosong duplikat)

**Hapus** file `database/migrations/2026_11_15_165759_create_enrollments_table.php` agar `php artisan migrate` / `php artisan migrate:fresh` tidak bentrok dengan pesan *Table 'enrollments' already exists*.

## Cara Menggunakan (Pilih Salah Satu)

### Cara A — Via Artisan Seeder (Direkomendasikan)
1. Salin isi folder paket ini ke folder project `kursusku-laravel` Anda.
2. Hapus `database/migrations/2026_11_15_165759_create_enrollments_table.php` jika masih ada.
3. Jalankan perintah berikut di terminal VS Code:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```
4. Buka `http://127.0.0.1:8000/enrollments` untuk melihat laporan relasional dan `http://127.0.0.1:8000/enrollments/create` untuk menguji form pendaftaran serta validasi duplikat.

### Cara B — Langsung Import SQL di phpMyAdmin
1. Pastikan tabel `courses`, `participants`, dan `enrollments` sudah ada di database `kursusku`.
2. Buka **phpMyAdmin** -> pilih database `kursusku` -> tab **Import**.
3. Pilih file `04-seed-participants-enrollments.sql` lalu klik **Import / Go**.
