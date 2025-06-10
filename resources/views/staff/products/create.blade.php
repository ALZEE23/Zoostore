<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tambah Produk - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{ asset('asset-landing-admin/css/styles.css') }}" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="sb-nav-fixed">
    <x-navbar-pemasok></x-navbar-pemasok>
    <x-sidebar-pemasok></x-sidebar-pemasok>

    <div id="layoutSidenav_content">
        <main>
            <div class="container mt-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Tambah Produk</h4>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form id="productForm" action="{{ route('staff.products.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="code" class="form-label">Kode Produk</label>
                                <input type="text" class="form-control" id="code" name="code" required>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Harga</label>
                                <input type="number" class="form-control" id="price" name="price" required>
                            </div>
                            <div class="mb-3">
                                <label for="diskon" class="form-label">Diskon (%)</label>
                                <input type="number" class="form-control" id="diskon" name="diskon">
                            </div>
                            <div class="mb-3">
                                <label for="stock" class="form-label">Stok</label>
                                <input type="number" class="form-control" id="stock" name="stock" required>
                            </div>
                            <div class="mb-3">
                                <label for="photo" class="form-label">Foto Produk</label>
                                <input type="file" class="form-control" id="photo" name="photo"
                                    accept="image/jpeg,image/jpg,image/png">
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="aktif">Aktif</option>
                                    <option value="nonaktif">Nonaktif</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('staff.products.index') }}" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
<script src="{{ asset('asset-landing-admin/js/scripts.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Bagian dari script.js atau di dalam tag <script> di blade Anda
    document.getElementById('productForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        try {
            const formData = new FormData(this);
            const response = await fetch('{{ route('staff.products.store') }}', {
                method: 'POST',
                body: formData,
                headers: { // <--- PASTI ADA INI
                    'Accept': 'application/json'
                }
            });

            let result;
            try {
                result = await response.json();
            } catch (jsonError) {
                const textResponse = await response.text();
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Server!',
                    text: `Respons bukan JSON: ${response.status} ${response.statusText}. Konten: ${textResponse.substring(0, 200)}...`,
                    footer: 'Cek log Laravel untuk detailnya.'
                });
                return; // Hentikan eksekusi jika respons bukan JSON
            }

            if (response.ok) { // response.ok adalah true untuk status 200-299
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: result.message || 'Produk berhasil ditambahkan!',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = result.redirect || '{{ route('staff.products.index') }}';
                });
            } else {
                // Tangani error validasi (status 422) atau error server (status 500)
                if (response.status === 422 && result.errors) {
                    let errorMessage = 'Data yang Anda masukkan tidak valid:<br>';
                    for (const field in result.errors) {
                        errorMessage += `- ${result.errors[field].join(', ')}<br>`;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Gagal!',
                        html: errorMessage.trim()
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: result.message || 'Terjadi kesalahan tidak dikenal.'
                    });
                }
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error Jaringan/Klien!',
                text: 'Tidak dapat terhubung ke server atau terjadi kesalahan pada klien: ' + error
                    .message
            });
        }
    });
</script>

</html>
