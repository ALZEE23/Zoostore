<x-navbar>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Riwayat Pemesanan - Detail Pesanan</title>
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <style>
    /* Custom Scrollbar */
    ::-webkit-scrollbar {
      width: 8px;
    }
    ::-webkit-scrollbar-thumb {
      background: #ccc;
      border-radius: 4px;
    }
    /* Animasi Modal */
    .modal-enter { opacity: 0; transform: translateY(-10%); }
    .modal-enter-active { opacity: 1; transform: translateY(0); transition: opacity 300ms, transform 300ms; }
    .modal-leave { opacity: 1; transform: translateY(0); }
    .modal-leave-active { opacity: 0; transform: translateY(-10%); transition: opacity 300ms, transform 300ms; }
  </style>
</head>
<body class="bg-gray-100 transition-colors duration-500">
  <!-- Konten Utama -->
  <div class="container mx-auto bg-white p-8 mt-28 mb-12 rounded-lg shadow-lg">
    <h2 class="text-3xl font-bold mb-8 text-gray-800 text-center flex items-center justify-center space-x-3">
      <i class="fas fa-clipboard-list text-yellow-500"></i>
      <span>Detail Pesanan</span>
    </h2>
    
    <!-- Ringkasan Pesanan -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
      <!-- Gambar Produk -->
      <div class="flex items-center justify-center">
        <img src="{{ asset('/assets/baby.jpeg') }}" alt="Sepatu Bayi - Pink" class="w-full md:max-w-xs rounded-lg shadow-md transform transition duration-300 hover:scale-105">
      </div>
      <!-- Detail Order -->
      <div class="flex flex-col justify-center">
        <h3 class="text-2xl font-bold text-gray-800 mb-3 flex items-center">
          <i class="fas fa-shoe-prints mr-2 text-pink-500"></i>
          Sepatu Bayi - Pink
        </h3>
        <p class="text-gray-600 mb-2">
          <strong>Order ID:</strong> <span class="font-medium">#23414</span>
        </p>
        <p class="text-gray-600 mb-2">
          <strong>Tanggal:</strong> <span class="font-medium">19 Juli 2024</span>
        </p>
        <p class="text-gray-600 mb-3 flex items-center">
          <strong>Status Pesanan:</strong>
          <span class="ml-2 text-green-600 font-semibold flex items-center">
            <i class="fas fa-check-circle mr-1"></i>
            Selesai
          </span>
        </p>
        <div class="w-full h-1 bg-green-600 rounded"></div>
      </div>
    </div>

    <!-- Informasi Tambahan -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
      <!-- Informasi Pengiriman -->
      <div class="p-4 bg-gray-50 rounded-lg shadow-sm">
        <h4 class="font-semibold text-xl text-gray-800 mb-3 border-b pb-2">
          <i class="fas fa-truck mr-2 text-blue-500"></i>Pengiriman
        </h4>
        <p class="text-gray-600 mb-2">
          <span class="font-medium">Nama:</span> Melati
        </p>
        <p class="text-gray-600">
          <span class="font-medium">Kurir:</span> JNE Reguler
        </p>
      </div>
      <!-- Alamat Pengiriman -->
      <div class="p-4 bg-gray-50 rounded-lg shadow-sm">
        <h4 class="font-semibold text-xl text-gray-800 mb-3 border-b pb-2">
          <i class="fas fa-map-marker-alt mr-2 text-red-500"></i>Alamat
        </h4>
        <p class="text-gray-600">
          Jl. Contoh, No 12, Bogor, Indonesia
        </p>
      </div>
      <!-- Informasi Pembayaran -->
      <div class="p-4 bg-gray-50 rounded-lg shadow-sm">
        <h4 class="font-semibold text-xl text-gray-800 mb-3 border-b pb-2">
          <i class="fas fa-credit-card mr-2 text-purple-500"></i>Pembayaran
        </h4>
        <p class="text-gray-600 mb-2">
          <span class="font-medium">Metode:</span> COD
        </p>
        <p class="text-gray-600">
          <span class="font-medium">Tanggal:</span> 19 Juli 2024
        </p>
      </div>
      <!-- Detail Pembayaran -->
      <div class="p-4 bg-gray-50 rounded-lg shadow-sm">
        <h4 class="font-semibold text-xl text-gray-800 mb-3 border-b pb-2">
          <i class="fas fa-receipt mr-2 text-green-500"></i>Detail Bayar
        </h4>
        <p class="text-gray-600 mb-2">
          <span class="font-medium">No Seri:</span> 1232324335
        </p>
        <p class="text-gray-600 mb-2">
          <span class="font-medium">Total:</span> Rp.44.000
        </p>
        <p class="text-gray-600 flex items-center">
          <span class="font-medium">Status:</span>
          <span id="detailStatusPembayaran" class="ml-2 text-red-600 flex items-center">
            <i class="fas fa-times-circle mr-1"></i>
            BELUM DI BAYAR
          </span>
        </p>
      </div>
    </div>

    <!-- Status Pesanan & Konfirmasi Pembayaran -->
    <div class="bg-yellow-100 p-6 rounded-lg shadow-md w-full md:w-1/2 mx-auto text-center mb-12">
      <h2 class="text-xl font-semibold mb-4 flex items-center justify-center space-x-2">
        <i class="fas fa-info-circle"></i>
        <span>Status Pesanan</span>
      </h2>
      <button id="openPaymentModal" class="w-full bg-yellow-500 text-white font-medium px-4 py-3 rounded hover:bg-yellow-600 transition flex items-center justify-center space-x-2">
        <i class="fas fa-money-check-alt"></i>
        <span>Konfirmasi Pembayaran</span>
      </button>
    </div>

    <!-- Pesan Terima Kasih & Ulasan -->
    <div id="thankYouMsg" class="mt-4 p-6 bg-green-100 border-l-4 border-green-500 text-green-700 rounded hidden">
      <h4 class="font-bold text-xl mb-2 flex items-center">
        <i class="fas fa-smile-beam mr-2"></i>
        Terima Kasih!
      </h4>
      <p class="text-md mb-2">
        Terima kasih telah berbelanja di toko kami. Mohon berikan rating dan ulasan untuk terus meningkatkan pelayanan kami!
      </p>
      <!-- Bagian Rating (contoh menggunakan ikon bintang) -->
      <div class="flex justify-center items-center space-x-1 mb-4">
        <i class="fas fa-star text-yellow-500"></i>
        <i class="fas fa-star text-yellow-500"></i>
        <i class="fas fa-star text-yellow-500"></i>
        <i class="fas fa-star text-yellow-500"></i>
        <i class="fas fa-star-half-alt text-yellow-500"></i>
      </div>
      <a href="#" class="inline-block text-blue-600 font-medium hover:underline">Beri Ulasan Sekarang</a>
    </div>

    <!-- Tombol Navigasi -->
    <div class="flex flex-col sm:flex-row justify-center gap-4 mt-10">
      <button id="lihatBuktiBtn" class="bg-blue-600 text-white font-medium px-6 py-3 rounded shadow hover:bg-blue-700 transition flex items-center space-x-2">
        <i class="fas fa-shipping-fast"></i>
        <span>Lihat Bukti Pengiriman</span>
      </button>
      <button onclick="window.location.href='{{ route('riwayat.pemesanan.pesanan') }}'" class="bg-gray-700 text-white font-medium px-6 py-3 rounded shadow hover:bg-gray-800 transition flex items-center space-x-2">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali ke Riwayat</span>
      </button>
    </div>
  </div>

  <!-- Modal Konfirmasi Pembayaran -->
  <div id="paymentModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/3 overflow-hidden transform transition duration-300">
      <div class="flex justify-between items-center p-4 border-b">
        <h3 class="font-bold text-lg text-gray-800 flex items-center">
          <i class="fas fa-lock mr-2 text-yellow-500"></i>
          Konfirmasi Pembayaran
        </h3>
        <button id="closePaymentModal" class="text-gray-500 hover:text-gray-700 focus:outline-none">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="p-6">
        <label for="paymentCode" class="block text-gray-700 font-medium mb-2">
          Masukkan Kode Pembayaran:
        </label>
        <input type="text" id="paymentCode" class="w-full px-4 py-3 border rounded focus:outline-none focus:ring focus:ring-yellow-300" placeholder="Masukkan kode pembayaran..." />
        <p id="paymentError" class="text-red-500 text-sm mt-2 hidden">
          Kode pembayaran wajib diisi!
        </p>
        <div class="mt-6 flex justify-end">
          <button id="confirmPayment" class="bg-green-500 text-white font-medium px-4 py-2 rounded hover:bg-green-600 transition flex items-center space-x-2">
            <i class="fas fa-check"></i>
            <span>Konfirmasi</span>
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Bukti Pengiriman -->
  <div id="modalBukti" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 lg:w-1/3 overflow-hidden transform transition duration-300">
      <div class="flex justify-between items-center p-4 border-b">
        <h3 class="font-bold text-lg text-gray-800 flex items-center">
          <i class="fas fa-truck mr-2 text-blue-500"></i>
          Bukti Pengiriman
        </h3>
        <button id="modalClose" class="text-gray-500 hover:text-gray-700 focus:outline-none">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="p-6">
        <div class="flex items-center justify-center text-green-500 text-5xl mb-4">
          <i class="fas fa-check-circle"></i>
        </div>
        <img src="{{ asset('/assets/paket.jpeg') }}" alt="Bukti Pengiriman" class="w-full rounded mb-3 transform transition duration-300 hover:scale-105" />
        <p class="text-sm text-gray-600 text-center">
          Pesanan sudah selesai diantar
        </p>
      </div>
    </div>
  </div>

  <!-- JavaScript -->
  <script>
    // KONFIRMASI PEMBAYARAN

    const openPaymentModal = document.getElementById("openPaymentModal");
    const paymentModal = document.getElementById("paymentModal");
    const closePaymentModal = document.getElementById("closePaymentModal");
    const confirmPayment = document.getElementById("confirmPayment");
    const paymentCodeInput = document.getElementById("paymentCode");
    const paymentError = document.getElementById("paymentError");
    const detailStatusPembayaran = document.getElementById("detailStatusPembayaran");
    const thankYouMsg = document.getElementById("thankYouMsg");

    // Cek status pembayaran dari localStorage
    document.addEventListener("DOMContentLoaded", () => {
      const savedPaymentStatus = localStorage.getItem("paymentStatus");
      if (savedPaymentStatus === "LUNAS") {
        detailStatusPembayaran.innerHTML = '<i class="fas fa-check-circle mr-1"></i> LUNAS';
        detailStatusPembayaran.classList.replace("text-red-600", "text-green-600");
        thankYouMsg.classList.remove("hidden");
      }
    });

    // Daftar kode pembayaran valid
    const validPaymentCodes = ["123456", "654321", "789012"];

    // Buka Modal Konfirmasi Pembayaran
    openPaymentModal.addEventListener("click", () => {
      paymentModal.classList.remove("opacity-0", "pointer-events-none");
      paymentModal.classList.add("opacity-100");
    });

    // Tutup Modal Konfirmasi Pembayaran
    closePaymentModal.addEventListener("click", () => {
      paymentModal.classList.replace("opacity-100", "opacity-0");
      paymentModal.classList.add("pointer-events-none");
    });

    // Tutup modal jika klik di luar area modal
    paymentModal.addEventListener("click", (event) => {
      if (event.target === paymentModal) {
        paymentModal.classList.replace("opacity-100", "opacity-0");
        paymentModal.classList.add("pointer-events-none");
      }
    });

    // Konfirmasi Pembayaran
    confirmPayment.addEventListener("click", () => {
      const paymentCode = paymentCodeInput.value.trim();

      if (paymentCode === "") {
        paymentError.textContent = "Kode pembayaran wajib diisi!";
        paymentError.classList.remove("hidden");
        return;
      }

      if (!validPaymentCodes.includes(paymentCode)) {
        paymentError.textContent = "Kode pembayaran tidak valid!";
        paymentError.classList.remove("hidden");
        return;
      }

      paymentError.classList.add("hidden");
      detailStatusPembayaran.innerHTML = '<i class="fas fa-check-circle mr-1"></i> LUNAS';
      detailStatusPembayaran.classList.replace("text-red-600", "text-green-600");
      localStorage.setItem("paymentStatus", "LUNAS");
      thankYouMsg.classList.remove("hidden");

      paymentModal.classList.replace("opacity-100", "opacity-0");
      paymentModal.classList.add("pointer-events-none");
    });

    // MODAL BUKTI PENGIRIMAN

    const modalBukti = document.getElementById('modalBukti');
    const lihatBuktiBtn = document.getElementById('lihatBuktiBtn');
    const modalClose = document.getElementById('modalClose');

    // Buka modal Bukti Pengiriman
    lihatBuktiBtn.addEventListener('click', () => {
      modalBukti.classList.remove('opacity-0', 'pointer-events-none');
      modalBukti.classList.add('opacity-100');
    });

    // Tutup modal Bukti Pengiriman
    modalClose.addEventListener('click', () => {
      modalBukti.classList.replace('opacity-100', 'opacity-0');
      modalBukti.classList.add('pointer-events-none');
    });

    // Tutup modal jika klik di luar konten modal
    window.addEventListener('click', (e) => {
      if (e.target === modalBukti) {
        modalBukti.classList.replace('opacity-100', 'opacity-0');
        modalBukti.classList.add('pointer-events-none');
      }
    });
  </script>
</body>
</html>
</x-navbar>