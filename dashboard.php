<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include "db.php";
$produk = $conn->query("SELECT * FROM produk");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-6 text-gray-800">
  <div class="max-w-6xl mx-auto">
    <h1 class="text-3xl font-bold text-blue-700 mb-6">Dashboard Admin</h1>

    <!-- Tambah Produk -->
    <div class="mb-10">
      <h2 class="text-xl font-semibold mb-4">Tambah Produk</h2>
      <form action="proses_tambah.php" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-4 rounded shadow">
        <input type="text" name="nama" placeholder="Nama Produk" required class="w-full px-4 py-2 border rounded" />
        <input type="number" name="harga" placeholder="Harga Produk" required class="w-full px-4 py-2 border rounded" />
        <select name="gender" required class="w-full px-4 py-2 border rounded">
          <option value="">Pilih Gender</option>
          <option value="pria">Pria</option>
          <option value="wanita">Wanita</option>
        </select>
        <input type="file" name="gambar" accept="image/*" required class="w-full" />
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Tambah Produk</button>
      </form>
    </div>

    <!-- List Produk -->
    <h2 class="text-xl font-semibold mb-4">Daftar Produk</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
      <?php while ($row = $produk->fetch_assoc()): ?>
        <div class="bg-white p-4 rounded shadow text-center">
          <img src="assets/images/<?php echo $row['gambar']; ?>" class="h-32 mx-auto mb-2 object-contain" />
          <p class="font-semibold"><?php echo $row['nama']; ?></p>
          <p class="text-blue-600">Rp<?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
          <form action="update_harga.php" method="POST" class="mt-2 flex gap-2">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <input type="number" name="harga" value="<?= $row['harga'] ?>" class="border px-2 py-1 rounded w-full" />
            <button class="bg-yellow-400 px-2 py-1 rounded">Ubah</button>
          </form>
          <form action="hapus_produk.php" method="POST" onsubmit="return confirm('Yakin ingin hapus?')" class="mt-2">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 w-full">Hapus</button>
          </form>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</body>
</html>
