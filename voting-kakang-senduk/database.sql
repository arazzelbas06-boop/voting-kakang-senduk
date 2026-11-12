CREATE DATABASE IF NOT EXISTS db_voting_kakang_senduk CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_voting_kakang_senduk;

CREATE TABLE users (
 id INT AUTO_INCREMENT PRIMARY KEY,
 nama VARCHAR(100) NOT NULL,
 email VARCHAR(100) NOT NULL UNIQUE,
 no_hp VARCHAR(20) NOT NULL,
 password VARCHAR(255) NOT NULL,
 role ENUM('admin','pemilih') NOT NULL DEFAULT 'pemilih',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE kontestan (
 id INT AUTO_INCREMENT PRIMARY KEY,
 nomor_peserta VARCHAR(10) NOT NULL UNIQUE,
 nama VARCHAR(100) NOT NULL,
 kategori ENUM('Kakang','Senduk') NOT NULL,
 foto VARCHAR(255) DEFAULT NULL,
 tempat_lahir VARCHAR(100) DEFAULT NULL,
 tanggal_lahir DATE DEFAULT NULL,
 asal_instansi VARCHAR(150) NOT NULL,
 visi TEXT, misi TEXT, prestasi TEXT, deskripsi TEXT,
 status ENUM('Aktif','Nonaktif') DEFAULT 'Aktif',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE periode_voting (
 id INT AUTO_INCREMENT PRIMARY KEY,
 nama_periode VARCHAR(100) NOT NULL,
 tanggal_mulai DATETIME NOT NULL,
 tanggal_selesai DATETIME NOT NULL,
 status ENUM('Aktif','Nonaktif') DEFAULT 'Nonaktif',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE voting (
 id INT AUTO_INCREMENT PRIMARY KEY,
 user_id INT NOT NULL,
 kontestan_id INT NOT NULL,
 kategori ENUM('Kakang','Senduk') NOT NULL,
 periode_id INT NOT NULL,
 created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
 UNIQUE KEY unik_voting (user_id,periode_id),
 CONSTRAINT fk_voting_user FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE RESTRICT,
 CONSTRAINT fk_voting_kontestan FOREIGN KEY(kontestan_id) REFERENCES kontestan(id) ON DELETE RESTRICT,
 CONSTRAINT fk_voting_periode FOREIGN KEY(periode_id) REFERENCES periode_voting(id) ON DELETE RESTRICT,
 INDEX idx_kontestan(kontestan_id),
 INDEX idx_periode(periode_id)
) ENGINE=InnoDB;
