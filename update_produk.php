<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id     = $_POST['id'];
    $nama   = $_POST['nama'];
    $harga  = $_POST['harga'];

    // Update gambar jika diupload
    if ($_FILES['gambar']['name']) {
        $gambar = $_FILES['gambar']['name'];
        $tmp    = $_FILES['gambar']['tmp_name'];
        $path   = "assets/images/" . $gambar;
        move_uploaded_file($tmp, $path);

        // Update nama, harga, dan gambar
        $conn->query("UPDATE produk SET nama='$nama', harga='$harga', gambar='$gambar' WHERE id=$id");
    } else {
        // Update tanpa gambar
        $conn->query("UPDATE produk SET nama='$nama', harga='$harga' WHERE id=$id");
    }

    header("Location: dashboard.php");
}
?>
