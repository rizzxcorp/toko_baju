<?php
include "db.php";

$nama = $_POST['nama'];
$harga = $_POST['harga'];
$gender = $_POST['gender'];
$gambar = $_FILES['gambar']['name'];
$tmp = $_FILES['gambar']['tmp_name'];

move_uploaded_file($tmp, "assets/images/" . $gambar);

$conn->query("INSERT INTO produk (nama, harga, gender, gambar) VALUES ('$nama', '$harga', '$gender', '$gambar')");

header("Location: dashboard.php");
?>
