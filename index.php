<?php
include "db.php";
$produk = $conn->query("SELECT * FROM produk");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FOR TEAM Store</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans text-gray-800 bg-white">

<!-- Modal Pop-up Berhasil -->
<div id="popupBerhasil" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
  <div class="bg-white p-6 rounded shadow-lg text-center max-w-md">
    <h2 class="text-xl font-bold text-green-600 mb-2">Berhasil Diorder!</h2>
    <p class="mb-4">Pesanan Anda berhasil diproses. Anda akan diarahkan ke halaman checkout...</p>
    <button onclick="tutupPopup()" class="mt-2 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">OK</button>
  </div>
</div>

<?php
include "db.php";
$produk = $conn->query("SELECT * FROM produk");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FOR TEAM Store</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans text-gray-800 bg-white">

  <!-- Navbar -->
  <header class="w-full shadow-md sticky top-0 bg-white z-50">
    <div class="container mx-auto px-4 flex justify-between items-center py-4">
      <div class="text-2xl font-bold text-black-600">FOR TEAM</div>
      <nav class="hidden md:flex space-x-6 links">
        <a href="#" class="hover:text-blue-600">PRIA</a>
        <a href="#" class="hover:text-blue-600">WANITA</a>
        <a href="#" class="hover:text-blue-600">KATEGORI</a>
        <a href="#" class="hover:text-blue-600">BLOG</a>
        <a href="#" class="hover:text-blue-600">KONTAK</a>
        <a href="login.php" class="hover:text-blue-600 font-semibold">ADMIN</a>
      </nav>
    </div>
  </header>

  <!-- Banner -->
  <section class="bg-gray-100 py-12">
    <div class="container mx-auto flex flex-col md:flex-row items-center px-4">
      <div class="md:w-1/2 mb-6 md:mb-0">
        <p class="text-black-500 font-semibold">FOR TEAM SHOP ONLINE</p>
        <h1 class="text-4xl font-bold text-gray-800 my-2">Pilih Semua yang Kamu Suka</h1>
        <p class="text-gray-600 mb-4">Tersedia berbagai pilihan pakaian menarik hanya di sini.</p>
        <a href="#" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">BELANJA SEKARANG</a>
      </div>
      <div class="md:w-1/2">
        <img src="assets/images/banner.jpg" alt="banner" class="rounded shadow-lg" />
      </div>
    </div>
  </section>

  <!-- Produk -->
  <section class="bg-gray-50 py-12">
    <div class="container mx-auto px-4">
      <h2 class="text-2xl font-bold text-blue-600 mb-6">TREND COLLECTION</h2>
      <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-6">
        <?php while ($row = $produk->fetch_assoc()): ?>
          <?php if ($row['stok'] > 0): ?>
            <div class="bg-white rounded shadow p-4 text-center">
              <img src="assets/images/<?= $row['gambar'] ?>" alt="<?= $row['nama']?>" class="mx-auto mb-2 h-40 object-contain" />
              <p class="font-medium"><?= htmlspecialchars($row['nama']) ?></p>
              <p class="text-blue-600">Rp<?= number_format($row['harga'],0,',','.') ?></p>
              <p class="text-sm text-green-600 mb-2">Stok: <?= $row['stok'] ?></p>
              <button onclick="addToCartAndRedirect(<?= $row['id'] ?>)" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 inline-block">+ Keranjang</button>
            </div>
          <?php else: ?>
            <div class="bg-gray-100 rounded shadow p-4 text-center opacity-60">
              <p class="font-medium"><?= htmlspecialchars($row['nama']) ?></p>
              <p class="text-red-600 font-bold">SOLD OUT</p>
            </div>
          <?php endif; ?>
        <?php endwhile; ?>
      </div>
    </div>
  </section>



  <!-- Testimonials -->
  <section class="bg-white py-12">
    <div class="container mx-auto px-4">
      <h2 class="text-2xl font-bold text-blue-600 mb-6 text-center">Apa Kata Pelanggan</h2>
      <div class="grid gap-6 md:grid-cols-3">
        <div class="bg-gray-100 p-6 rounded shadow text-center"><p class="italic">"Baju-bajunya keren banget dan pas di badan!"</p><p class="font-bold mt-4">— Ardi, Mahasiswa</p></div>
        <div class="bg-gray-100 p-6 rounded shadow text-center"><p class="italic">"Pelayanan cepat dan kualitasnya oke banget."</p><p class="font-bold mt-4">— Sari, Freelancer</p></div>
        <div class="bg-gray-100 p-6 rounded shadow text-center"><p class="italic">"Aku suka desain bajunya, kekinian banget."</p><p class="font-bold mt-4">— Raka, Pelajar</p></div>
      </div>
    </div>
  </section>

  <!-- WhatsApp Contact -->
  <section class="bg-gray-100 py-12">
    <div class="container mx-auto px-4 max-w-md bg-white p-6 rounded shadow-md">
      <h2 class="text-2xl font-bold text-blue-600 mb-4 text-center">Hubungi Kami</h2>
      <div class="mb-4"><label class="block text-gray-700 mb-1">Nomor WhatsApp</label><input type="text" id="waNumber" placeholder="Contoh: 6281234567890" class="w-full px-4 py-2 border rounded"></div>
      <div class="mb-4"><label class="block text-gray-700 mb-1">Pesan</label><textarea id="waMessage" rows="4" placeholder="Tulis pesan Anda…" class="w-full px-4 py-2 border rounded"></textarea></div>
      <button onclick="sendToWhatsApp()" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Kirim via WhatsApp</button>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-blue-600 text-white py-8 mt-10">
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div><h3 class="font-bold text-lg mb-2">FOR TEAM</h3><p>Fashion that fits your vibe.</p></div>
        <div><h3 class="font-bold text-lg mb-2">Contact</h3><p>Email: rizkiramadhan31186@gmail.com</p><p>Phone: 0813-8899-1122</p><p>Depok, Mampang Pancoran Mas</p></div>
        <div><h3 class="font-bold text-lg mb-2">Social</h3><a href="#"><img src="assets/images/instagram.png" alt="ig" class="w-6"/></a></div>
      </div>
      <div class="text-center mt-6 text-sm">&copy; 2025 KIKUK. All rights reserved.</div>
    </div>
  </footer>

