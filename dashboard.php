<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

// Ambil semua produk
$produk = $conn->query("SELECT * FROM produk");

// Jumlah pelanggan
$jml_pelanggan = $conn->query("SELECT COUNT(*) AS cnt FROM pelanggan")->fetch_assoc()['cnt'];

// Rekap penjualan produk
$rekap_produk = $conn->query("
    SELECT p.nama, p.harga, COALESCE(SUM(td.qty), 0) AS terjual
    FROM produk p
    LEFT JOIN transaksi_detail td ON td.produk_id = p.id
    GROUP BY p.id
");

// Hitung total penjualan
$total_penjualan = 0;
$rekap_produk->data_seek(0);
while ($r = $rekap_produk->fetch_assoc()) {
    $total_penjualan += $r['harga'] * $r['terjual'];
}

// Hitung total aset produk
$result_aset = $conn->query("SELECT SUM(harga * stok) AS aset FROM produk");
$row_aset = $result_aset->fetch_assoc();
$total_aset = $row_aset['aset'] ?? 0;

// Ambil transaksi terbaru
$transaksi = $conn->query("SELECT id, nama AS pelanggan, tanggal, total, status FROM transaksi ORDER BY tanggal DESC LIMIT 5");
$jml_transaksi = $conn->query("SELECT COUNT(*) AS cnt FROM transaksi")->fetch_assoc()['cnt'];
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

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
      <div class="bg-white p-4 rounded shadow text-center">
        <p class="text-sm text-gray-500">Total Produk</p>
        <p class="text-2xl font-bold"><?= $produk->num_rows ?></p>
      </div>
      <div class="bg-white p-4 rounded shadow text-center">
        <p class="text-sm text-gray-500">Total Pelanggan</p>
        <p class="text-2xl font-bold"><?= $jml_pelanggan ?></p>
      </div>
      <div class="bg-white p-4 rounded shadow text-center">
        <p class="text-sm text-gray-500">Total Transaksi</p>
        <p class="text-2xl font-bold"><?= $jml_transaksi ?></p>
      </div>
    </div>

    <!-- Penjualan & Aset -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
      <div class="bg-green-100 p-4 rounded shadow">
        <h2 class="text-xl font-semibold text-green-700">Total Penjualan</h2>
        <p class="text-2xl font-bold mt-2">Rp<?= number_format($total_penjualan, 0, ',', '.') ?></p>
      </div>
      <div class="bg-yellow-100 p-4 rounded shadow">
        <h2 class="text-xl font-semibold text-yellow-700">Total Aset Produk</h2>
        <p class="text-2xl font-bold mt-2">Rp<?= number_format($total_aset, 0, ',', '.') ?></p>
      </div>
    </div>

    <!-- Form Tambah Produk -->
    <div class="mb-10">
      <h2 class="text-xl font-semibold mb-4">Tambah Produk</h2>
      <form action="proses_tambah.php" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-4 rounded shadow">
        <input type="text" name="nama" placeholder="Nama Produk" required class="w-full px-4 py-2 border rounded">
        <input type="number" name="harga" placeholder="Harga Produk" required class="w-full px-4 py-2 border rounded">
        <input type="number" name="stok" placeholder="Stok" required class="w-full px-4 py-2 border rounded">
        <select name="gender" required class="w-full px-4 py-2 border rounded">
          <option value="">Pilih Gender</option>
          <option value="pria">Pria</option>
          <option value="wanita">Wanita</option>
        </select>
        <input type="file" name="gambar" accept="image/*" required class="w-full">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Tambah Produk</button>
      </form>
    </div>

    <!-- Daftar Produk -->
    <h2 class="text-xl font-semibold mb-4">Daftar Produk</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-10">
      <?php $produk->data_seek(0); while ($row = $produk->fetch_assoc()): ?>
      <div class="bg-white p-4 rounded shadow text-center">
        <img src="assets/images/<?= htmlspecialchars($row['gambar']) ?>" class="h-32 mx-auto mb-2 object-contain" alt="<?= htmlspecialchars($row['nama']) ?>">
        <form action="update_produk.php" method="POST" enctype="multipart/form-data" class="space-y-2">
          <input type="hidden" name="id" value="<?= $row['id'] ?>">
          <input type="text" name="nama" value="<?= htmlspecialchars($row['nama']) ?>" class="w-full px-2 py-1 border rounded" required>
          <input type="number" name="harga" value="<?= $row['harga'] ?>" class="w-full px-2 py-1 border rounded" required>
          <input type="number" name="stok" value="<?= $row['stok'] ?>" class="w-full px-2 py-1 border rounded" required>
          <input type="file" name="gambar" accept="image/*" class="w-full text-sm">
          <button type="submit" class="bg-yellow-400 px-3 py-1 rounded w-full hover:bg-yellow-500">Simpan</button>
        </form>
        <form action="hapus_produk.php" method="POST" onsubmit="return confirm('Yakin ingin hapus?')" class="mt-2">
          <input type="hidden" name="id" value="<?= $row['id'] ?>">
          <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 w-full">Hapus</button>
        </form>
      </div>
      <?php endwhile; ?>
    </div>

    <!-- Rekap Produk Terjual -->
    <div class="mb-10">
      <h2 class="text-xl font-semibold mb-4">Rekap Pembelian Produk</h2>
      <table class="w-full text-sm text-left bg-white rounded shadow">
        <thead class="bg-gray-100">
          <tr>
            <th class="p-3">Produk</th>
            <th class="p-3">Harga</th>
            <th class="p-3">Jumlah Terjual</th>
            <th class="p-3">Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <?php $rekap_produk->data_seek(0); while ($r = $rekap_produk->fetch_assoc()): ?>
          <tr class="border-t">
            <td class="p-3"><?= htmlspecialchars($r['nama']) ?></td>
            <td class="p-3">Rp<?= number_format($r['harga'], 0, ',', '.') ?></td>
            <td class="p-3"><?= $r['terjual'] ?></td>
            <td class="p-3">Rp<?= number_format($r['harga'] * $r['terjual'], 0, ',', '.') ?></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <!-- Transaksi Terbaru -->
    <div class="mb-10">
      <h2 class="text-xl font-semibold mb-4">Transaksi Terbaru</h2>
      <table class="w-full text-sm text-left bg-white rounded shadow">
        <thead class="bg-gray-100">
          <tr>
            <th class="p-3">ID</th>
            <th class="p-3">Pelanggan</th>
            <th class="p-3">Tanggal</th>
            <th class="p-3">Total</th>
            <th class="p-3">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($transaksi->num_rows > 0): ?>
            <?php while ($t = $transaksi->fetch_assoc()): ?>
            <tr class="border-t">
              <td class="p-3"><?= $t['id'] ?></td>
              <td class="p-3"><?= htmlspecialchars($t['pelanggan']) ?></td>
              <td class="p-3"><?= $t['tanggal'] ?></td>
              <td class="p-3">Rp<?= number_format($t['total'], 0, ',', '.') ?></td>
              <td class="p-3">
                <form action="ubah_status.php" method="POST" class="flex items-center space-x-2">
                  <input type="hidden" name="id" value="<?= $t['id'] ?>">
                  <select name="status" class="border px-2 py-1 rounded text-sm">
                    <option value="proses" <?= $t['status'] == 'proses' ? 'selected' : '' ?>>Proses</option>
                    <option value="dikirim" <?= $t['status'] == 'dikirim' ? 'selected' : '' ?>>Dikirim</option>
                    <option value="selesai" <?= $t['status'] == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                  </select>
                  <button class="bg-blue-500 text-white px-2 py-1 rounded text-sm hover:bg-blue-600">Ubah</button>
                </form>
              </td>
            </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="5" class="p-3 text-center text-gray-500">Belum ada transaksi.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Footer -->
    <div class="text-center mt-10 text-sm text-gray-500">
      <a href="logout.php" class="underline text-blue-600">Logout</a>
    </div>
  </div>
</body>
</html>
