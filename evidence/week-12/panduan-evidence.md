# Panduan Evidence — Pertemuan 12 (Relational Core v1)

Dokumen ini merangkum bukti apa saja yang perlu dikumpulkan untuk
Pertemuan 12, dan ke mana menyimpannya. Source code-nya sendiri sudah
jadi (lihat ringkasan di bagian akhir) — dokumen ini fokus ke langkah
menjalankan & mendokumentasikan di komputer lokal (Laragon + MySQL),
karena itu tidak bisa dikerjakan dari sini.

## Struktur folder evidence yang disarankan

```
evidence/week-12/
├── 01-route-list.png              (screenshot: php artisan route:list)
├── 02-migrate-success.png         (screenshot: php artisan migrate)
├── 03-foreign-key-db.png          (screenshot structure/FK di phpMyAdmin/HeidiSQL)
├── 04-form-enrollment.png         (screenshot /enrollments/create terisi)
├── 05-duplicate-error.png         (screenshot pesan "sudah terdaftar")
├── 06-laporan-enrollment.png      (screenshot /enrollments)
├── 07-cascade-course-tinker.png   (screenshot hasil Test A di tinker)
├── 08-cascade-participant-tinker.png (screenshot hasil Test B di tinker)
├── erd-final.md                   (sudah dibuat — render Mermaid-nya, screenshot)
├── test-cases.md                  (sudah dibuat — isi kolom Actual/Status)
├── cascade-test-script.md         (sudah dibuat — isi kolom Actual/Status)
└── ai-log.txt                     (opsional, isi jika memakai AI)
```

## Urutan pengerjaan di komputer lokal (Laragon)

1. **Tarik perubahan project ini** ke folder `kursusku` di Laragon
   (`C:\laragon\www\kursusku`), lalu pastikan `.env` masih
   `DB_CONNECTION=mysql` dengan `DB_DATABASE=kursusku` (lihat
   `CATATAN-MIGRASI.md` bagian "Perbaikan: SQLite → MySQL").
2. Jalankan pemeriksaan awal:
   ```
   php artisan --version
   php artisan migrate:status
   php artisan route:list --name=courses
   ```
   → ambil **01-route-list.png** dari `php artisan route:list` (pastikan
   terlihat route `enrollments.index`, `enrollments.create`,
   `enrollments.store`, dan `courses.*`).
3. Jalankan migration baru:
   ```
   php artisan migrate
   ```
   → **02-migrate-success.png**: pastikan
   `2026_11_15_000001_create_participants_table` dan
   `2026_11_15_000002_create_enrollments_table` berstatus `DONE`/`Ran`.
4. Buka phpMyAdmin/HeidiSQL → tabel `enrollments` → tab
   Structure/Relations → **03-foreign-key-db.png**: pastikan
   `participant_id -> participants.id`, `course_id -> courses.id`,
   action `DELETE` = `CASCADE`. Bisa juga dikonfirmasi lewat:
   ```sql
   SHOW CREATE TABLE enrollments;
   ```
5. Isi data dummy participant:
   ```
   php artisan db:seed --class=ParticipantSeeder
   ```
   atau manual lewat `php artisan tinker` (lihat Langkah 5 panduan asli).
   Pastikan minimal 1 course berstatus `open` sudah ada (project ini
   sudah punya `LRV-101 Laravel Dasar` dan `PHP-101 PHP Fundamental`
   lewat `CourseSeeder`).
6. Jalankan `evidence/week-12/test-cases.md` kasus 1–8 satu per satu →
   **04-form-enrollment.png**, **05-duplicate-error.png**,
   **06-laporan-enrollment.png**. Isi kolom Actual/Status/Bukti di file
   tersebut.
7. Jalankan `evidence/week-12/cascade-test-script.md` Test A dan Test B
   di `php artisan tinker` → **07-cascade-course-tinker.png**,
   **08-cascade-participant-tinker.png**. Isi kolom Actual/Status di
   file tersebut, lalu jawab pertanyaan kesimpulan desain di akhir file.
8. Render `evidence/week-12/erd-final.md` (VS Code Markdown Preview +
   ekstensi Mermaid, atau tempel blok ```mermaid``` ke
   https://mermaid.live) dan simpan sebagai gambar jika diminta dosen.
9. Commit:
   ```
   git add .
   git commit -m "feat: add participant course enrollment relations"
   ```

## Checklist akhir (salin dari panduan §Checklist, dicentang manual)

**Database**
- [ ] ERD final benar (`erd-final.md`)
- [ ] `participants` berhasil dibuat
- [ ] `enrollments` berhasil dibuat
- [ ] Dua foreign key aktif (`03-foreign-key-db.png`)
- [ ] Composite unique aktif (coba daftar ganda → kasus 5 di `test-cases.md`)

**Eloquent**
- [ ] `Participant::enrollments()` — sudah ada di `app/Models/Participant.php`
- [ ] `Enrollment::participant()` — sudah ada di `app/Models/Enrollment.php`
- [ ] `Enrollment::course()` — sudah ada di `app/Models/Enrollment.php`
- [ ] `Course::enrollments()` — sudah ada di `app/Models/Course.php`

**Fitur**
- [ ] Form dua dropdown bekerja (`/enrollments/create`)
- [ ] Enrollment tersimpan (kasus 4 di `test-cases.md`)
- [ ] Duplicate ditolak (kasus 5)
- [ ] Laporan relasional tampil (`/enrollments`, kasus 8)

**Testing**
- [ ] 8 test matrix end-to-end dijalankan (`test-cases.md`)
- [ ] Delete course dummy diuji (`cascade-test-script.md` Test A)
- [ ] Delete participant dummy diuji (`cascade-test-script.md` Test B)
- [ ] Efek cascade dapat dijelaskan dengan bahasa sendiri

## Ringkasan source code yang sudah jadi (tidak perlu ditulis ulang)

| File | Isi |
|---|---|
| `database/migrations/2026_11_15_000001_create_participants_table.php` | Tabel `participants` |
| `database/migrations/2026_11_15_000002_create_enrollments_table.php` | Tabel `enrollments` + 2 FK cascade + composite unique |
| `app/Models/Participant.php` | Relasi `enrollments()`, `courses()` |
| `app/Models/Enrollment.php` | Relasi `participant()`, `course()` |
| `app/Models/Course.php` | Ditambah relasi `enrollments()`, `participants()` |
| `app/Http/Controllers/EnrollmentController.php` | `create()`, `store()` (validasi + anti-duplikasi), `index()` (laporan) |
| `routes/web.php` | `Route::resource('enrollments', ...)->only(['index','create','store'])` |
| `resources/views/enrollments/create.blade.php` | Form 2 dropdown + cek sisa kursi |
| `resources/views/enrollments/index.blade.php` | Tabel laporan relasional |
| `database/seeders/ParticipantSeeder.php` | 3 participant dummy |
| `CATATAN-MIGRASI.md` | Dokumentasi lengkap perubahan Pertemuan 11 → 12 |

Detail penjelasan setiap keputusan desain (kenapa `'open'` bukan
`'active'`, kenapa binding availability diganti, dll.) ada di
`CATATAN-MIGRASI.md` bagian "Catatan Migrasi: Pertemuan 11 → Pertemuan 12".
