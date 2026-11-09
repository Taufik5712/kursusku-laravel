# Test Matrix — Pertemuan 11 (Show, Validation, Edit, Update & Delete)

Disusun mengikuti Test Matrix Bagian A & B pada Panduan Praktikum
Pertemuan 11 (15 skenario, minimal 12 yang wajib dikumpulkan).
Kolom **Expected** diambil dari panduan; isi **Actual**, **Status**, dan
**Bukti** setelah masing-masing skenario benar-benar dijalankan di
`kursusku.test`.

| No | Kasus | Input / Tindakan | Expected (sesuai panduan) | Actual | Status | Bukti |
|---|---|---|---|---|---|---|
| 1 | Duplicate code saat create | `code` memakai kode Course yang sudah ada | Ditolak; error dekat field `code` | (isi) | Pass / Fail | (screenshot) |
| 2 | Nama kosong | `name = ""` | Ditolak; `name` required | (isi) | Pass / Fail | (screenshot) |
| 3 | Nama terlalu pendek | `name = "AI"` | Ditolak; minimal 3 karakter | (isi) | Pass / Fail | (screenshot) |
| 4 | Fee negatif | `fee = -1000` | Ditolak; minimal 0 | (isi) | Pass / Fail | (screenshot) |
| 5 | Fee bukan integer | `fee = abc` | Ditolak; harus integer | (isi) | Pass / Fail | (screenshot) |
| 6 | Quota nol | `quota = 0` | Ditolak | (isi) | Pass / Fail | (screenshot) |
| 7 | Quota 501 | `quota = 501` | Ditolak | (isi) | Pass / Fail | (screenshot) |
| 8 | Boundary quota minimum | `quota = 1` | Diterima | (isi) | Pass / Fail | (screenshot) |
| 9 | Boundary quota maksimum | `quota = 500` | Diterima | (isi) | Pass / Fail | (screenshot) |
| 10 | Tanggal invalid | Kirim nilai yang bukan tanggal valid (manipulasi input/DevTools) | Ditolak oleh rule `date` | (isi) | Pass / Fail | (screenshot) |
| 11 | Status invalid | `status = active` (manipulasi DevTools, karena `<select>` tidak menyediakan nilai ini) | Ditolak; hanya `draft`/`open`/`closed` | (isi) | Pass / Fail | (screenshot) |
| 12 | Update dengan code sendiri | Edit Course tanpa mengubah `code` | Harus berhasil (unique mengabaikan record sendiri) | (isi) | Pass / Fail | (screenshot) |
| 13 | Update ke code Course lain | Ganti `code` menjadi `code` milik Course lain | Ditolak `unique` | (isi) | Pass / Fail | (screenshot) |
| 14 | Update normal | Ubah nama, fee, quota, atau status dengan nilai valid | Berhasil; halaman detail menampilkan data baru | (isi) | Pass / Fail | (screenshot) |
| 15 | Delete | Hapus Course dummy (mis. `DEL-001`), konfirmasi `OK` | Data hilang dari index + flash sukses | (isi) | Pass / Fail | (screenshot) |

**Minimal wajib (9 kasus paling penting menurut panduan):**
No. 1, 4, 6, 7, 10, 11, 12, 13, dan 15 — tapi kumpulkan setidaknya
**12 dari 15** baris di atas.

## Urutan pengujian yang aman (sesuai panduan §18)
1. Mulai dari satu data valid sebagai data utama.
2. Uji halaman detail (`/courses/{id}`) — cocokkan semua field dengan database.
3. Uji edit tanpa mengubah `code` (kasus 12) — pastikan tidak tertolak unique.
4. Uji error satu per satu (kasus 1–7, 10–11) — jangan gabungkan beberapa input salah sekaligus.
5. Uji boundary quota berurutan: `0 → 1 → 500 → 501` (kasus 6, 8, 9, 7).
6. Uji status invalid lewat DevTools/manual request (kasus 11).
7. Uji delete paling akhir, pakai Course dummy, bukan data kerja utama (kasus 15).

*(Centang Pass/Fail setelah dijalankan sendiri. Jika Fail, catat juga
perbaikan yang dilakukan sebelum dikumpulkan bersama
`StoreCourseRequest.php`, `UpdateCourseRequest.php`,
`CourseController.php`, `show.blade.php`, `edit.blade.php`, dan
screenshot evidence sesuai checklist akhir panduan §22.)*
