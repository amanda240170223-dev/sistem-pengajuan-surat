-- Membuat database
CREATE DATABASE IF NOT EXISTS sistem_surat_pengajuan_mahasiswa;

USE sistem_surat_pengajuan_mahasiswa;

-- Membuat tabel pengajuan
CREATE TABLE pengajuan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    nim VARCHAR(20) NOT NULL,
    jenis_surat VARCHAR(100) NOT NULL,
    keterangan TEXT NOT NULL,
    status VARCHAR(50) DEFAULT 'Diproses',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP
);
