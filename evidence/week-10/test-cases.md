# 8 Test Case Manual — Pertemuan 10

| No | Skenario | Input utama | Hasil yang diharapkan | Hasil aktual | Status |
|---|---|---|---|---|---|
| 1 | Simpan data valid | Semua field valid | Data tersimpan, redirect ke index, pesan sukses | (isi) | [ ] Lulus |
| 2 | Kode kosong | `code` kosong | Validasi gagal, data tidak tersimpan | (isi) | [ ] Lulus |
| 3 | Kode duplikat | `WEB-101` kedua kali | Ditolak oleh rule `unique` | (isi) | [ ] Lulus |
| 4 | Nama kosong | `name` kosong | Validasi gagal | (isi) | [ ] Lulus |
| 5 | Biaya negatif | `fee = -1000` | Ditolak karena `min:0` | (isi) | [ ] Lulus |
| 6 | Kuota 0 | `quota = 0` | Ditolak karena `min:1` | (isi) | [ ] Lulus |
| 7 | Status tidak valid | ubah manual jadi `active` | Ditolak karena hanya `draft`/`open`/`closed` | (isi) | [ ] Lulus |
| 8 | Daftar tampil ulang | Reload `/courses` | Data tetap ada karena berasal dari MySQL | (isi) | [ ] Lulus |

*(Jalankan setiap skenario di komputer Anda sendiri, catat hasil aktual,
dan centang status Lulus/Gagal sebelum dikumpulkan. Jika gagal, catat
juga perbaikan yang dilakukan.)*
