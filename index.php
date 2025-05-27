<?php
include "db.php";
$produk = $conn->query("SELECT * FROM produk");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>KIKUK Store</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans text-gray-800 bg-white">

  <!-- Navbar -->
  <header class="w-full shadow-md sticky top-0 bg-white z-50">
    <div class="container mx-auto px-4 flex justify-between items-center py-4">
      <div class="text-2xl font-bold text-black-600">KIKUK</div>
      <nav class="hidden md:flex space-x-6 links transition-all duration-300">
        <a href="#" class="hover:text-blue-600">PRIA</a>
        <a href="#" class="hover:text-blue-600">WANITA</a>
        <a href="#" class="hover:text-blue-600">KATEGORI</a>
        <a href="#" class="hover:text-blue-600">BLOG</a>
        <a href="#" class="hover:text-blue-600">KONTAK</a>
        <a href="login.php" class="hover:text-blue-600 font-semibold">ADMIN</a>
        <input type="search" placeholder="Search..." class="px-2 py-1 border rounded" />
      </nav>
    </div>
    <div class="md:hidden hidden flex-col bg-white px-4 pb-4 links">
      <a href="#" class="py-2 border-b">PRIA</a>
      <a href="#" class="py-2 border-b">WANITA</a>
      <a href="#" class="py-2 border-b">KATEGORI</a>
      <a href="#" class="py-2 border-b">BLOG</a>
      <a href="#" class="py-2 border-b">KONTAK</a>
      <a href="login.php" class="py-2 border-b font-semibold">ADMIN</a>
      <input type="search" placeholder="Search..." class="px-2 py-1 border rounded w-full mt-2" />
    </div>
  </header>

  <!-- Banner -->
  <section class="bg-gray-100 py-12">
    <div class="container mx-auto flex flex-col md:flex-row items-center px-4">
      <div class="md:w-1/2 mb-6 md:mb-0">
        <p class="text-black-500 font-semibold">KIKUK SHOP ONLINE</p>
        <h1 class="text-4xl font-bold text-gray-800 my-2">Pilih Semua yang Kamu Suka</h1>
        <p class="text-gray-600 mb-4">Tersedia berbagai pilihan pakaian menarik hanya di sini.</p>
        <a href="#" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">BELANJA SEKARANG</a>
      </div>
      <div class="md:w-1/2">
        <img src="assets/images/banner.jpg" alt="banner" class="rounded shadow-lg" />
      </div>
    </div>
  </section>

  <!-- Produk Populer -->
  <section class="bg-gray-50 py-12">
    <div class="container mx-auto px-4">
      <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
        <h2 class="text-2xl font-bold text-blue-600">TREND COLLECTION</h2>
        <div class="flex items-center gap-2">
          <button onclick="filterProducts('all')" class="filter-btn bg-blue-100 text-blue-600 px-3 py-1 rounded hover:bg-blue-200">Semua</button>
          <button onclick="filterProducts('pria')" class="filter-btn bg-blue-100 text-blue-600 px-3 py-1 rounded hover:bg-blue-200">Pria</button>
          <button onclick="filterProducts('wanita')" class="filter-btn bg-blue-100 text-blue-600 px-3 py-1 rounded hover:bg-blue-200">Wanita</button>
        </div>
        <input type="text" onkeyup="searchProducts()" id="searchInput" placeholder="Cari produk..." class="px-3 py-1 border rounded w-full md:w-64 focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      <div id="productContainer" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-6">
        <?php while ($row = $produk->fetch_assoc()): ?>
          <div class="bg-white rounded shadow-md p-4 text-center product-card" data-gender="<?= $row['gender'] ?>">
            <img src="assets/images/<?= $row['gambar'] ?>" alt="<?= $row['nama'] ?>" class="mx-auto mb-2 h-40 object-contain" />
            <p class="text-gray-700 font-medium"><?= $row['nama'] ?></p>
            <p class="text-blue-600">Rp<?= number_format($row['harga'], 0, ',', '.') ?></p>
          </div>
        <?php endwhile; ?>
      </div>
    </div>
  </section>

  <!-- Testimonials -->
  <section class="bg-white py-12">
    <div class="container mx-auto px-4">
      <h2 class="text-2xl font-bold text-blue-600 mb-6 text-center">Apa Kata Pelanggan</h2>
      <div class="grid gap-6 md:grid-cols-3">
        <div class="bg-gray-100 p-6 rounded shadow text-center">
          <p class="italic">"Baju-bajunya keren banget dan pas di badan!"</p>
          <p class="font-bold mt-4">— Ardi, Mahasiswa</p>
        </div>
        <div class="bg-gray-100 p-6 rounded shadow text-center">
          <p class="italic">"Pelayanan cepat dan kualitasnya oke banget."</p>
          <p class="font-bold mt-4">— Sari, Freelancer</p>
        </div>
        <div class="bg-gray-100 p-6 rounded shadow text-center">
          <p class="italic">"Aku suka desain bajunya, kekinian banget."</p>
          <p class="font-bold mt-4">— Raka, Pelajar</p>
        </div>
      </div>
    </div>
  </section>

  <!-- WhatsApp Contact -->
  <section class="bg-gray-100 py-12">
    <div class="container mx-auto px-4 max-w-md bg-white p-6 rounded shadow-md">
      <h2 class="text-2xl font-bold text-blue-600 mb-4 text-center">Hubungi Kami</h2>
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
        <input type="text" id="waNumber" placeholder="Contoh: 6281234567890" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
        <textarea id="waMessage" rows="4" placeholder="Tulis pesan Anda di sini..." class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
      </div>
      <button onclick="sendToWhatsApp()" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Kirim via WhatsApp</button>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-blue-600 text-white py-8 mt-10">
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div>
          <h3 class="font-bold text-lg mb-2">KIKUK</h3>
          <p>Fashion that fits your vibe.</p>
        </div>
        <div>
          <h3 class="font-bold text-lg mb-2">Contact</h3>
          <p>Email: rizkiramadhan31186@gmail.com</p>
          <p>Phone: 0813-8899-1122</p>
          <p>Depok, Mampang Pancoran Mas</p>
        </div>
        <div>
          <h3 class="font-bold text-lg mb-2">Social</h3>
          <a href="#"><img src="assets/images/instagram.png" alt="ig" class="w-6" /></a>
        </div>
      </div>
      <div class="text-center mt-6 text-sm">
        &copy; 2025 KIKUK. All rights reserved.
      </div>
    </div>
  </footer>

  <!-- Script -->
  <script>
    function searchProducts() {
      const input = document.getElementById('searchInput').value.toLowerCase();
      const cards = document.querySelectorAll('.product-card');

      cards.forEach(card => {
        const text = card.textContent.toLowerCase();
        card.style.display = text.includes(input) ? 'block' : 'none';
      });
    }

    function filterProducts(gender) {
      const cards = document.querySelectorAll('.product-card');
      cards.forEach(card => {
        const cardGender = card.getAttribute('data-gender');
        card.style.display = (gender === 'all' || cardGender === gender) ? 'block' : 'none';
      });
      document.getElementById('searchInput').value = '';
    }

    function sendToWhatsApp() {
      const number = document.getElementById('waNumber').value.trim();
      const message = document.getElementById('waMessage').value.trim();

      if (!number || !message) {
        alert("Nomor dan pesan harus diisi.");
        return;
      }

      const url = `https://wa.me/${number}?text=${encodeURIComponent(message)}`;
      window.open(url, '_blank');
    }
  </script>

</body>
</html>
