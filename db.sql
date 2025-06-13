-- Hapus database jika sudah ada (hati-hati, akan menghapus data lama!)
DROP DATABASE IF EXISTS kikuk;
CREATE DATABASE kikuk;
USE kikuk;

-- Admin
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

INSERT INTO admin (username, password) VALUES ('admin', 'admin123');

-- Produk
CREATE TABLE produk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    harga INT NOT NULL,
    stok INT NOT NULL DEFAULT 0,
    gambar VARCHAR(255),
    gender ENUM('pria', 'wanita') NOT NULL
);

-- Pelanggan
CREATE TABLE pelanggan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    no_hp VARCHAR(20),
    alamat TEXT,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Transaksi
CREATE TABLE transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),         -- Nama Pelanggan
    alamat TEXT,
    telepon VARCHAR(20),
    total INT,
    tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(20) DEFAULT 'proses'
);

-- Detail Transaksi (penjualan)
CREATE TABLE transaksi_detail (
    id INT AUTO_INCREMENT PRIMARY KEY,
    transaksi_id INT,
    produk_id INT,
    qty INT,
    subtotal DOUBLE,
    FOREIGN KEY (transaksi_id) REFERENCES transaksi(id) ON DELETE CASCADE,
    FOREIGN KEY (produk_id) REFERENCES produk(id)
);

-- Pembelian (checkout)
CREATE TABLE pembelian (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pelanggan_id INT NOT NULL,
    tanggal DATETIME NOT NULL,
    total_harga INT NOT NULL,
    status VARCHAR(50) DEFAULT 'pending',
    FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(id) ON DELETE CASCADE
);

-- Detail pembelian
CREATE TABLE pembelian_detail (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pembelian_id INT NOT NULL,
    produk_id INT NOT NULL,
    jumlah INT NOT NULL,
    harga_satuan INT NOT NULL,
    FOREIGN KEY (pembelian_id) REFERENCES pembelian(id) ON DELETE CASCADE,
    FOREIGN KEY (produk_id) REFERENCES produk(id)
);
