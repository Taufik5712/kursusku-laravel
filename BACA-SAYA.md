# KursusKu — Pertemuan 11 (file siap tempel)

CRUD Course tahap 1 (index, create, store) sudah ada. Paket ini **hanya** menambahkan show, Form Request, edit/update, dan delete. Migration dan schema **tidak diubah**.

Salin berkas berikut ke proyek Laragon `C:\laragon\www\kursusku` (timpa file lama yang namanya sama):

| File | Peran |
|---|---|
| `app/Http/Controllers/CourseController.php` | index, create, store, show, edit, update, destroy |
| `app/Http/Requests/StoreCourseRequest.php` | validasi tambah; `authorize()` = true; code unik |
| `app/Http/Requests/UpdateCourseRequest.php` | validasi edit; `Rule::unique()->ignore($course)` |
| `resources/views/courses/index.blade.php` | tombol Detail, Edit, Hapus |
| `resources/views/courses/create.blade.php` | error di samping field + `old()` |
| `resources/views/courses/show.blade.php` | halaman detail (baru) |
| `resources/views/courses/edit.blade.php` | form edit (baru), `old()` + `@method('PUT')` |
| `routes/web.php` | komentar resource diperbarui; route tidak ditambah |

## Urutan cek di Laragon

1. Start All (MySQL hidup).
2. `php artisan route:list --name=courses` — harus ada index, create, store, show, edit, update, destroy.
3. Buka `/courses`. Klik **Detail** pada salah satu baris.
4. Klik **Edit**, ubah nama saja (code tidak diubah), simpan. Harus masuk halaman detail + pesan sukses.
5. Coba code yang sudah dipakai kursus lain — ditolak, pesan muncul di bawah field code.
6. Hapus hanya kursus dummy. Form hapus memakai `@csrf` + `@method('DELETE')` + `confirm()`.

## Yang harus bisa dijelaskan

- **Route model binding** — Laravel mengisi `Course $course` dari id di URL. Id yang tidak ada menghasilkan 404.
- **Form Request** — satpam validasi sebelum controller. `validated()` hanya mengembalikan field yang lolos rules.
- **`ignore($course)`** — saat update, code milik record yang sedang diedit tidak dianggap duplikat.
- **`@method('PUT')` / `@method('DELETE')`** — browser hanya bisa GET/POST; method spoofing mengarahkan form ke route update/destroy.
- **`old('field', $course->field)`** — kalau validasi gagal, ketikan terakhir user tidak hilang.

## Refleksi singkat (jawaban)

1. Validasi dipindah ke Form Request supaya controller tetap jadi koordinator, dan aturan store vs update bisa berbeda tanpa dicampur di satu method.
2. Saat store, code harus unik terhadap semua baris. Saat update, code yang sama dengan record sendiri harus tetap boleh disimpan.
3. `@method('PUT')` mengirim update ke route PUT. `@method('DELETE')` mengirim hapus ke route DELETE. Keduanya tetap butuh `@csrf`.
