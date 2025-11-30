-- SQL dump for db_uangkas
CREATE DATABASE IF NOT EXISTS db_uangkas;
USE db_uangkas;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','guru') DEFAULT 'admin'
);

-- password for admin = admin123 (bcrypt hash)
INSERT INTO users (username, password, role) VALUES
('admin', '$2y$10$u4S8Oe6.PyVFpEzgOQ2ruODq8km5KyMxmUgZSuxCAz76mnTmwi2o.', 'admin');

CREATE TABLE siswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    nis VARCHAR(50),
    jk ENUM('L','P') DEFAULT 'L',
    alamat TEXT
);

CREATE TABLE kas_masuk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    siswa_id INT,
    tanggal DATE,
    jumlah INT,
    keterangan VARCHAR(200),
    FOREIGN KEY (siswa_id) REFERENCES siswa(id) ON DELETE SET NULL
);

CREATE TABLE kas_keluar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tanggal DATE,
    jumlah INT,
    keterangan VARCHAR(200)
);

CREATE TABLE bulan_iuran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_bulan VARCHAR(20),
    tahun INT
);
