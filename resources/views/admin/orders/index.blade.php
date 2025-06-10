<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Admin Zoes Store | Orders</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" /> --}}
    <link href="{{ asset('asset-landing-admin/css/styles.css') }}" rel="stylesheet" />
    {{-- DataTables CSS --}}
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css" rel="stylesheet" />
    {{-- Opsional: untuk tombol ekspor, dll. --}}
    {{-- <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet" /> --}}

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="sb-nav-fixed">
    <x-navbar-admin></x-navbar-admin>
    <x-sidebar-admin></x-sidebar-admin>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Data Pesanan</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Data Pesanan</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Daftar Pesanan
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="display nowrap table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Tanggal Pesanan</th>
                                    <th>Total Harga</th>
                                    <th>Status Pemesanan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Kita tidak perlu @forelse di sini, cukup @foreach --}}
                                {{-- DataTables akan menangani pesan "No data available in table" secara otomatis --}}
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $order->user->name ?? 'Pengguna Dihapus' }}</td>
                                        <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                                        <td>Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'Pending' => 'bg-secondary',
                                                    'Processed' => 'bg-primary',
                                                    'Delivery' => 'bg-warning',
                                                    'Completed' => 'bg-success',
                                                    'Cancelled' => 'bg-danger',
                                                    'Paid' => 'bg-success',
                                                    'Pending Payment' => 'bg-info',
                                                    'Challenged' => 'bg-warning',
                                                    'Denied' => 'bg-danger',
                                                    'Expired' => 'bg-dark',
                                                ];
                                            @endphp
                                            <span class="badge {{ $statusColors[$order->status] ?? 'bg-secondary' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#orderDetailModal{{ $order->id }}">Lihat Detail</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- Hapus pesan "Tidak ada data pesanan." di luar tabel juga, DataTables akan mengurusnya --}}
                        {{-- @if ($orders->isEmpty())
                            <p class="text-center mt-3 text-gray-500">Tidak ada data pesanan.</p>
                        @endif --}}
                    </div>
                </div>
            </div>
        </main>
    </div>

    @foreach ($orders as $order)
        <div class="modal fade" id="orderDetailModal{{ $order->id }}" tabindex="-1"
            aria-labelledby="orderDetailModalLabel{{ $order->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderDetailModalLabel{{ $order->id }}">Detail Pesanan #{{ $order->id }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h6>Nama Pelanggan: {{ $order->user->name ?? 'Pengguna Dihapus' }}</h6>
                        <p><strong>Order ID:</strong> {{ $order->id }}</p>
                        <p><strong>Status Pembayaran:</strong> <span class="badge {{ $statusColors[$order->status] ?? 'bg-secondary' }}">{{ ucfirst($order->status) }}</span></p>
                        <p><strong>Metode Pembayaran:</strong> {{ ucfirst($order->payment_method ?? '-') }}</p>
                        <p><strong>Alamat Pengiriman:</strong> {{ $order->alamat }}</p>
                        <p><strong>Catatan:</strong> {{ $order->masukan ?? '-' }}</p>
                        <p><strong>Kurir:</strong> {{ strtoupper($order->courier) }} ({{ $order->service }})</p>
                        <p><strong>Biaya Ongkir:</strong> Rp {{ number_format($order->shipping_cost ?? 0, 0, ',', '.') }}</p>
                        <p><strong>Bukti Pembayaran:</strong></p>
                        @if ($order->payment_photo && $order->payment_photo !== 'default.png' && $order->payment_photo !== null)
                            <img src="{{ asset('storage/' . $order->payment_photo) }}" alt="Bukti Pembayaran" class="img-fluid rounded mb-3" style="max-width: 200px;">
                        @else
                            <img src="{{ asset('storage/payment_photos/default.png') }}" alt="Bukti Pembayaran Default" class="img-fluid rounded mb-2" style="max-width: 200px;">
                            <p class="text-muted">Belum ada bukti pembayaran yang diupload.</p>
                        @endif
                        <form id="updateStatusForm{{ $order->id }}" class="mt-3">
                            @csrf
                            <div class="mb-3">
                                <label for="status{{ $order->id }}" class="form-label">Update Status</label>
                                <select id="status{{ $order->id }}" class="form-select" name="status" {{ $order->status == 'Completed' || $order->status == 'Cancelled' || $order->status == 'Denied' || $order->status == 'Expired' ? 'disabled' : '' }} required>
                                    <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Processed" {{ $order->status == 'Processed' ? 'selected' : '' }}>Processed</option>
                                    <option value="Delivery" {{ $order->status == 'Delivery' ? 'selected' : '' }}>Delivery</option>
                                    <option value="Completed" {{ $order->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    <option value="Paid" {{ $order->status == 'Paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="Pending Payment" {{ $order->status == 'Pending Payment' ? 'selected' : '' }}>Pending Payment</option>
                                    <option value="Challenged" {{ $order->status == 'Challenged' ? 'selected' : '' }}>Challenged</option>
                                    <option value="Denied" {{ $order->status == 'Denied' ? 'selected' : '' }}>Denied</option>
                                    <option value="Expired" {{ $order->status == 'Expired' ? 'selected' : '' }}>Expired</option>
                                </select>
                            </div>
                        </form>
                        <h6>Produk yang Dipesan:</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>Jumlah</th>
                                        <th>Harga/Item</th>
                                        <th>Diskon</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $subtotalProduk = 0; @endphp
                                    @forelse ($order->orderItems as $item)
                                        <tr>
                                            <td class="d-flex align-items-center gap-2">
                                                @if ($item->product && $item->product->photo)
                                                    <img src="{{ asset('storage/' . $item->product->photo) }}" style="width:50px;height:50px;object-fit:cover;border-radius:5px;">
                                                @else
                                                    <img src="{{ asset('storage/products/default.png') }}" style="width:50px;height:50px;object-fit:cover;border-radius:5px;">
                                                @endif
                                                <span>{{ $item->product->name ?? 'Produk tidak ditemukan' }}</span>
                                            </td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>Rp{{ number_format($item->product->price ?? $item->price, 0, ',', '.') }}</td>
                                            <td>{{ ($item->product->diskon ?? 0) }}%</td>
                                            <td>Rp{{ number_format(($item->product->harga_diskon ?? $item->price) * $item->quantity, 0, ',', '.') }}</td>
                                        </tr>
                                        @php
                                            $priceToUse = $item->product->harga_diskon ?? $item->price;
                                            $subtotalProduk += ($priceToUse * $item->quantity);
                                        @endphp
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada item produk.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" class="text-end">Subtotal Produk:</th>
                                        <th class="text-end">Rp{{ number_format($subtotalProduk, 0, ',', '.') }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="4" class="text-end">Biaya Ongkir:</th>
                                        <th class="text-end">Rp{{ number_format($order->shipping_cost ?? 0, 0, ',', '.') }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="4" class="text-end">Total Keseluruhan:</th>
                                        <th class="text-end">Rp{{ number_format($order->total_price, 0, ',', '.') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        @if ($order->status != 'Completed' && $order->status != 'Cancelled' && $order->status != 'Denied' && $order->status != 'Expired')
                            <button type="button" class="btn btn-primary" onclick="updateOrderStatus({{ $order->id }})">Update Status</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- jQuery dan DataTables JS harus dimuat di bagian akhir body, setelah semua HTML tabel --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    {{-- Opsional: untuk tombol ekspor/tombol --}}
    {{-- <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script> --}}

    {{-- Bootstrap Bundle JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    {{-- Custom scripts.js untuk SB Admin (jika ada) --}}
    <script src="{{ asset('asset-landing-admin/js/scripts.js') }}"></script>
    {{-- Chart.js (jika digunakan) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('asset-landing-admin/assets/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('asset-landing-admin/assets/demo/chart-bar-demo.js') }}"></script>


    <script>
        $(document).ready(function() {
            // Inisialisasi DataTables tanpa kondisi if.
            // DataTables memiliki penanganan internal untuk tabel kosong.
            $('#myTable').DataTable({
                responsive: true,
                // "language": { // Opsional: Ubah teks DataTables ke Bahasa Indonesia
                //     "emptyTable": "Tidak ada data pesanan tersedia di tabel"
                // }
                // Tambahkan konfigurasi tambahan jika diperlukan
            });

            // SweetAlert for session messages
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            @elseif (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    showConfirmButton: true
                });
            @endif
        });

        async function updateOrderStatus(orderId) {
            try {
                const select = document.getElementById('status' + orderId);
                const status = select.value;

                const response = await fetch(`/admin/orders/${orderId}/update-status`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ status })
                });

                const result = await response.json();
                if (response.ok) {
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: result.message, timer: 1500, showConfirmButton: false });
                    setTimeout(() => location.reload(), 1500);
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: result.message || 'Terjadi kesalahan' });
                }
            } catch (error) {
                Swal.fire({ icon: 'error', title: 'Error', text: error.message });
            }
        }
    </script>

</html>