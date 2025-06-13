<?php
include "db.php";

$nama = $_POST['nama'];
$harga = $_POST['harga'];
$stok = $_POST['stok']; // 🟢 Ambil data stok dari form
$gender = $_POST['gender'];
$gambar = $_FILES['gambar']['name'];
$tmp = $_FILES['gambar']['tmp_name'];

// Upload gambar ke folder
move_uploaded_file($tmp, "assets/images/" . $gambar);

// Simpan data lengkap ke database, termasuk stok
$conn->query("INSERT INTO produk (nama, harga, stok, gender, gambar) VALUES ('$nama', '$harga', '$stok', '$gender', '$gambar')");

header("Location: dashboard.php");
?>
