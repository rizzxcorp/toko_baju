<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE transaksi SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: dashboard.php");
    exit();
}
?>
