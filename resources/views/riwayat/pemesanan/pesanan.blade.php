<x-navbar>
<!DOCTYPE html>
<html lang="id" x-data="{ tab: 'all' }">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Riwayat Pemesanan</title>
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
  />
  <!-- Alpine.js -->
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100">

  <!-- Container Utama -->
  <!-- Di mobile, kita kecilkan padding-vertical menjadi py-4, sedangkan di desktop tetap lebar (py-10). -->
  <div class="container mx-auto px-4 py-4 md:py-10">
    <!-- Judul Halaman -->
    <h1 class="text-2xl md:text-4xl font-bold text-center text-gray-800 mb-6">
      Riwayat Pemesanan
    </h1>
    
    <!-- Tombol Kategori -->
    <!-- Tetap mempertahankan warna-warni tombol seperti semula, hanya menyesuaikan spacing (gap) -->
    <div class="flex flex-wrap items-center justify-center gap-2 md:gap-4 mb-6">
      <button
        class="px-5 py-2 text-sm md:text-base bg-yellow-400 text-white font-semibold rounded shadow hover:bg-yellow-500 focus:outline-none transition"
        @click="tab = 'dikemas'"
      >
        <i class="fas fa-box mr-1 md:mr-2"></i> Dikemas
      </button>
      <button
        class="px-5 py-2 text-sm md:text-base bg-blue-400 text-white font-semibold rounded shadow hover:bg-blue-500 focus:outline-none transition"
        @click="tab = 'diproses'"
      >
        <i class="fas fa-spinner mr-1 md:mr-2"></i> Diproses
      </button>
      <button
        class="px-5 py-2 text-sm md:text-base bg-purple-400 text-white font-semibold rounded shadow hover:bg-purple-500 focus:outline-none transition"
        @click="tab = 'dikirim'"
      >
        <i class="fas fa-shipping-fast mr-1 md:mr-2"></i> Dikirim
      </button>
      <button
        class="px-5 py-2 text-sm md:text-base bg-green-400 text-white font-semibold rounded shadow hover:bg-green-500 focus:outline-none transition"
        @click="tab = 'selesai'"
      >
        <i class="fas fa-check-circle mr-1 md:mr-2"></i> Selesai
      </button>
      <button
        class="px-5 py-2 text-sm md:text-base bg-gray-500 text-white font-semibold rounded shadow hover:bg-gray-600 focus:outline-none transition"
        @click="tab = 'all'"
      >
        <i class="fas fa-list mr-1 md:mr-2"></i> Semua
      </button>
    </div>
    
    <!-- Daftar Pesanan (Semua) -->
    <div class="space-y-4 md:space-y-6" x-show="tab === 'all'">
      <!-- CARD 1 -->
      <!-- Di mobile: p-4, flex-col. Di desktop: p-6, flex-row -->
      <div class="bg-white rounded-lg shadow-md p-4 md:p-6 flex flex-col md:flex-row items-start md:items-center justify-between">
        <div class="flex items-start md:items-center">
          <!-- Gambar di-mobile lebih kecil: w-20 h-20; di-desktop: w-24 h-24 -->
          <img
            src="{{ asset('assets/baby.jpeg') }}"
            alt="Sepatu Bayi - Pink"
            class="w-20 h-20 md:w-24 md:h-24 rounded-lg object-cover mr-4 md:mr-6"
          />
          <div>
            <h2 class="text-lg md:text-xl font-bold text-gray-700 flex items-center">
              <i class="fas fa-shoe-prints text-pink-500 mr-2"></i> Sepatu Bayi - Pink
            </h2>
            <p class="text-gray-500 text-sm md:text-base mt-1">
              Order ID: <span class="font-semibold">#123445</span>
            </p>
            <p class="text-gray-500 text-sm md:text-base mt-1">
              Tanggal: <span class="font-semibold">12 Juli 2024</span>
            </p>
            <a
              href="{{ route('riwayat.pemesanan.detail') }}"
              class="text-blue-500 hover:underline mt-2 inline-flex items-center text-sm md:text-base"
            >
              <i class="fas fa-info-circle mr-1"></i> Lihat detail
            </a>
          </div>
        </div>
        <!-- Spasi atas di mobile -->
        <div class="mt-4 md:mt-0 text-right">
          <p class="text-gray-500 flex items-center justify-end text-sm md:text-base">
            <i class="fas fa-check-circle text-green-500 text-xl mr-2"></i>
            <span class="font-bold text-green-500">Selesai</span>
          </p>
          <p class="text-blue-500 font-bold text-lg md:text-2xl mt-1 md:mt-2">
            <i class="fas fa-tag mr-2"></i>Rp. 44.000
          </p>
          <p class="text-gray-500 text-sm md:text-base mt-1">
            <i class="fas fa-credit-card mr-1"></i> COD
          </p>
        </div>
      </div>
      
      <!-- CARD 2 -->
      <div class="bg-white rounded-lg shadow-md p-4 md:p-6 flex flex-col md:flex-row items-start md:items-center justify-between">
        <div class="flex items-start md:items-center">
          <img
            src="{{ asset('assets/baby.jpeg') }}"
            alt="Sepatu Anak - Biru"
            class="w-20 h-20 md:w-24 md:h-24 rounded-lg object-cover mr-4 md:mr-6"
          />
          <div>
            <h2 class="text-lg md:text-xl font-bold text-gray-700 flex items-center">
              <i class="fas fa-shoe-prints text-blue-500 mr-2"></i> Sepatu Anak - Biru
            </h2>
            <p class="text-gray-500 text-sm md:text-base mt-1">
              Order ID: <span class="font-semibold">#123446</span>
            </p>
            <p class="text-gray-500 text-sm md:text-base mt-1">
              Tanggal: <span class="font-semibold">15 Juli 2024</span>
            </p>
            <a
              href="{{ route('riwayat.pemesanan.detail') }}"
              class="text-blue-500 hover:underline mt-2 inline-flex items-center text-sm md:text-base"
            >
              <i class="fas fa-info-circle mr-1"></i> Lihat detail
            </a>
          </div>
        </div>
        <div class="mt-4 md:mt-0 text-right">
          <p class="text-gray-500 flex items-center justify-end text-sm md:text-base">
            <i class="fas fa-spinner text-yellow-500 text-xl animate-spin mr-2"></i>
            <span class="font-bold text-yellow-500">Diproses</span>
          </p>
          <p class="text-blue-500 font-bold text-lg md:text-2xl mt-1 md:mt-2">
            <i class="fas fa-tag mr-2"></i>Rp. 65.000
          </p>
          <p class="text-gray-500 text-sm md:text-base mt-1">
            <i class="fas fa-university mr-1"></i> Transfer Bank
          </p>
        </div>
      </div>
      
      <!-- CARD 3 -->
      <div class="bg-white rounded-lg shadow-md p-4 md:p-6 flex flex-col md:flex-row items-start md:items-center justify-between">
        <div class="flex items-start md:items-center">
          <img
            src="{{ asset('assets/baby.jpeg') }}"
            alt="Mainan Edukasi Anak"
            class="w-20 h-20 md:w-24 md:h-24 rounded-lg object-cover mr-4 md:mr-6"
          />
          <div>
            <h2 class="text-lg md:text-xl font-bold text-gray-700 flex items-center">
              <i class="fas fa-book-reader text-purple-500 mr-2"></i> Mainan Edukasi Anak
            </h2>
            <p class="text-gray-500 text-sm md:text-base mt-1">
              Order ID: <span class="font-semibold">#123447</span>
            </p>
            <p class="text-gray-500 text-sm md:text-base mt-1">
              Tanggal: <span class="font-semibold">18 Juli 2024</span>
            </p>
            <a
              href="{{ route('riwayat.pemesanan.detail') }}"
              class="text-blue-500 hover:underline mt-2 inline-flex items-center text-sm md:text-base"
            >
              <i class="fas fa-info-circle mr-1"></i> Lihat detail
            </a>
          </div>
        </div>
        <div class="mt-4 md:mt-0 text-right">
          <p class="text-gray-500 flex items-center justify-end text-sm md:text-base">
            <i class="fas fa-times-circle text-red-500 text-xl mr-2"></i>
            <span class="font-bold text-red-500">Dibatalkan</span>
          </p>
          <p class="text-blue-500 font-bold text-lg md:text-2xl mt-1 md:mt-2">
            <i class="fas fa-tag mr-2"></i>Rp. 30.000
          </p>
          <p class="text-gray-500 text-sm md:text-base mt-1">
            <i class="fas fa-credit-card mr-1"></i> Kartu Kredit
          </p>
        </div>
      </div>
      
      <!-- CARD 4 -->
      <div class="bg-white rounded-lg shadow-md p-4 md:p-6 flex flex-col md:flex-row items-start md:items-center justify-between">
        <div class="flex items-start md:items-center">
          <img
            src="{{ asset('assets/baby.jpeg') }}"
            alt="Tas Sekolah Anak"
            class="w-20 h-20 md:w-24 md:h-24 rounded-lg object-cover mr-4 md:mr-6"
          />
          <div>
            <h2 class="text-lg md:text-xl font-bold text-gray-700 flex items-center">
              <i class="fas fa-school text-green-500 mr-2"></i> Tas Sekolah Anak
            </h2>
            <p class="text-gray-500 text-sm md:text-base mt-1">
              Order ID: <span class="font-semibold">#123448</span>
            </p>
            <p class="text-gray-500 text-sm md:text-base mt-1">
              Tanggal: <span class="font-semibold">20 Juli 2024</span>
            </p>
            <a
              href="{{ route('riwayat.pemesanan.detail') }}"
              class="text-blue-500 hover:underline mt-2 inline-flex items-center text-sm md:text-base"
            >
              <i class="fas fa-info-circle mr-1"></i> Lihat detail
            </a>
          </div>
        </div>
        <div class="mt-4 md:mt-0 text-right">
          <p class="text-gray-500 flex items-center justify-end text-sm md:text-base">
            <i class="fas fa-check-circle text-green-500 text-xl mr-2"></i>
            <span class="font-bold text-green-500">Selesai</span>
          </p>
          <p class="text-blue-500 font-bold text-lg md:text-2xl mt-1 md:mt-2">
            <i class="fas fa-tag mr-2"></i>Rp. 120.000
          </p>
          <p class="text-gray-500 text-sm md:text-base mt-1">
            <i class="fas fa-mobile-alt mr-1"></i> e-Wallet
          </p>
        </div>
      </div>
    </div>
    
    <!-- Kategori: Dikemas -->
    <div class="space-y-4 md:space-y-6" x-show="tab === 'dikemas'">
      <!-- Contoh Pesanan Dikemas -->
      <div class="bg-white rounded-lg shadow-md p-4 md:p-6 flex flex-col md:flex-row items-start md:items-center justify-between">
        <div class="flex items-start md:items-center">
          <img
            src="{{ asset('assets/baby.jpeg') }}"
            alt="Contoh Produk Dikemas"
            class="w-20 h-20 md:w-24 md:h-24 rounded-lg object-cover mr-4 md:mr-6"
          />
          <div>
            <h2 class="text-lg md:text-xl font-bold text-gray-700 flex items-center">
              <i class="fas fa-box-open text-yellow-500 mr-2"></i> Contoh Produk Dikemas
            </h2>
            <p class="text-gray-500 text-sm md:text-base mt-1">
              Order ID: <span class="font-semibold">#999999</span>
            </p>
            <p class="text-gray-500 text-sm md:text-base mt-1">
              Tanggal: <span class="font-semibold">1 Agustus 2024</span>
            </p>
            <a
              href="{{ route('riwayat.pemesanan.detail') }}"
              class="text-blue-500 hover:underline mt-2 inline-flex items-center text-sm md:text-base"
            >
              <i class="fas fa-info-circle mr-1"></i> Lihat detail
            </a>
          </div>
        </div>
        <div class="mt-4 md:mt-0 text-right">
          <p class="text-gray-500 flex items-center justify-end text-sm md:text-base">
            <i class="fas fa-box text-yellow-400 text-xl mr-2"></i>
            <span class="font-bold text-yellow-500">Dikemas</span>
          </p>
          <p class="text-blue-500 font-bold text-lg md:text-2xl mt-1 md:mt-2">
            <i class="fas fa-tag mr-2"></i>Rp. 50.000
          </p>
          <p class="text-gray-500 text-sm md:text-base mt-1">
            <i class="fas fa-wallet mr-1"></i> COD
          </p>
        </div>
      </div>
    </div>
    
    <!-- Kategori: Diproses -->
    <div class="space-y-4 md:space-y-6" x-show="tab === 'diproses'">
      <!-- Contoh Pesanan Diproses -->
      <div class="bg-white rounded-lg shadow-md p-4 md:p-6 flex flex-col md:flex-row items-start md:items-center justify-between">
        <div class="flex items-start md:items-center">
          <img
            src="{{ asset('assets/baby.jpeg') }}"
            alt="Sepatu Anak - Biru"
            class="w-20 h-20 md:w-24 md:h-24 rounded-lg object-cover mr-4 md:mr-6"
          />
          <div>
            <h2 class="text-lg md:text-xl font-bold text-gray-700 flex items-center">
              <i class="fas fa-shoe-prints text-blue-500 mr-2"></i> Sepatu Anak - Biru
            </h2>
            <p class="text-gray-500 text-sm md:text-base mt-1">
              Order ID: <span class="font-semibold">#123446</span>
            </p>
            <p class="text-gray-500 text-sm md:text-base mt-1">
              Tanggal: <span class="font-semibold">15 Juli 2024</span>
            </p>
            <a
              href="{{ route('riwayat.pemesanan.detail') }}"
              class="text-blue-500 hover:underline mt-2 inline-flex items-center text-sm md:text-base"
            >
              <i class="fas fa-info-circle mr-1"></i> Lihat detail
            </a>
          </div>
        </div>
        <div class="mt-4 md:mt-0 text-right">
          <p class="text-gray-500 flex items-center justify-end text-sm md:text-base">
            <i class="fas fa-spinner text-yellow-500 text-xl animate-spin mr-2"></i>
            <span class="font-bold text-yellow-500">Diproses</span>
          </p>
          <p class="text-blue-500 font-bold text-lg md:text-2xl mt-1 md:mt-2">
            <i class="fas fa-tag mr-2"></i>Rp. 65.000
          </p>
          <p class="text-gray-500 text-sm md:text-base mt-1">
            <i class="fas fa-university mr-1"></i> Transfer Bank
          </p>
        </div>
      </div>
    </div>
    
    <!-- Kategori: Dikirim -->
    <div class="space-y-4 md:space-y-6" x-show="tab === 'dikirim'">
      <!-- Contoh Pesanan Dikirim -->
      <div class="bg-white rounded-lg shadow-md p-4 md:p-6 flex flex-col md:flex-row items-start md:items-center justify-between">
        <div class="flex items-start md:items-center">
          <img
            src="{{ asset('assets/baby.jpeg') }}"
            alt="Contoh Produk Dikirim"
            class="w-20 h-20 md:w-24 md:h-24 rounded-lg object-cover mr-4 md:mr-6"
          />
          <div>
            <h2 class="text-lg md:text-xl font-bold text-gray-700 flex items-center">
              <i class="fas fa-shipping-fast text-purple-500 mr-2"></i> Contoh Produk Dikirim
            </h2>
            <p class="text-gray-500 text-sm md:text-base mt-1">
              Order ID: <span class="font-semibold">#888888</span>
            </p>
            <p class="text-gray-500 text-sm md:text-base mt-1">
              Tanggal: <span class="font-semibold">5 Agustus 2024</span>
            </p>
            <a
              href="{{ route('riwayat.pemesanan.detail') }}"
              class="text-blue-500 hover:underline mt-2 inline-flex items-center text-sm md:text-base"
            >
              <i class="fas fa-info-circle mr-1"></i> Lihat detail
            </a>
          </div>
        </div>
        <div class="mt-4 md:mt-0 text-right">
          <p class="text-gray-500 flex items-center justify-end text-sm md:text-base">
            <i class="fas fa-shipping-fast text-purple-500 text-xl mr-2"></i>
            <span class="font-bold text-purple-500">Dikirim</span>
          </p>
          <p class="text-blue-500 font-bold text-lg md:text-2xl mt-1 md:mt-2">
            <i class="fas fa-tag mr-2"></i>Rp. 75.000
          </p>
          <p class="text-gray-500 text-sm md:text-base mt-1">
            <i class="fas fa-truck-moving mr-1"></i> Jasa Kurir
          </p>
        </div>
      </div>
    </div>
    
    <!-- Kategori: Selesai -->
    <div class="space-y-4 md:space-y-6" x-show="tab === 'selesai'">
      <!-- Contoh Pesanan Selesai -->
      <div class="bg-white rounded-lg shadow-md p-4 md:p-6 flex flex-col md:flex-row items-start md:items-center justify-between">
        <div class="flex items-start md:items-center">
          <img
            src="{{ asset('assets/baby.jpeg') }}"
            alt="Sepatu Bayi - Pink"
            class="w-20 h-20 md:w-24 md:h-24 rounded-lg object-cover mr-4 md:mr-6"
          />
          <div>
            <h2 class="text-lg md:text-xl font-bold text-gray-700 flex items-center">
              <i class="fas fa-shoe-prints text-pink-500 mr-2"></i> Sepatu Bayi - Pink
            </h2>
            <p class="text-gray-500 text-sm md:text-base mt-1">
              Order ID: <span class="font-semibold">#123445</span>
            </p>
            <p class="text-gray-500 text-sm md:text-base mt-1">
              Tanggal: <span class="font-semibold">12 Juli 2024</span>
            </p>
            <a
              href="{{ route('riwayat.pemesanan.detail') }}"
              class="text-blue-500 hover:underline mt-2 inline-flex items-center text-sm md:text-base"
            >
              <i class="fas fa-info-circle mr-1"></i> Lihat detail
            </a>
          </div>
        </div>
        <div class="mt-4 md:mt-0 text-right">
          <p class="text-gray-500 flex items-center justify-end text-sm md:text-base">
            <i class="fas fa-check-circle text-green-500 text-xl mr-2"></i>
            <span class="font-bold text-green-500">Selesai</span>
          </p>
          <p class="text-blue-500 font-bold text-lg md:text-2xl mt-1 md:mt-2">
            <i class="fas fa-tag mr-2"></i>Rp. 44.000
          </p>
          <p class="text-gray-500 text-sm md:text-base mt-1">
            <i class="fas fa-credit-card mr-1"></i> COD
          </p>
        </div>
      </div>
    </div>

  </div>
</body>
</html>
</x-navbar>
