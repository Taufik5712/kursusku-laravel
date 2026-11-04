# Panduan Terminal — Pertemuan 10 (versi perbaikan)

## Kenapa ada "versi perbaikan"?

Kode Anda (migration, Model `Course`, `CourseController`, view
`courses/index` & `courses/create`, resource route) **sudah lengkap dan
sudah sesuai Panduan Praktikum Pertemuan 10** — tidak perlu ditulis ulang.

Yang keliru hanya satu: project ini berjalan memakai **SQLite**
(`DB_CONNECTION=sqlite`, file `database/database.sqlite`), padahal
panduan secara eksplisit meminta **MySQL lewat Laragon** dengan nama
database persis `kursusku` (Bagian 4 & 5 panduan). Paket ini sudah
memperbaiki `.env` menjadi MySQL dan menambahkan folder `database/sql/`
untuk membantu Anda pindah database dengan cepat.

Ikuti langkah di bawah secara urut. Jangan lanjut ke langkah berikutnya
jika langkah sebelumnya masih error.

## Langkah 1 — Nyalakan Laragon dan MySQL

1. Buka Laragon, klik **Start All**.
2. Pastikan Apache/Nginx dan MySQL aktif (ikon hijau).

## Langkah 2 — Buat database `kursusku` di MySQL

Pilih salah satu cara:

**Cara A — lewat phpMyAdmin (disarankan untuk pemula)**
1. Buka phpMyAdmin dari menu Laragon.
2. Klik **New**, buat database dengan nama persis `kursusku`.
3. Pilih collation `utf8mb4_unicode_ci` bila diminta.

**Cara B — lewat SQL**
Buka tab **SQL** di phpMyAdmin (atau terminal `mysql -u root -p`), lalu
jalankan isi file:
```
database/sql/01-create-database.sql
```

**Checkpoint:** database `kursusku` muncul di panel kiri phpMyAdmin,
masih kosong (belum ada tabel). Screenshot → `evidence/week-10/01-database.png`.

## Langkah 3 — Cek `.env` sudah benar

File `.env` pada paket ini **sudah diperbaiki**. Pastikan isinya seperti
ini (sesuaikan `DB_USERNAME`/`DB_PASSWORD` jika instalasi MySQL Anda
berbeda dari default Laragon):

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kursusku
DB_USERNAME=root
DB_PASSWORD=
```

Bersihkan cache konfigurasi lama agar Laravel membaca `.env` yang baru:
```
cd C:\laragon\www\kursusku
php artisan config:clear
```

## Langkah 4 — Jalankan migration ke database MySQL yang baru

```
php artisan migrate
```

Perintah ini membuat **semua** tabel (termasuk `users`, `sessions`, dan
`courses`) di database `kursusku` yang masih kosong. Karena database
baru dan kosong, `migrate` aman dijalankan langsung (bukan `migrate:fresh`
pada database lama yang sudah berisi data).

**Checkpoint:**
```
php artisan migrate:status
```
Semua migration berstatus **Ran**, termasuk `..._create_courses_table`.

Buka phpMyAdmin → database `kursusku` → pastikan tabel `courses` ada
dengan kolom: `id, code, name, description, fee, quota, start_date,
status, created_at, updated_at`.
Screenshot → `evidence/week-10/02-courses-structure.png`.

## Langkah 5 — Tes lewat Tinker

```
php artisan tinker
>>> App\Models\Course::count();
=> 0
>>> exit
```

`0` berarti model `Course` sudah berhasil membaca tabel `courses` yang
baru (masih kosong).

## Langkah 6 — Jalankan Vite dan server

Terminal 1:
```
npm run dev
```

Terminal 2:
```
php artisan serve
```
atau reload Laragon → buka `http://kursusku.test`.

## Langkah 7 — Uji Create + Read pertama lewat form

