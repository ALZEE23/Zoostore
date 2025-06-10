<x-layout>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" x-data="orderPage()">
            <div class="bg-white shadow-lg sm:rounded-2xl p-8">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-8 flex items-center">
                    <svg class="w-8 h-8 text-blue-600 mr-2 animate-pulse" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Pesanan Saya
                </h2>

                <nav class="flex flex-wrap gap-3 mb-8">
                    <button @click="setFilter('All')" :class="tabClass('All')"
                        class="px-4 py-2 rounded-full text-sm font-medium transition">Semua</button>
                    <template x-for="st in statuses" :key="st">
                        <button @click="setFilter(st)" :class="tabClass(st)"
                            class="px-4 py-2 rounded-full text-sm font-medium transition">
                            <span x-text="st"></span>
                        </button>
                    </template>
                </nav>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($orders as $order)
                        <div x-show="matchFilter('{{ ucfirst($order->status) }}')"
                            class="bg-white rounded-2xl shadow-lg p-6 transform hover:scale-105 transition duration-300 relative">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-sm text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</span>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold"
                                    :class="badgeClass('{{ $order->status }}')">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Total: Rp
                                {{ number_format($order->total_price, 0, ',', '.') }}</h3>
                            <div class="flex justify-between items-center mt-4 space-x-2">
                                <button @click="openDetail({{ $order->id }})"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                                    Detail
                                </button>
                                @if (strtolower($order->status) === 'completed')
                                    {{-- TOMBOL RATING SEKARANG NAVIGASI KE HALAMAN BARU --}}
                                    <a href="{{ route('user.orders.rate_form', $order->id) }}"
                                        class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition">
                                        Rating
                                    </a>
                                    <button onclick="confirmDelete(event)"
                                        data-action="{{ route('user.orders.destroy', $order->id) }}"
                                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition">
                                        Hapus
                                    </button>
                                @endif
                            </div>

                            <template x-teleport="body">
                                <div x-show="detailId === {{ $order->id }}" x-cloak
                                    class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center p-4 z-50">
                                    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-auto animate-fadeIn"
                                        @click.away="closeDetail()" @keydown.escape.window="closeDetail()">
                                        <div class="p-6">
                                            <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">Detail Pesanan
                                            </h3>
                                            <div class="text-sm text-gray-600 mb-4">
                                                <p><strong>Alamat:</strong> {{ $order->alamat }}</p>
                                                <p><strong>Kurir:</strong> {{ strtoupper($order->courier) }}
                                                    ({{ $order->service }})</p>
                                            </div>
                                            <div class="border-t pt-4 space-y-4">
                                                @foreach ($order->orderItems as $item)
                                                    <div class="flex items-start gap-4">
                                                        @if ($item->product->photo)
                                                            <img src="{{ asset('storage/' . $item->product->photo) }}"
                                                                alt="{{ $item->product->name }}"
                                                                class="w-16 h-16 object-cover rounded-lg">
                                                        @else
                                                            <div
                                                                class="w-16 h-16 bg-gray-100 flex items-center justify-center text-xs text-gray-500 rounded-lg">
                                                                No Photo</div>
                                                        @endif
                                                        <div class="flex-1">
                                                            <p class="font-medium text-gray-900">
                                                                {{ $item->product->name }}</p>
                                                            <p class="text-sm text-gray-600">x{{ $item->quantity }}</p>
                                                        </div>
                                                        <div class="text-sm font-medium text-gray-900">Rp
                                                            {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="mt-6 text-right font-bold text-gray-900">Total: Rp
                                                {{ number_format($order->total_price, 0, ',', '.') }}</div>
                                            <div class="mt-6">
                                                <button @click="closeDetail()"
                                                    class="w-full py-2 bg-gray-600 text-white rounded-full hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 transition">
                                                    Tutup
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    @empty
                        <div class="col-span-full text-center text-gray-400">Belum ada pesanan</div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>

    {{-- MODAL RATING LAMA DIHAPUS DARI SINI --}}
    {{-- <template x-teleport="body">...</template> --}}


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        function orderPage() {
            return {
                statuses: ['Pending', 'Processed', 'Delivery', 'Completed', 'Cancelled'],
                statusFilter: 'All',
                detailId: null,
                // ratingOrderId: null, // Hapus state ini karena rating sekarang di halaman terpisah

                setFilter(st) {
                    this.statusFilter = st;
                },
                openDetail(id) {
                    this.detailId = id;
                },
                closeDetail() {
                    this.detailId = null;
                },

                // openRatingModal(orderId) { this.ratingOrderId = orderId; }, // Hapus fungsi ini
                // closeRatingModal() { this.ratingOrderId = null; },       // Hapus fungsi ini
                // submitRating() { /* Hapus fungsi ini karena akan ditangani di halaman rating */ },

                tabClass(st) {
                    return this.statusFilter === st ? 'bg-blue-600 text-white' :
                        'bg-gray-100 text-gray-700 hover:bg-gray-200';
                },
                badgeClass(status) {
                    const map = {
                        'Pending': 'bg-yellow-200 text-yellow-800',
                        'Processed': 'bg-blue-200 text-blue-800',
                        'Delivery': 'bg-orange-200 text-orange-800',
                        'Completed': 'bg-green-200 text-green-800',
                        'Cancelled': 'bg-red-200 text-red-800'
                    };
                    return map[status] || 'bg-gray-200 text-gray-800';
                },
                matchFilter(status) {
                    return this.statusFilter === 'All' || status === this.statusFilter;
                }
            }
        }

        function confirmDelete(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Yakin mau hapus pesanan ini?',
                text: 'Pesanan akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(event.target.getAttribute('data-action'), {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(response => {
                        if (response.ok) {
                            Swal.fire('Terhapus!', 'Pesanan berhasil dihapus.', 'success');
                            location.reload();
                        } else {
                            return response.json().then(errorData => {
                                Swal.fire('Gagal!', errorData.message || 'Gagal menghapus pesanan.',
                                    'error');
                            });
                        }
                    }).catch(error => {
                        console.error('Error deleting order:', error);
                        Swal.fire('Error!', 'Terjadi kesalahan saat menghapus pesanan.', 'error');
                    });
                }
            });
        }
    </script>
</x-layout>
