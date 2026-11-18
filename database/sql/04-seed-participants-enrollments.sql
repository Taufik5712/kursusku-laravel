-- Pertemuan 12 — File SQL Siap Import untuk Tabel `participants` dan `enrollments`
-- Database: kursusku (MySQL / MariaDB di Laragon)
-- Cara pakai:
--   1. Buka phpMyAdmin -> pilih database `kursusku`.
--   2. Pastikan tabel `courses`, `participants`, dan `enrollments` sudah ada
--      (jalankan `php artisan migrate` terlebih dahulu di terminal VS Code).
--   3. Klik tab "Import", pilih file ini, lalu klik "Go" / "Import".

USE `kursusku`;

-- 1. Pastikan struktur tabel `participants` dan `enrollments` sesuai Pertemuan 12
--    (Aman dilewati jika sudah dibuat melalui `php artisan migrate`)
CREATE TABLE IF NOT EXISTS `participants` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(120) NOT NULL,
    `phone` VARCHAR(20) NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    UNIQUE KEY `participants_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `enrollments` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `participant_id` BIGINT UNSIGNED NOT NULL,
    `course_id` BIGINT UNSIGNED NOT NULL,
    `status` VARCHAR(20) NOT NULL DEFAULT 'registered',
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    UNIQUE KEY `enrollments_participant_id_course_id_unique` (`participant_id`, `course_id`),
    CONSTRAINT `enrollments_participant_id_foreign`
        FOREIGN KEY (`participant_id`) REFERENCES `participants` (`id`) ON DELETE CASCADE,
    CONSTRAINT `enrollments_course_id_foreign`
        FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Isi 3 data dummy Participant sesuai Panduan Praktikum Langkah 5
--    Menggunakan INSERT IGNORE agar aman dijalankan ulang tanpa error duplikat email
INSERT IGNORE INTO `participants` (`name`, `email`, `phone`, `created_at`, `updated_at`) VALUES
('Alya Rahma',   'alya@example.test',  '081200000001', NOW(), NOW()),
('Bima Putra',   'bima@example.test',  '081200000002', NOW(), NOW()),
('Citra Nabila', 'citra@example.test', NULL,           NOW(), NOW());

-- 3. Isi data Enrollment awal sesuai Test Matrix Pertemuan 12
--    Menggunakan SELECT id berdasarkan email & code agar relasi foreign key selalu valid
INSERT IGNORE INTO `enrollments` (`participant_id`, `course_id`, `status`, `created_at`, `updated_at`)
SELECT p.id, c.id, 'registered', NOW(), NOW()
FROM `participants` p
JOIN `courses` c ON c.code = 'LRV-101'
WHERE p.email = 'alya@example.test';

INSERT IGNORE INTO `enrollments` (`participant_id`, `course_id`, `status`, `created_at`, `updated_at`)
SELECT p.id, c.id, 'registered', NOW(), NOW()
FROM `participants` p
JOIN `courses` c ON c.code = 'PHP-101'
WHERE p.email = 'alya@example.test';

INSERT IGNORE INTO `enrollments` (`participant_id`, `course_id`, `status`, `created_at`, `updated_at`)
SELECT p.id, c.id, 'registered', NOW(), NOW()
FROM `participants` p
JOIN `courses` c ON c.code = 'LRV-101'
WHERE p.email = 'bima@example.test';