1. Buka `/courses` — tabel kosong tampil tanpa error.
2. Klik **+ Tambah Kursus** → buka `/courses/create`.
   Screenshot → `evidence/week-10/03-create-form.png`.
3. Isi data uji:

   | Field | Nilai |
   |---|---|
   | code | WEB-101 |
   | name | Web Dasar |
   | description | HTML, CSS, dan dasar web. |
   | fee | 300000 |
   | quota | 25 |
   | start_date | tanggal setelah hari praktikum |
   | status | open |

4. Klik **Simpan Kursus** → browser pindah ke `/courses`, pesan sukses
   muncul, `WEB-101` tampil di tabel.
5. Cek tabel `courses` di phpMyAdmin — pastikan datanya benar tersimpan
   di MySQL (bukan lagi di SQLite).

## Langkah 8 — Isi sisa data sampai minimal 8

Pilih salah satu:

**Opsi A — manual lewat form** (disarankan, sesuai panduan):
isi 7 data sisanya satu per satu lewat `/courses/create` memakai tabel
8 data pada `database/sql/03-seed-8-courses.sql` sebagai acuan nilai.

**Opsi B — cepat lewat seeder Laravel:**
```
php artisan db:seed --class=CourseSeeder
```

**Opsi C — paling cepat lewat SQL langsung** (jika `WEB-101` sudah
dimasukkan lewat form di Langkah 7, hapus baris `WEB-101` dari file
dulu agar tidak bentrok dengan rule `unique`):
jalankan isi `database/sql/03-seed-8-courses.sql` lewat tab SQL
phpMyAdmin.

Setelah 8 data masuk, screenshot daftar kursus →
`evidence/week-10/04-index-8-data.png`.

## Langkah 9 — Jalankan 8 test case manual

Isi `evidence/week-10/test-cases.md` (template sudah ada, masih kosong
"(isi)") dengan hasil aktual dari 8 skenario:

1. Simpan data valid → tersimpan, redirect, pesan sukses
2. Kode kosong → validasi gagal
3. Kode duplikat (`WEB-101` lagi) → ditolak rule `unique`
4. Nama kosong → validasi gagal
5. Biaya negatif (`fee = -1000`) → ditolak `min:0`
6. Kuota 0 → ditolak `min:1`
7. Status tidak valid (ubah manual jadi `active`) → ditolak `in:draft,open,closed`
8. Reload `/courses` → data tetap ada (berasal dari MySQL)

Screenshot pesan validasi untuk salah satu test invalid →
`evidence/week-10/05-validation-error.png`.

## Langkah 10 — (Opsional) buang sisa SQLite lama

Project ini tidak lagi memakai SQLite, jadi boleh dibersihkan:
- `.env` pada paket ini sudah tidak memakai `DB_CONNECTION=sqlite`.
- File `database/database.sqlite` sudah tidak disertakan di paket ini.
  Jika masih ada salinan lama di komputer Anda, boleh dihapus setelah
  memastikan data pentingnya sudah dipindahkan ke MySQL.

## Langkah 11 — Git

```
git add .
git commit -m "fix: switch database connection from sqlite to mysql (kursusku)"
git log --oneline -5
```

## Langkah 12 — Lengkapi evidence

Simpan/ganti nama ke `evidence/week-10/`:
- `01-database.png`, `02-courses-structure.png`, `03-create-form.png`,
  `04-index-8-data.png`, `05-validation-error.png`
- `test-cases.md` — isi semua baris "(isi)" dengan hasil aktual
- `ai-log.md` — isi jika memakai AI (sudah ada template)

> Catatan: folder `evidence/week-10/` pada paket ini masih berisi 4
> screenshot lama ("Cuplikan layar ...") dari sesi SQLite — boleh dipakai
> sebagai referensi tampilan, tapi screenshot final yang dikumpulkan
> sebaiknya diambil ulang setelah database MySQL berjalan agar konsisten
> dengan isi `.env` yang dikumpulkan.
