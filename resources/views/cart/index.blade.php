<x-layout>
  <!DOCTYPE html>
  <html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Keranjang Belanja Android</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
      /* Ripple effect untuk tombol */
      .ripple {
        position: relative;
        overflow: hidden;
      }
      .ripple::after {
        content: "";
        position: absolute;
        width: 5px;
        height: 5px;
        background: rgba(255, 255, 255, 0.7);
        display: block;
        transform: scale(1);
        border-radius: 50%;
        opacity: 0;
        pointer-events: none;
      }
      .ripple:active::after {
        animation: ripple-effect 0.6s linear;
      }
      @keyframes ripple-effect {
        0% {
          opacity: 1;
          transform: scale(0);
        }
        100% {
          opacity: 0;
          transform: scale(20);
        }
      }
    </style>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              primary: '#1E3A8A',
              secondary: '#9333EA',
              accent: '#FF5722'
            },
            animation: {
              'fade-in': 'fadeIn 0.6s ease-out forwards',
              'slide-in': 'slideIn 0.6s ease-out forwards'
            },
            keyframes: {
              fadeIn: {
                '0%': { opacity: 0 },
                '100%': { opacity: 1 }
              },
              slideIn: {
                '0%': { transform: 'translateY(20px)', opacity: 0 },
                '100%': { transform: 'translateY(0)', opacity: 1 }
              }
            }
          }
        }
      }
    </script>
  </head>
  <body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">
    <div class="container mx-auto px-4 py-4 max-w-5xl flex-1">
      <!-- Header -->
      <header class="mb-4">
        <h1 class="text-3xl font-extrabold text-center text-primary animate-fade-in">
          Keranjang Belanja
        </h1>
      </header>
  
      <div class="bg-white rounded-xl shadow-2xl p-4 animate-slide-in">
        <!-- Tombol Pilih Semua -->
        <div class="mb-4 flex items-center gap-2">
          <input type="checkbox" id="select-all" class="w-5 h-5">
          <label for="select-all" class="text-gray-700 font-medium select-none">Pilih Semua</label>
        </div>
  
        <!-- Daftar Produk -->
        <div id="cart-items" class="space-y-4">
          <!-- Contoh Item Produk -->
          <div class="flex flex-col md:flex-row items-center gap-4 border border-gray-200 rounded-lg p-3 hover:bg-gray-100 transition-all duration-300 hover:ring-2 hover:ring-primary"
               data-price="250000" data-quantity="2">
            <input type="checkbox" class="select-product w-5 h-5 mt-1">
            <img src="{{ asset('assets/baby.jpeg') }}" alt="Sepatu Sneakers" class="w-20 h-20 object-cover rounded-lg shadow-md">
            <div class="flex flex-col flex-1">
              <p class="font-bold text-lg">Sepatu Sneakers</p>
              <p class="text-gray-600">Rp 250.000</p>
            </div>
            <div class="flex items-center space-x-2">
              <button class="decrement ripple bg-gray-200 hover:bg-gray-300 px-2 py-1 rounded-md transition">
                <span class="material-icons text-sm">remove</span>
              </button>
              <span class="quantity font-semibold text-lg">2</span>
              <button class="increment ripple bg-gray-200 hover:bg-gray-300 px-2 py-1 rounded-md transition">
                <span class="material-icons text-sm">add</span>
              </button>
            </div>
            <p class="total-price font-bold text-lg">Rp 500.000</p>
            <!-- Tombol Hapus Item -->
            <button class="remove-item ripple text-red-500 hover:text-red-700 font-bold text-2xl p-1">
              <span class="material-icons">delete</span>
            </button>
          </div>
  
          <!-- Produk Kedua -->
          <div class="flex flex-col md:flex-row items-center gap-4 border border-gray-200 rounded-lg p-3 hover:bg-gray-100 transition-all duration-300 hover:ring-2 hover:ring-primary"
               data-price="250000" data-quantity="2">
            <input type="checkbox" class="select-product w-5 h-5 mt-1">
            <img src="{{ asset('assets/baby.jpeg') }}" alt="Sepatu Sneakers" class="w-20 h-20 object-cover rounded-lg shadow-md">
            <div class="flex flex-col flex-1">
              <p class="font-bold text-lg">Sepatu Sneakers</p>
              <p class="text-gray-600">Rp 250.000</p>
            </div>
            <div class="flex items-center space-x-2">
              <button class="decrement ripple bg-gray-200 hover:bg-gray-300 px-2 py-1 rounded-md transition">
                <span class="material-icons text-sm">remove</span>
              </button>
              <span class="quantity font-semibold text-lg">2</span>
              <button class="increment ripple bg-gray-200 hover:bg-gray-300 px-2 py-1 rounded-md transition">
                <span class="material-icons text-sm">add</span>
              </button>
            </div>
            <p class="total-price font-bold text-lg">Rp 500.000</p>
            <!-- Tombol Hapus Item -->
            <button class="remove-item ripple text-red-500 hover:text-red-700 font-bold text-2xl p-1">
              <span class="material-icons">delete</span>
            </button>
          </div>
  
          <!-- Produk Ketiga -->
          <div class="flex flex-col md:flex-row items-center gap-4 border border-gray-200 rounded-lg p-3 hover:bg-gray-100 transition-all duration-300 hover:ring-2 hover:ring-primary"
               data-price="250000" data-quantity="2">
            <input type="checkbox" class="select-product w-5 h-5 mt-1">
            <img src="{{ asset('assets/baby.jpeg') }}" alt="Sepatu Sneakers" class="w-20 h-20 object-cover rounded-lg shadow-md">
            <div class="flex flex-col flex-1">
              <p class="font-bold text-lg">Sepatu Sneakers</p>
              <p class="text-gray-600">Rp 250.000</p>
            </div>
            <div class="flex items-center space-x-2">
              <button class="decrement ripple bg-gray-200 hover:bg-gray-300 px-2 py-1 rounded-md transition">
                <span class="material-icons text-sm">remove</span>
              </button>
              <span class="quantity font-semibold text-lg">2</span>
              <button class="increment ripple bg-gray-200 hover:bg-gray-300 px-2 py-1 rounded-md transition">
                <span class="material-icons text-sm">add</span>
              </button>
            </div>
            <p class="total-price font-bold text-lg">Rp 500.000</p>
            <!-- Tombol Hapus Item -->
            <button class="remove-item ripple text-red-500 hover:text-red-700 font-bold text-2xl p-1">
              <span class="material-icons">delete</span>
            </button>
          </div>
          <!-- Tambahkan produk lain dengan struktur yang sama -->
        </div>
  
        <!-- Ringkasan Pembayaran -->
        <div class="mt-6 bg-gray-100 rounded-xl p-4">
          <div class="flex justify-between items-center text-lg font-semibold">
            <span>Total Harga</span>
            <span id="total-harga">Rp 0</span>
          </div>
          <div class="flex justify-between items-center text-gray-600 mt-2">
            <span>Ongkos Kirim</span>
            <span id="ongkir">Rp 20.000</span>
          </div>
          <hr class="my-4 border-gray-300">
          <div class="flex justify-between items-center text-2xl font-bold text-primary">
            <span>Total Bayar</span>
            <span id="total-bayar">Rp 0</span>
          </div>
        </div>
  
        <!-- Tombol Checkout -->
        <button id="checkout-button" class="mt-6 w-full bg-primary ripple hover:bg-blue-900 transition duration-300 py-3 rounded-lg text-white font-bold shadow-xl">
          CHECKOUT
        </button>
      </div>
    </div>
  
    <!-- Script JavaScript -->
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const cartItems = document.getElementById('cart-items');
        const totalHargaElement = document.getElementById('total-harga');
        const totalBayarElement = document.getElementById('total-bayar');
        const checkoutButton = document.getElementById('checkout-button');
        const selectAllCheckbox = document.getElementById('select-all');
        const ongkir = 20000;
  
        function updateTotal() {
          let totalHarga = 0;
          cartItems.querySelectorAll('.select-product:checked').forEach(checkbox => {
            const item = checkbox.closest('[data-price]');
            const price = parseInt(item.getAttribute('data-price'));
            const quantity = parseInt(item.getAttribute('data-quantity'));
            totalHarga += price * quantity;
            // Tambahkan highlight pada item yang dipilih
            item.classList.add('ring-2', 'ring-secondary');
          });
          // Hapus highlight pada yang tidak dipilih
          cartItems.querySelectorAll('.select-product:not(:checked)').forEach(checkbox => {
            const item = checkbox.closest('[data-price]');
            item.classList.remove('ring-2', 'ring-secondary');
          });
  
          totalHargaElement.textContent = `Rp ${totalHarga.toLocaleString()}`;
          totalBayarElement.textContent = `Rp ${(totalHarga > 0 ? totalHarga + ongkir : 0).toLocaleString()}`;
        }
  
        // Pilih Semua Produk
        selectAllCheckbox.addEventListener('change', () => {
          const allCheckboxes = cartItems.querySelectorAll('.select-product');
          allCheckboxes.forEach(cb => cb.checked = selectAllCheckbox.checked);
          updateTotal();
        });
  
        cartItems.addEventListener('click', function (e) {
          const item = e.target.closest('[data-price]');
          // Increment & Decrement Quantity
          if (e.target.closest('.increment') || e.target.closest('.decrement')) {
            let quantity = parseInt(item.getAttribute('data-quantity'));
  
            if (e.target.closest('.increment')) {
              quantity++;
            } else if (e.target.closest('.decrement') && quantity > 1) {
              quantity--;
            }
  
            item.setAttribute('data-quantity', quantity);
            const quantitySpan = item.querySelector('.quantity');
            quantitySpan.textContent = quantity;
  
            // Animasi jumlah yang diupdate
            quantitySpan.classList.add('animate-ping');
            setTimeout(() => {
              quantitySpan.classList.remove('animate-ping');
            }, 300);
  
            const price = parseInt(item.getAttribute('data-price'));
            item.querySelector('.total-price').textContent = `Rp ${(price * quantity).toLocaleString()}`;
  
            updateTotal();
  
            // Tampilkan Toast Notifikasi
            Swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'success',
              title: 'Jumlah diperbarui',
              showConfirmButton: false,
              timer: 800,
              timerProgressBar: true
            });
          }
  
          // Seleksi item
          if (e.target.classList.contains('select-product')) {
            updateTotal();
          }
  
          // Hapus item
          if (e.target.closest('.remove-item')) {
            Swal.fire({
              title: 'Anda yakin ingin menghapus item ini?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#d33',
              cancelButtonColor: '#3085d6',
              confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
              if (result.isConfirmed) {
                item.remove();
                updateTotal();
                Swal.fire({
                  icon: 'success',
                  title: 'Item terhapus',
                  showConfirmButton: false,
                  timer: 800
                });
              }
            });
          }
        });
  
        // Checkout button
        checkoutButton.addEventListener('click', function () {
          const selectedProducts = document.querySelectorAll('.select-product:checked');
  
          if (selectedProducts.length === 0) {
            Swal.fire({
              icon: 'warning',
              title: 'Pilih Produk Terlebih Dahulu!',
              text: 'Silakan centang produk yang ingin dibeli sebelum checkout.',
            });
            return;
          }
  
          Swal.fire({
            title: 'Konfirmasi Checkout',
            text: 'Apa benar ini produk yang Anda pilih? Periksa kembali.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Benar',
            cancelButtonText: 'Cek Kembali'
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire({
                title: 'Memproses...',
                timer: 1500,
                didOpen: () => {
                  Swal.showLoading();
                },
                willClose: () => {
                  window.location.href = "{{ route('cekot.index') }}";
                }
              });
            }
          });
        });
  
        // Inisialisasi total harga saat halaman dimuat
        updateTotal();
      });
    </script>
  </body>
  </html>
</x-layout>
