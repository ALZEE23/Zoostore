<x-navbar>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profil Pengguna</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
  <div class="container mx-auto px-4 py-10">
    <div class="bg-white rounded-2xl shadow-xl p-6 md:p-10 max-w-6xl mx-auto space-y-8">

      <!-- Header -->
      <div class="text-center">
        <h1 class="text-2xl font-bold mb-1">Profil Pengguna</h1>
        <p class="text-gray-500 text-sm">Informasi akun dan pribadi</p>
      </div>

      <!-- Foto Profil -->
      <div class="flex justify-center">
        <img 
          src="https://ui-avatars.com/api/?name=UMKM+KAMI&background=0D8ABC&color=fff&size=256"
          alt="Foto Profil"
          class="w-28 h-28 sm:w-32 sm:h-32 rounded-full border-4 border-white shadow-md object-cover transition-transform duration-300 hover:scale-105"
        />
      </div>

      <!-- Informasi Akun -->
      <div class="bg-gray-50 rounded-xl p-4 md:p-6 shadow-sm">
        <h2 class="text-lg font-semibold mb-4">Informasi Akun</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label class="block text-sm text-gray-500 mb-1">Nama Lengkap</label>
            <input type="text" value="UMKM KAMI" class="w-full p-2 border rounded-lg bg-white" disabled />
          </div>
          <div>
            <label class="block text-sm text-gray-500 mb-1">Email</label>
            <input type="email" value="guest@example.com" class="w-full p-2 border rounded-lg bg-white" disabled />
          </div>
          <div>
            <label class="block text-sm text-gray-500 mb-1">Nomor Telepon</label>
            <input type="text" value="0897272" class="w-full p-2 border rounded-lg bg-white" disabled />
          </div>
        </div>
      </div>

      <!-- Informasi Pribadi -->
      <div class="bg-gray-50 rounded-xl p-4 md:p-6 shadow-sm">
        <h2 class="text-lg font-semibold mb-4">Informasi Pribadi</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm text-gray-500 mb-1">Alamat Lengkap</label>
            <input type="text" value="laladon" class="w-full p-2 border rounded-lg bg-white" disabled />
          </div>
          <div>
            <label class="block text-sm text-gray-500 mb-1">Jenis Kelamin</label>
            <input type="text" value="Perempuan" class="w-full p-2 border rounded-lg bg-white" disabled />
          </div>
          <div>
            <label class="block text-sm text-gray-500 mb-1">Tanggal Lahir</label>
            <input type="text" value="27/04/2008" class="w-full p-2 border rounded-lg bg-white" disabled />
          </div>
          <div>
            <label class="block text-sm text-gray-500 mb-1">Kecamatan</label>
            <input type="text" value="cikampes" class="w-full p-2 border rounded-lg bg-white" disabled />
          </div>
          <div>
            <label class="block text-sm text-gray-500 mb-1">Kota/Kabupaten</label>
            <input type="text" value="bogro" class="w-full p-2 border rounded-lg bg-white" disabled />
          </div>
          <div>
            <label class="block text-sm text-gray-500 mb-1">Provinsi</label>
            <input type="text" value="jabar" class="w-full p-2 border rounded-lg bg-white" disabled />
          </div>
          <div>
            <label class="block text-sm text-gray-500 mb-1">Kode Pos</label>
            <input type="text" value="19902" class="w-full p-2 border rounded-lg bg-white" disabled />
          </div>
        </div>
      </div>

      <!-- Tombol Aksi -->
      <div class="text-center">
        <a href="{{ route('profile.edit') }}" 
          class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-lg transition-transform duration-200 hover:scale-105 inline-block">
          Edit Data
        </a>
      </div>
    </div>
  </div>
</body>
</html>
</x-navbar>