<script>
function tampilkanPopup() {
  document.getElementById("popupBerhasil").classList.remove("hidden");
  setTimeout(() => {
    window.location.href = 'checkout.php';
  }, 3000);
}

function tutupPopup() {
  document.getElementById("popupBerhasil").classList.add("hidden");
  window.location.href = 'checkout.php';
}

// Fungsi untuk redirect langsung ke checkout.php dengan ID produk
function addToCartAndRedirect(productId) {
  window.location.href = 'checkout.php?id=' + productId;
}

let cart = [];

function addToCart(item) {
  const existing = cart.find(p => p.id === item.id);
  if (existing) {
    existing.qty++;
    existing.subtotal = existing.qty * existing.harga;
  } else {
    cart.push({ ...item, qty: 1, subtotal: item.harga });
  }
  renderCart();
  showCart();
}

function renderCart() {
  const tbody = document.getElementById('cartTable');
  tbody.innerHTML = `
    <tr>
      <th class="text-left p-2">Nama</th>
      <th class="text-center p-2">Jumlah</th>
      <th class="text-right p-2">Subtotal</th>
    </tr>
  `;
  let total = 0;
  cart.forEach(item => {
    total += item.subtotal;
    tbody.innerHTML += `
      <tr>
        <td class="p-2">${item.nama}</td>
        <td class="p-2 text-center">${item.qty}</td>
        <td class="p-2 text-right">Rp${item.subtotal.toLocaleString()}</td>
      </tr>
    `;
  });
  document.getElementById('totalHarga').innerText = total.toLocaleString();
}

function showCart() {
  document.getElementById('cartSection').classList.remove('hidden');
  document.getElementById('checkoutFormSection').classList.add('hidden');
}

function openCheckout() {
  document.getElementById('checkoutFormSection').classList.remove('hidden');
  document.getElementById('cartSection').classList.remove('hidden');
}

document.getElementById('checkoutForm').addEventListener('submit', e => {
  e.preventDefault();
  if (cart.length === 0) return alert('Keranjang kosong!');
  const formData = new FormData(e.target);
  formData.append('cart', JSON.stringify(cart));
  formData.append('total', cart.reduce((a, i) => a + i.subtotal, 0));

  fetch('checkout.php', { method: 'POST', body: formData })
    .then(r => r.json()).then(json => {
      if (json.success) {
        cart = [];
        renderCart();
        document.getElementById('checkoutFormSection').classList.add('hidden');
        document.getElementById('cartSection').classList.add('hidden');
        tampilkanPopup();
      } else {
        alert('Checkout gagal: ' + json.error);
      }
    });
});
</script>


</body>
</html>
