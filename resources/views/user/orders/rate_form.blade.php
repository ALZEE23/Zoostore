<x-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        [x-cloak] {
            display: none !important;
        }

        .rating-star {
            transition: color 0.2s;
        }

        .rating-star.selected {
            color: #f6e05e;
        }

        .rating-star:hover {
            color: #fbd38d;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-2xl p-8">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-8 flex items-center">
                    <svg class="w-8 h-8 text-blue-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11.01 17.01V19a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2h4a2 2 0 012 2v2.99" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 13l-3 3-3-3m4-6V3a2 2 0 00-2-2H5a2 2 0 00-2 2v5a2 2 0 002 2h4a2 2 0 002-2V9" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11l-3 3-3-3" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 5V3a2 2 0 00-2-2H9a2 2 0 00-2 2v2" />
                    </svg>
                    Beri Rating Pesanan #{{ $order->id }}
                </h2>

                <p class="text-gray-600 mb-6">Berikan rating untuk produk-produk di pesanan Anda. Kami menghargai
                    masukan Anda!</p>

                <form @submit.prevent="submitAllRatings" x-data="productRatingForm({{ $order->id }}, @js($order->orderItems))" class="space-y-8">
                    @csrf

                    @foreach ($order->orderItems as $index => $item)
                        <div
                            class="bg-gray-50 rounded-lg p-6 shadow-sm flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-6">
                            @if ($item->product->photo)
                                <img src="{{ asset('storage/' . $item->product->photo) }}"
                                    alt="{{ $item->product->name }}"
                                    class="w-24 h-24 object-cover rounded-lg flex-shrink-0">
                            @else
                                <div
                                    class="w-24 h-24 bg-gray-200 flex items-center justify-center text-xs text-gray-500 rounded-lg flex-shrink-0">
                                    No Photo
                                </div>
                            @endif

                            <div class="flex-grow">
                                <h3 class="text-xl font-semibold text-gray-900">{{ $item->product->name }}</h3>
                                <p class="text-gray-600">Jumlah: {{ $item->quantity }}</p>

                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Rating Bintang:</label>
                                    <div class="flex items-center space-x-1" x-init="setInitialRating({{ $index }}, {{ $item->product->ratings->first()->rating ?? 0 }})">
                                        <template x-for="i in 5" :key="i">
                                            <svg @click="setRating({{ $index }}, i)"
                                                :class="i <= ratings[{{ $index }}].rating ? 'text-yellow-400' :
                                                    'text-gray-300'"
                                                class="w-7 h-7 cursor-pointer fill-current rating-star"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 .587l3.642 7.427 8.214 1.196-5.967 5.811 1.411 8.188L12 18.257l-7.301 3.863 1.411-8.188-5.967-5.811 8.214-1.196L12 .587z" />
                                            </svg>
                                        </template>
                                        <input type="hidden" :name="`ratings[${{ $index }}][product_id]`"
                                            value="{{ $item->product->id }}">
                                        <input type="hidden" :name="`ratings[${{ $index }}][rating]`"
                                            x-model="ratings[{{ $index }}].rating">
                                    </div>
                                    <template x-if="ratings[{{ $index }}].hasRated">
                                        <span class="text-xs text-green-600 mt-1 block">Anda sudah memberi rating produk
                                            ini.</span>
                                    </template>
                                </div>

                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Komentar
                                        (opsional)
                                        :</label>
                                    <textarea :name="`ratings[${{ $index }}][comment]`" x-model="ratings[{{ $index }}].comment"
                                        rows="2"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></textarea>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="flex justify-end mt-8 space-x-4">
                        <a href="{{ route('user.orders.index') }}"
                            class="px-6 py-3 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition">Kembali</a>
                        <button type="submit"
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Kirim Semua Rating
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        function productRatingForm(orderId, orderItems) {
            return {
                orderId: orderId,
                ratings: orderItems.map(item => ({
                    product_id: item.product.id,
                    rating: item.product.ratings[0] ? item.product.ratings[0].rating : 0,
                    comment: item.product.ratings[0] ? item.product.ratings[0].comment : '',
                    hasRated: item.product.ratings[0] ? true : false
                })),

                setRating(index, rating) {
                    this.ratings[index].rating = rating;
                    this.ratings[index].hasRated = true;
                },

                async submitAllRatings() {
                    const ratingsToSend = this.ratings.filter(item => item.rating > 0);

                    if (ratingsToSend.length === 0) {
                        Swal.fire('Perhatian!', 'Silakan berikan rating setidaknya untuk satu produk.', 'warning');
                        return;
                    }

                    try {
                        const response = await fetch(
                            `{{ route('user.orders.submit_ratings', ['order' => $order->id]) }}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    ratings: ratingsToSend
                                })
                            });


                        const result = await response.json();

                        if (response.ok) {
                            Swal.fire('Sukses!', result.message, 'success').then(() => {
                                if (result.redirect) {
                                    window.location.href = result.redirect;
                                } else {
                                    location.reload();
                                }
                            });
                        } else {
                            let errorMessage = result.message || 'Terjadi kesalahan saat mengirim rating.';
                            if (response.status === 422 && result.errors) {
                                errorMessage = 'Validasi Gagal:<br>';
                                for (const field in result.errors) {
                                    errorMessage += `- ${result.errors[field].join(', ')}<br>`;
                                }
                            }
                            Swal.fire('Gagal!', errorMessage, 'error');
                        }
                    } catch (error) {
                        console.error('Error submitting ratings:', error);
                        Swal.fire('Error!', 'Tidak dapat terhubung ke server untuk mengirim rating.', 'error');
                    }
                }
            }
        }
    </script>
</x-layout>
