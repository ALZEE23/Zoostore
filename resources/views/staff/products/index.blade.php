<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Staff Zoes Store | Product</title>
    <link href="{{ asset('asset-landing-admin/css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

</head>

<body class="sb-nav-fixed">
    {{-- navbar --}}
    <x-navbar-pemasok></x-navbar-pemasok>
    {{-- sidebar --}}
    <x-sidebar-pemasok></x-sidebar-pemasok>
    {{-- end --}}

    <div id="layoutSidenav_content">
        <main>
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-table me-1"></i> Data Produk</span>
                    <a href="{{ route('staff.products.create') }}" class="btn btn-primary">Tambah Produk</a>
                </div>
                <style>
                    /* Tambahkan atau sesuaikan gaya CSS Anda di sini jika diperlukan */
                    /* Contoh untuk responsif gambar di tabel */
                    #datatablesSimple img {
                        max-width: 80px; /* Sesuaikan ukuran gambar di tabel */
                        height: auto;
                        display: block;
                        margin: 0 auto; /* Tengahkankan gambar */
                    }
                </style>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatablesSimple" class="table table-bordered table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Deskripsi</th>
                                    <th>Kode</th>
                                    <th>Harga</th>
                                    <th>Diskon</th>
                                    <th>Harga Setelah Diskon</th>
                                    <th>Stok</th>
                                    <th>Foto</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ Str::limit($product->description, 50) }}</td>
                                    <td class="text-center">{{ $product->code }}</td>
                                    <td class="text-end">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td class="text-center">{{ $product->diskon ? $product->diskon . '%' : '-' }}
                                    </td>
                                    <td class="text-end">
                                        @if ($product->diskon)
                                        Rp{{ number_format($product->harga_diskon, 0, ',', '.') }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $product->stock }}</td>
                                    <td class="text-center">
                                        @if ($product->photo)
                                        <img src="{{ asset('storage/' . $product->photo) }}"
                                            alt="{{ $product->name }}">
                                        @else
                                        <span class="text-muted">Tidak ada foto</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge {{ $product->status == 'aktif' ? 'bg-success' : 'bg-danger' }}">
                                            {{ ucfirst($product->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div
                                            class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-1">
                                            <button class="btn btn-sm btn-warning edit-btn"
                                                data-href="{{ route('staff.products.edit', $product->id) }}">Ubah</button>

                                            <button class="btn btn-sm btn-info show-btn"
                                                data-href="{{ route('staff.products.show', $product->id) }}">Lihat</button>
                                            <form class="d-inline delete-form"
                                                action="{{ route('staff.products.destroy', $product->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-sm btn-danger delete-btn">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                {{-- Jika tidak ada produk, DataTables tidak akan diinisialisasi --}}
                                {{-- Anda bisa menyembunyikan pesan ini jika DataTables tidak diinisialisasi --}}
                                @endforelse
                            </tbody>
                        </table>
                        {{-- Tampilkan pesan "Tidak ada data" secara terpisah jika $products kosong --}}
                        @if ($products->isEmpty())
                            <p class="text-center mt-3">Tidak ada data produk.</p>
                        @endif
                    </div>
                </div>

            </div>
        </main>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script src="{{ asset('asset-landing-admin/js/scripts.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            crossorigin="anonymous">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/demo/chart-area-demo.js') }}"></script>
        <script src="{{ asset('assets/demo/chart-bar-demo.js') }}"></script>
        <script src="{{ asset('js/scripts.js') }}"></script>
        <script>
            $(document).ready(function() {
                // Hanya inisialisasi DataTables jika ada data produk
                @if ($products->isNotEmpty())
                    $('#datatablesSimple').DataTable({
                        // Opsional: Konfigurasi tambahan untuk DataTables
                        // "paging": true,
                        // "ordering": true,
                        // "info": true,
                        // "searching": true,
                        // "lengthChange": true
                    });
                @endif

                @if (session('success'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: '{{ session('success') }}'
                    });
                @elseif (session('error'))
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: '{{ session('error') }}'
                    });
                @endif

                $(document).on('click', '.delete-btn', function(e) {
                    e.preventDefault();
                    let form = $(this).closest('form');
                    Swal.fire({
                        title: 'Yakin?',
                        text: "Anda akan menghapus produk ini!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });

                $(document).on('click', '.edit-btn', function() {
                    let url = $(this).data('href');
                    window.location.href = url;
                });

                $(document).on('click', '.show-btn', function() {
                    let url = $(this).data('href');
                    window.location.href = url;
                });
            });
        </script>
    </div>
</body>

</html>