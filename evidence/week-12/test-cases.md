# Pengujian Cascade Delete - Pertemuan 12

## 1. Cascade Test A: Menghapus Course Dummy
Tujuan: Memastikan enrollment otomatis terhapus ketika course dihapus, sedangkan participant tetap tersimpan.

### Kondisi sebelum penghapusan
| Data | ID | Keterangan |
| :--- | :--- | :--- |
| Course | 14 | `TEST-CASCADE-COURSE` |
| Participant | 7 | `cascade.course@example.test` |
| Enrollment | 4 | `participant_id = 7, course_id = 14` |

Jumlah enrollment yang terhubung: **1 record**.

### Aksi pengujian
```php
App\Models\Course::find(14)->delete();
```

### Hasil setelah penghapusan
| Pemeriksaan | Hasil |
| :--- | :--- |
| Course ID 14 | Terhapus |
| Enrollment ID 4 | Terhapus otomatis (`cascadeOnDelete`) |
| Participant ID 7 | Tetap ada |

### Output hasil pengujian
```json
{
    "test": "Cascade Test A: Menghapus Course Dummy",
    "course_id": 14,
    "participant_id": 7,
    "enrollment_id": 4,
    "initial_enrollment_count": 1,
    "course_deleted": true,
    "enrollment_deleted": true,
    "participant_retained_after_course_deletion": true,
    "pass": true
}
```

---

## 2. Cascade Test B: Menghapus Participant Dummy
Tujuan: Memastikan enrollment otomatis terhapus ketika participant dihapus, sedangkan course tetap tersimpan.

### Kondisi sebelum penghapusan
| Data | ID | Keterangan |
| :--- | :--- | :--- |
| Course | 15 | `TEST-CASCADE-PART` |
| Participant | 8 | `cascade.participant@example.test` |
| Enrollment | 5 | `participant_id = 8, course_id = 15` |

Jumlah enrollment yang terhubung: **1 record**.

### Aksi pengujian
```php
App\Models\Participant::find(8)->delete();
```

### Hasil setelah penghapusan
| Pemeriksaan | Hasil |
| :--- | :--- |
| Participant ID 8 | Terhapus |
| Enrollment ID 5 | Terhapus otomatis (`cascadeOnDelete`) |
| Course ID 15 | Tetap ada |

### Output hasil pengujian
```json
{
    "test": "Cascade Test B: Menghapus Participant Dummy",
    "course_id": 15,
    "participant_id": 8,
    "enrollment_id": 5,
    "initial_enrollment_count": 1,
    "participant_deleted": true,
    "enrollment_deleted": true,
    "course_retained_after_participant_deletion": true,
    "pass": true
}
```