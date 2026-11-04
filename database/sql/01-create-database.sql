-- Pertemuan 10, Bagian A — Membuat database kursusku di MySQL Laragon
-- Jalankan ini lewat tab SQL di phpMyAdmin, atau lewat terminal:
--   mysql -u root -p < database/sql/01-create-database.sql

CREATE DATABASE IF NOT EXISTS kursusku
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;
