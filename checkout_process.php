<?php
include "db.php";

$produk_id = $_GET['produk_id'] ?? null;
$harga     = $_GET['harga'] ?? 0;
$pelanggan_id = $_GET['pelanggan_id'] ?? null;

$tanggal = date("Y-m-d H:i:s");
$status  = 'pending';

if (!$produk_id || !$harga || !$pelanggan_id) {
  echo "<script>alert('Data tidak lengkap.'); window.history.back();</script>";
  exit;
}

// Validasi stok
$cekStok = $conn->prepare("SELECT stok FROM produk WHERE id = ?");
$cekStok->bind_param("i", $produk_id);
$cekStok->execute();
$stok = $cekStok->get_result()->fetch_assoc()['stok'] ?? 0;

if ($stok <= 0) {
  echo "<script>alert('Stok habis.'); window.location.href='index.php';</script>";
  exit;
}

// Simpan pembelian
$insertPembelian = $conn->prepare("INSERT INTO pembelian (pelanggan_id, tanggal, total_harga, status) VALUES (?, ?, ?, ?)");
$insertPembelian->bind_param("isis", $pelanggan_id, $tanggal, $harga, $status);
$insertPembelian->execute();
$pembelian_id = $insertPembelian->insert_id;

// Detail pembelian
$qty = 1;
$insertDetail = $conn->prepare("INSERT INTO pembelian_detail (pembelian_id, produk_id, jumlah, harga_satuan) VALUES (?, ?, ?, ?)");
$insertDetail->bind_param("iiid", $pembelian_id, $produk_id, $qty, $harga);
$insertDetail->execute();

// Kurangi stok
$updateStok = $conn->prepare("UPDATE produk SET stok = stok - 1 WHERE id = ?");
$updateStok->bind_param("i", $produk_id);
$updateStok->execute();

// Tambahkan ke transaksi
$ambilNama = $conn->prepare("SELECT nama, alamat, no_hp FROM pelanggan WHERE id = ?");
$ambilNama->bind_param("i", $pelanggan_id);
$ambilNama->execute();
$dataPelanggan = $ambilNama->get_result()->fetch_assoc();

$insertTransaksi = $conn->prepare("INSERT INTO transaksi (nama, alamat, telepon, total, tanggal, status) VALUES (?, ?, ?, ?, ?, ?)");
$insertTransaksi->bind_param(
    "sssiss",
    $dataPelanggan['nama'],
    $dataPelanggan['alamat'],
    $dataPelanggan['no_hp'],
    $harga,
    $tanggal,
    $status
);
$insertTransaksi->execute();

// Redirect ke tutorial pembayaran dengan ID pembelian
header("Location: pembayaran.php?id=$pembelian_id");
exit;
?>
