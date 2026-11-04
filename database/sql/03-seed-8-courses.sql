-- Pertemuan 10, Bagian K/16 — Alternatif cepat mengisi 8 data kursus.
-- Jalankan SETELAH tabel `courses` ada (lewat `php artisan migrate`).
--
-- Tetap coba tambah minimal SATU data lewat form /courses/create terlebih
-- dahulu agar Anda memahami alur store() secara langsung — baru jalankan
-- file ini untuk mempercepat pengisian sisanya. Jika WEB-101 sudah pernah
-- dimasukkan lewat form, hapus baris itu di bawah atau ganti kodenya agar
-- tidak bentrok dengan rule `unique` pada kolom code.

INSERT INTO courses (code, name, description, fee, quota, start_date, status, created_at, updated_at) VALUES
('WEB-101',  'Web Dasar',          'HTML, CSS, dan dasar web.',                    300000, 25, '2026-11-11', 'open',   NOW(), NOW()),
('PHP-101',  'PHP Fundamental',    'Variabel, function, form, dan logika PHP.',    400000, 25, '2026-11-18', 'open',   NOW(), NOW()),
('LRV-101',  'Laravel Dasar',      'Route, controller, Blade, dan MVC.',           500000, 20, '2026-11-25', 'open',   NOW(), NOW()),
('SQL-101',  'MySQL Dasar',        'Merancang tabel dan query dasar.',             350000, 30, '2026-12-02', 'open',   NOW(), NOW()),
('UI-101',   'Bootstrap UI',       'Komponen dan utility class Bootstrap.',        300000, 25, '2026-12-09', 'draft',  NOW(), NOW()),
('JS-101',   'JavaScript Dasar',   'Variabel, event, dan DOM dasar.',              400000, 20, '2026-12-16', 'open',   NOW(), NOW()),
('AJAX-101', 'jQuery dan Ajax',    'Request asynchronous tanpa reload halaman.',   450000, 20, '2026-12-23', 'draft',  NOW(), NOW()),
('API-101',  'REST API Dasar',     'Konsep endpoint, JSON, dan HTTP method.',      550000, 18, '2026-12-30', 'closed', NOW(), NOW());
