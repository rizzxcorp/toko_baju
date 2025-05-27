<?php
include "db.php";
$id = $_POST['id'];
$harga = $_POST['harga'];

$conn->query("UPDATE produk SET harga = $harga WHERE id = $id");
header("Location: dashboard.php");
?>
