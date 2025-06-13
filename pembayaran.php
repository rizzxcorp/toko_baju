<?php
$id = $_GET['id'] ?? null;
if (!$id) {
  echo "<script>alert('Data tidak ditemukan.'); window.location.href='index.php';</script>";
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tutorial Pembayaran</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center px-4 py-10">

  <!-- Kontainer utama -->
  <div class="bg-white shadow-lg p-6 rounded-lg w-full max-w-lg relative">
    <h1 class="text-2xl md:text-3xl font-bold text-blue-700 text-center mb-4">Tutorial Pembayaran</h1>
    
    <p class="text-center text-gray-700 mb-4">Silakan scan QRIS di bawah ini untuk melakukan pembayaran:</p>
    
    <div class="flex justify-center mb-4">
      <img src="assets/images/qr.jpg" alt="QRIS" class="w-full max-w-xs sm:max-w-sm border rounded-md shadow-sm">
    </div>
    
    <p class="text-sm text-gray-500 text-center mb-6">
      Setelah membayar, klik tombol konfirmasi di bawah ini.
    </p>
    
    <div class="flex justify-center">
      <button onclick="tampilkanPopup()" class="w-full sm:w-auto bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
        Konfirmasi Pembayaran
      </button>
    </div>
  </div>

  <!-- Pop-up notifikasi -->
  <div id="popup" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full text-center animate-fade-in">
      <h2 class="text-xl font-semibold mb-2 text-green-600">Pesanan Berhasil!</h2>
      <p class="text-gray-700 mb-4">Kami akan memberi tahu Anda melalui WhatsApp untuk bukti transaksi pembelian.</p>
      <button onclick="tutupPopup()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
        OK
      </button>
    </div>
  </div>

  <!-- Animasi -->
  <style>
    .animate-fade-in {
      animation: fadeIn 0.3s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.95); }
      to { opacity: 1; transform: scale(1); }
    }
  </style>

  <!-- Script -->
  <script>
    function tampilkanPopup() {
      document.getElementById('popup').classList.remove('hidden');
    }

    function tutupPopup() {
      window.location.href = 'index.php';
    }
  </script>

</body>
</html>
