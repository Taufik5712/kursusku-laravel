# Cascade Delete Test — Pertemuan 12

Jalankan di `php artisan tinker`, pada project **lokal** dengan database
dummy. Jangan pernah menjalankan ini di database yang berisi data
penting. Status course dummy memakai `'open'` (bukan `'active'` seperti
contoh generik di panduan) karena enum `courses.status` pada project ini
adalah `draft`, `open`, `closed`.

## Test A — Hapus Course dummy

```php
use App\Models\Course;
use App\Models\Participant;
use App\Models\Enrollment;

$course = Course::create([
    'code'       => 'TEST-CASCADE-COURSE',
    'name'       => 'Course Cascade Test',
    'fee'        => 10000,
    'quota'      => 5,
    'start_date' => now()->addWeek()->toDateString(),
    'status'     => 'open',
]);

$participant = Participant::create([
    'name'  => 'Dummy Cascade Course',
    'email' => 'cascade.course@example.test',
]);

Enrollment::create([
    'participant_id' => $participant->id,
    'course_id'      => $course->id,
    'status'         => 'registered',
]);

// Catat jumlah enrollment sebelum delete
Enrollment::where('course_id', $course->id)->count();
// -> harus 1

$course->delete();
// -> true

Enrollment::where('course_id', $course->id)->count();
// -> harus 0 (ikut terhapus karena cascadeOnDelete)

Participant::find($participant->id) !== null;
// -> harus true (Participant TIDAK ikut terhapus)
```

**Expected:** menghapus Course menghapus enrollment yang menunjuk ke
Course itu, tetapi Participant yang bersangkutan tetap ada.

## Test B — Hapus Participant dummy

```php
$course2 = Course::create([
    'code'       => 'TEST-CASCADE-PART',
    'name'       => 'Participant Cascade Test',
    'fee'        => 10000,
    'quota'      => 5,
    'start_date' => now()->addDays(10)->toDateString(),
    'status'     => 'open',
]);

$participant2 = Participant::create([
    'name'  => 'Dummy Participant Delete',
    'email' => 'cascade.participant@example.test',
]);

Enrollment::create([
    'participant_id' => $participant2->id,
    'course_id'      => $course2->id,
    'status'         => 'registered',
]);

Enrollment::where('participant_id', $participant2->id)->count();
// -> harus 1

$participant2->delete();
// -> true

Enrollment::where('participant_id', $participant2->id)->count();
// -> harus 0

Course::find($course2->id) !== null;
// -> harus true (Course TIDAK ikut terhapus)
```

**Expected:** menghapus Participant menghapus enrollment-nya, tetapi
Course yang bersangkutan tetap ada.

## Bersihkan dummy tersisa setelah pengujian

```php
$course2->delete();
$participant->delete();
```

## Catatan hasil (isi setelah dijalankan)

| Test | Hasil yang diharapkan | Actual | Status | Bukti |
|---|---|---|---|---|
| A — Delete Course | Enrollment ikut hilang; Participant tetap ada | (isi) | Pass / Fail | (screenshot tinker) |
| B — Delete Participant | Enrollment ikut hilang; Course tetap ada | (isi) | Pass / Fail | (screenshot tinker) |

## Kesimpulan desain (isi dengan bahasa sendiri)

Mengapa `cascadeOnDelete()` dipasang pada foreign key di tabel
`enrollments`, bukan antara `courses` dan `participants` secara
langsung? ................................
