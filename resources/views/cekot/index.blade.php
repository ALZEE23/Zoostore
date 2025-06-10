<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chekout</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                fontFamily: {
                    sans: ['Inter', 'ui-sans-serif', 'system-ui'],
                },
                extend: {
                    colors: {
                        brand: {
                            DEFAULT: '#FA734C',
                            light: '#FFF3EF',
                            dark: '#E05A3C'
                        }
                    },
                    animation: {
                        'pulse-slow': 'pulse 2s ease-in-out infinite'
                    }
                }
            }
        }
    </script>
    <meta name="theme-color" content="#FA734C" />
</head>

<body class="bg-gray-50 text-gray-800 font-sans leading-relaxed">
    <header class="sticky top-0 bg-white border-b shadow z-50">
        <div class="max-w-7xl mx-auto flex items-center px-6 py-4">
            <button onclick="history.back()" aria-label="Kembali"
                class="p-2 hover:bg-gray-100 rounded-lg transition-transform hover:scale-110">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <h1 class="ml-4 text-2xl font-semibold text-gray-700">Konfirmasi Pesanan</h1>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
        <section class="lg:col-span-2 space-y-10">

            <div class="bg-white rounded-2xl shadow-lg p-6 space-y-6">
                <h2 class="text-xl font-semibold text-gray-800 border-b pb-3">Daftar Produk</h2>
                <div class="divide-y divide-gray-200">
                    @foreach ($items as $item)
                        <article
                            class="flex flex-col sm:flex-row items-center py-6 hover:shadow-xl transition-transform transform hover:scale-105 rounded-lg bg-gray-50">
                            <img src="{{ asset('storage/' . $item->product->photo) }}" alt="Produk Contoh"
                                class="w-32 h-32 sm:w-36 sm:h-36 rounded-lg object-cover object-center" />
                            <div class="flex-1 px-6 mt-4 sm:mt-0">
                                <h3 class="text-lg font-semibold text-gray-700 hover:text-brand transition">
                                    {{ $item->product->name }}
                                </h3>
                            </div>
                            <div class="text-right mt-4 sm:mt-0">
                                <p class="text-xl font-bold text-gray-900">Rp
                                    {{ number_format($item->product->harga_diskon * $item->quantity, 2) }}
                                </p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h2 class="text-xl font-semibold text-gray-800 border-b pb-3">Alamat Pengiriman</h2>
                <div class="mt-6 space-y-4">
                    <h2 class="text-lg font-medium text-gray-700">Cek Ongkir</h2>
                    <h3 class="text-lg font-medium text-gray-700">Kota Asal</h3>

                    <form id="checkCostForm" class="space-y-4">
                        @csrf
                        <input type="hidden" name="selected_items" value="{{ json_encode($items->pluck('id')) }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kota Asal</label>
                                <select name="origin" id="origin"
                                    class="mt-1 block w-full rounded-md border-gray-300" required>
                                    <option value="">Pilih Kota Asal</option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city['city_id'] }}">{{ $city['city_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kota Tujuan</label>
                                <select name="destination" id="destination"
                                    class="mt-1 block w-full rounded-md border-gray-300" required>
                                    <option value="">Pilih Kota Tujuan</option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city['city_id'] }}">{{ $city['city_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kurir</label>
                                <select name="courier" id="courier"
                                    class="mt-1 block w-full rounded-md border-gray-300" required>
                                    <option value="">Pilih Kurir</option>
                                    <option value="jne">JNE</option>
                                    <option value="pos">POS</option>
                                    <option value="tiki">TIKI</option>
                                </select>
                            </div>

                            <input type="hidden" name="weight" value="1000">
                        </div>

                        <button type="button" onclick="checkShippingCost()"
                            class="w-full bg-black text-white py-2 rounded-lg">
                            Cek Ongkir
                        </button>
                    </form>

                    <div id="shippingOptions" class="mt-4 hidden">
                        </div>

                    {{-- Kita tidak lagi menggunakan @if (!empty($costs)) di sini karena form akan di-handle oleh JavaScript --}}
                    {{-- Pastikan orderForm terpisah dari checkCostForm dan memiliki ID unik --}}
                </div>
            </div>

            <div id="total-akhir" class="mt-4 text-lg font-bold text-gray-800"></div>
            </div>
        </section>

        <aside class="space-y-6">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Ringkasan Harga</h2>
                <dl class="space-y-2 text-sm text-gray-600">
                    <div class="flex justify-between">
                        <dt>Subtotal</dt>
                        <dd id="subtotal">Rp {{ number_format($subtotal ?? 0, 0, ',', '.') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt>Ongkir</dt>
                        <dd id="shippingCost">Rp 0</dd>
                    </div>
                </dl>
                <div class="border-t mt-4 pt-4 flex justify-between items-center">
                    <span class="font-medium text-gray-800">Total</span>
                    <span class="text-2xl font-bold text-gray-900" id="totalPrice" data-raw="{{ $subtotal ?? 0 }}">
                        Rp {{ number_format($subtotal ?? 0, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            <form id="orderForm" action="{{ route('cekot.store') }}" method="POST" enctype="multipart/form-data" class="hidden"> {{-- Tambahkan class hidden di awal --}}
                @csrf
                <input type="hidden" name="selected_items" value="{{ json_encode($items->pluck('id')) }}">
                <input type="hidden" name="shipping_cost" id="shippingCostInput">
                <input type="hidden" name="courier" id="courierInput">
                <input type="hidden" name="service" id="serviceInput">
                <input type="hidden" name="destination" id="destinationInput">
                <input type="hidden" name="gross_amount" id="grossAmountInput"> {{-- Tambah input hidden untuk gross_amount --}}
                <input type="hidden" name="payment_method_selected" id="paymentMethodSelected">

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                    <textarea name="alamat" class="mt-1 block w-full rounded-md border-gray-300" required></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                    <textarea name="masukan" class="mt-1 block w-full rounded-md border-gray-300"></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                    <select name="payment_method" id="paymentMethod"
                        class="mt-1 block w-full rounded-md border-gray-300" required
                        onchange="togglePaymentMethod()">
                        <option value="">Pilih Metode Pembayaran</option>
                        <option value="qris">QRIS (COD)</option> {{-- Mengganti 'cod' menjadi 'qris' sesuai kebutuhan Anda --}}
                        <option value="midtrans">Midtrans</option>
                    </select>

                    <div id="qrCodeContainer" class="hidden mt-4">
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <p class="text-sm text-gray-600 mb-2">Scan QR Code untuk pembayaran:</p>
                            <img src="{{ asset('asset-landing-admin/qris/qris.jpg') }}" alt="QR Code"
                                class="mx-auto w-48 h-48">
                            <p class="text-xs text-gray-500 mt-2 text-center">Silakan scan QR Code ini untuk melakukan
                                pembayaran QRIS</p>
                            <div class="mb-3">
                                <label for="payment_photo" class="form-label text-sm">Upload Bukti Pembayaran</label>
                                <input type="file" class="form-control" name="payment_photo" id="payment_photo"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" id="pay-button" onclick="submitOrder()"
                    class="w-full bg-black text-white py-3 rounded-2xl font-semibold transition">
                    Bayar Sekarang
                </button>
            </form>
        </aside>
    </main>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.clientKey') }}"></script> {{-- Ambil clientKey dari config --}}
    <script type="text/javascript">
        function togglePaymentMethod() {
            const paymentMethod = document.getElementById('paymentMethod').value;
            // Sesuaikan class hidden untuk qrCodeContainer
            document.getElementById('qrCodeContainer').classList.toggle('hidden', paymentMethod !== 'qris');
            // Sesuaikan required attribute untuk payment_photo
            document.getElementById('payment_photo').required = (paymentMethod === 'qris');
        }

        async function checkShippingCost() {
            const form = document.getElementById('checkCostForm');
            const formData = new FormData(form);

            const origin = document.getElementById('origin').value;
            const destination = document.getElementById('destination').value;
            const courier = document.getElementById('courier').value;

            if (!origin || !destination || !courier) {
                Swal.fire('Informasi', 'Harap lengkapi semua pilihan ongkir.', 'warning');
                return;
            }

            // Store selected values in hidden inputs
            document.getElementById('destinationInput').value = destination;
            document.getElementById('courierInput').value = courier;

            try {
                const response = await fetch('{{ route('checkCost') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const result = await response.json();

                if (result.status === 'success') {
                    const shippingOptions = document.getElementById('shippingOptions');
                    shippingOptions.innerHTML = `
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Pilih Layanan</label>
                            <select id="service" name="service" class="mt-1 block w-full rounded-md border-gray-300" onchange="updateTotal()">
                                <option value="">Pilih Layanan</option>
                                ${result.data.map(service => `
                                    <option value="${service.service}" data-cost="${service.cost[0].value}">
                                        ${service.service} - Rp ${new Intl.NumberFormat('id-ID').format(service.cost[0].value)}
                                        (ETD: ${service.cost[0].etd} hari)
                                    </option>
                                `).join('')}
                            </select>
                        </div>
                    `;
                    shippingOptions.classList.remove('hidden');

                    // Show the order form after shipping options are loaded
                    document.getElementById('orderForm').classList.remove('hidden');
                    updateTotal(); // Panggil updateTotal untuk menginisialisasi total
                } else {
                    Swal.fire('Error', result.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire('Error', 'Terjadi kesalahan saat mengecek ongkir', 'error');
            }
        }

        function updateTotal() {
            const subtotal = {{ $subtotal ?? 0 }};
            const serviceSelect = document.getElementById('service');
            const shippingCost = parseInt(serviceSelect.options[serviceSelect.selectedIndex].dataset.cost || 0);
            const total = subtotal + shippingCost;

            // Update hidden inputs
            document.getElementById('serviceInput').value = serviceSelect.value;
            document.getElementById('shippingCostInput').value = shippingCost; // Hanya ongkir saja
            document.getElementById('grossAmountInput').value = total; // Total keseluruhan (subtotal + ongkir)

            // Update price display
            document.getElementById('shippingCost').innerText = formatRupiah(shippingCost);
            document.getElementById('totalPrice').innerText = formatRupiah(total);
            document.getElementById('totalPrice').setAttribute('data-raw', total); // Update data-raw juga
        }

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(number);
        }

        async function submitOrder() {
            const paymentMethod = document.getElementById('paymentMethod').value;
            const totalPrice = parseInt(document.getElementById('totalPrice').getAttribute('data-raw'));
            const orderForm = document.getElementById('orderForm');

            if (paymentMethod === '') {
                Swal.fire('Informasi', 'Silakan pilih metode pembayaran terlebih dahulu.', 'warning');
                return;
            }

            if (paymentMethod === 'midtrans') {
                // Pastikan semua input form sudah terisi sebelum request token Midtrans
                const alamat = document.querySelector('textarea[name="alamat"]').value;
                if (!alamat) {
                    Swal.fire('Validasi', 'Alamat lengkap harus diisi.', 'warning');
                    return;
                }

                // Buat FormData untuk mengirim data ke getSnapToken
                const formData = new FormData(orderForm);
                formData.set('gross_amount', totalPrice); // Set gross_amount

                // Kirim data ke endpoint untuk mendapatkan snap token
                try {
                    const response = await fetch("{{ route('checkout.token') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": '{{ csrf_token() }}',
                            // 'Content-Type': 'application/json' // Tidak perlu jika menggunakan FormData
                        },
                        body: formData // Kirim FormData
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.message || 'Gagal mendapatkan Snap Token.');
                    }

                    // Panggil Snap.js setelah mendapatkan token
                    snap.pay(data.token, {
                        onSuccess: function(result) {
                            console.log('Success:', result);
                            document.getElementById('paymentMethodSelected').value = 'midtrans';
                            // Setelah pembayaran sukses di Midtrans, submit form ke cekot.store
                            orderForm.submit();
                        },
                        onPending: function(result) {
                            console.log('Pending:', result);
                            document.getElementById('paymentMethodSelected').value = 'midtrans';
                            // Jika pending, Anda mungkin ingin tetap submit form untuk mencatat pesanan
                            orderForm.submit();
                        },
                        onError: function(result) {
                            console.log('Error:', result);
                            Swal.fire('Gagal!', 'Pembayaran gagal. Silakan coba lagi.', 'error');
                        },
                        onClose: function() {
                            Swal.fire('Informasi', 'Anda belum menyelesaikan pembayaran.', 'info');
                        }
                    });
                } catch (err) {
                    console.error(err);
                    Swal.fire('Error', err.message || 'Gagal memproses Midtrans.', 'error');
                }
            } else if (paymentMethod === 'qris') {
                document.getElementById('paymentMethodSelected').value = 'qris';
                // Langsung submit form untuk QRIS
                orderForm.submit();
            }
        }

        // Event listener untuk form orderForm (bukan untuk submit Midtrans langsung)
        document.getElementById('orderForm').addEventListener('submit', async function(e) {
            e.preventDefault(); // Mencegah submit default karena kita akan handle secara manual

            const paymentMethodSelected = document.getElementById('paymentMethodSelected').value;

            // Jika metode pembayaran Midtrans, proses sudah dihandle di `submitOrder()` melalui `snap.pay()` callback.
            // Maka di sini kita hanya perlu melanjutkan submit form untuk QRIS atau setelah Midtrans sukses/pending.
            if (paymentMethodSelected === 'midtrans' || paymentMethodSelected === 'qris') {
                const formData = new FormData(this);
                // Tambahkan total harga ke formData
                formData.append('gross_amount', document.getElementById('grossAmountInput').value);


                try {
                    const response = await fetch(this.action, {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();

                    if (response.ok) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: result.message,
                            confirmButtonText: 'Oke'
                        }).then(() => {
                            if (result.redirect) {
                                window.location.href = result.redirect;
                            }
                        });
                    } else {
                        // Handle validation errors or other server-side errors
                        let errorMessage = result.message || 'Terjadi kesalahan';
                        if (result.errors) {
                            errorMessage += '\n' + Object.values(result.errors).map(e => e.join(', ')).join('\n');
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: errorMessage,
                            confirmButtonText: 'Coba Lagi'
                        });
                    }
                } catch (error) {
                    console.error(error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat mengirim data pesanan.',
                        confirmButtonText: 'Coba Lagi'
                    });
                }
            }
        });

        document.getElementById('destination').addEventListener('change', function() {
            document.getElementById('destinationInput').value = this.value;
        });

        document.getElementById('courier').addEventListener('change', function() {
            document.getElementById('courierInput').value = this.value;
        });

        // Event listener untuk pilihan provinsi (jika ada)
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi awal
            togglePaymentMethod(); // Panggil saat halaman pertama kali dimuat

            // Jika ada elemen #provinsi, tambahkan event listener
            const provinsiSelect = document.getElementById('provinsi');
            if (provinsiSelect) {
                provinsiSelect.addEventListener('change', function() {
                    let provinceId = this.value;
                    fetch(`/get-cities/${provinceId}`)
                        .then(res => res.json())
                        .then(data => {
                            let kotaSelect = document.getElementById('kota');
                            kotaSelect.innerHTML = '<option value="">-- Pilih Kota --</option>';
                            data.forEach(k => {
                                kotaSelect.innerHTML += `<option value="${k.city_id}">${k.city_name}</option>`;
                            });
                        })
                        .catch(error => console.error('Error fetching cities:', error));
                });
            }
        });
    </script>

</html>