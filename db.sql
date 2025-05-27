CREATE DATABASE IF NOT EXISTS kikuk;
USE kikuk;

CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

INSERT INTO admin (username, password)
VALUES ('admin', 'admin123');

CREATE TABLE produk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    harga INT,
    gender ENUM('pria', 'wanita'),
    gambar VARCHAR(255)
);
