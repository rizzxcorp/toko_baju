<?php
include "db.php";

$produk = null;

// Ambil data produk berdasarkan ID di URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM produk WHERE id = $id");
    $produk = $result->fetch_assoc();
}

// Tangani penyimpanan pelanggan jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi semua data tersedia
    if (isset($_POST['produk_id'], $_POST['harga'], $_POST['nama'], $_POST['alamat'], $_POST['telepon'])) {
        $produk_id = intval($_POST['produk_id']);
        $harga     = intval($_POST['harga']);
        $nama      = $conn->real_escape_string($_POST['nama']);
        $alamat    = $conn->real_escape_string($_POST['alamat']);
        $telepon   = $conn->real_escape_string($_POST['telepon']);

        // Cek apakah pelanggan sudah ada berdasarkan nama dan no telepon
        $cek = $conn->query("SELECT id FROM pelanggan WHERE nama = '$nama' AND no_hp = '$telepon'");
        if ($cek->num_rows > 0) {
            $pelanggan = $cek->fetch_assoc();
            $pelanggan_id = $pelanggan['id'];
        } else {
            // Masukkan ke tabel pelanggan
            $conn->query("INSERT INTO pelanggan (nama, alamat, no_hp, email, password) VALUES ('$nama', '$alamat', '$telepon', '', '')");
            $pelanggan_id = $conn->insert_id;
        }

        // Redirect ke halaman proses checkout
        header("Location: checkout_process.php?produk_id=$produk_id&harga=$harga&pelanggan_id=$pelanggan_id");
        exit();
    } else {
        echo "<script>alert('Data tidak lengkap.'); window.history.back();</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout - KIKUK</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans">

  <div class="container mx-auto px-4 py-12 max-w-xl bg-white rounded shadow">
    <h2 class="text-2xl font-bold text-blue-600 mb-6">Checkout Produk</h2>

    <?php if ($produk): ?>
      <div class="mb-6">
        <img src="assets/images/<?= htmlspecialchars($produk['gambar']) ?>" alt="<?= htmlspecialchars($produk['nama']) ?>" class="w-40 h-40 object-contain mx-auto mb-4">
        <p class="text-center font-semibold"><?= htmlspecialchars($produk['nama']) ?></p>
        <p class="text-center text-blue-600">Rp<?= number_format($produk['harga'], 0, ',', '.') ?></p>
      </div>

      <form action="" method="post">
        <input type="hidden" name="produk_id" value="<?= $produk['id'] ?>">
        <input type="hidden" name="harga" value="<?= $produk['harga'] ?>">

        <input type="text" name="nama" placeholder="Nama lengkap" required class="w-full px-4 py-2 border rounded mb-3">
        <input type="text" name="alamat" placeholder="Alamat lengkap" required class="w-full px-4 py-2 border rounded mb-3">
        <input type="text" name="telepon" placeholder="No. Telepon" required class="w-full px-4 py-2 border rounded mb-3">

        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 w-full">Bayar Sekarang</button>
      </form>
    <?php else: ?>
      <p class="text-center text-red-600 font-semibold">Produk tidak ditemukan. Pastikan Anda membuka halaman dengan parameter <code>?id=</code>.</p>
    <?php endif; ?>
  </div>

</body>
</html>
