<?php
include "db.php";
$id = $_POST['id'];

$conn->query("DELETE FROM produk WHERE id = $id");
header("Location: dashboard.php");
?>
