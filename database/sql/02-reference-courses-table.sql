-- REFERENSI SAJA — bukan untuk dijalankan jika Anda sudah memakai
-- `php artisan migrate` (lihat PANDUAN-TERMINAL.md Langkah 4).
--
-- File ini menunjukkan struktur tabel `courses` yang SEHARUSNYA dihasilkan
-- oleh database/migrations/2026_10_29_000000_create_courses_table.php,
-- persis sesuai blueprint di Panduan Praktikum Pertemuan 10 Bagian C/D.
-- Gunakan untuk membandingkan hasil "DESCRIBE courses;" di phpMyAdmin,
-- bukan untuk membuat tabel secara manual.

CREATE TABLE IF NOT EXISTS courses (
    id               BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    code             VARCHAR(20)  NOT NULL,
    name             VARCHAR(120) NOT NULL,
    description      TEXT         NULL,
    fee              INT UNSIGNED NOT NULL DEFAULT 0,
    quota            SMALLINT UNSIGNED NOT NULL DEFAULT 20,
    start_date       DATE         NOT NULL,
    status           ENUM('draft', 'open', 'closed') NOT NULL DEFAULT 'draft',
    created_at       TIMESTAMP    NULL,
    updated_at       TIMESTAMP    NULL,
    UNIQUE KEY courses_code_unique (code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
