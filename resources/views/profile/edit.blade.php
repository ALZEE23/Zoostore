<x-navbar>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Rekap Data</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <link href="https://unpkg.com/cropperjs@1.5.13/dist/cropper.min.css" rel="stylesheet" />
  <!-- Tambahkan script CropperJS -->
  <script src="https://unpkg.com/cropperjs@1.5.13/dist/cropper.min.js"></script>
</head>
<body class="bg-gray-100">

  <!-- Container Utama -->
  <div class="container mx-auto px-4 py-8">
    <h2 class="text-3xl font-bold text-center mb-8">User Profile</h2>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-8">
      @csrf
      @method('PATCH')

      <!-- Profil -->
      <div class="bg-white p-6 rounded-lg shadow-lg grid md:grid-cols-3 gap-6">
        <div class="flex flex-col items-center">
          @php
            $profilePicture = $user['profile_picture']
              ? Storage::url($user['profile_picture'])
              : asset('images/default-avatar.png');
          @endphp
          <img id="profilePreview" src="{{ $profilePicture }}" alt="Profile Picture" class="w-32 h-32 rounded-full object-cover border-4 border-gray-300">
          <input type="file" id="profileInput" name="profile_picture" accept="image/*" class="hidden">
          <input type="hidden" name="remove_photo" id="removePhotoInput" value="0">
          <div class="mt-4 flex gap-2">
            <label for="profileInput" class="bg-blue-500 hover:bg-blue-600 transition duration-200 text-white px-4 py-2 rounded-lg cursor-pointer">
              <i class="fas fa-upload mr-2"></i>Pilih Foto
            </label>
            <button type="button" id="removePhotoBtn" class="bg-red-500 hover:bg-red-600 transition duration-200 text-white px-4 py-2 rounded-lg {{ $user['profile_picture'] ? '' : 'hidden' }}">
              <i class="fas fa-trash-alt mr-2"></i>Hapus Foto
            </button>
          </div>
        </div>
        <div class="md:col-span-2 flex flex-col justify-center">
          <h3 id="displayName" class="text-4xl font-bold">{{ $user['name'] }}</h3>
          <div class="mt-4 text-gray-700 space-y-2">
            <p><i class="fas fa-envelope mr-2 text-gray-500"></i>{{ $user['email'] }}</p>
            <p><i class="fas fa-phone-alt mr-2 text-gray-500"></i>{{ $user['phone'] ?? '-' }}</p>
          </div>
        </div>
      </div>

      <!-- Informasi Akun -->
      <div class="bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-xl font-semibold mb-4 border-b pb-2">Informasi Akun</h3>
        <div class="grid md:grid-cols-3 gap-4">
          <div>
            <label class="block font-medium mb-1"><i class="fas fa-user mr-2"></i>Nama Lengkap</label>
            <input type="text" name="name" id="fullname" value="{{ old('name', $user['name']) }}" class="w-full border p-3 rounded-lg" oninput="updateProfile()">
          </div>
          <div>
            <label class="block font-medium mb-1"><i class="fas fa-envelope mr-2"></i>Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user['email']) }}" class="w-full border p-3 rounded-lg" oninput="updateProfile()">
          </div>
          <div>
            <label class="block font-medium mb-1"><i class="fas fa-phone mr-2"></i>Nomor Telepon</label>
            <input type="tel" name="phone" id="phone" value="{{ old('phone', $user['phone']) }}" class="w-full border p-3 rounded-lg" oninput="checkFormChanges()">
          </div>
        </div>
      </div>

      <!-- Informasi Pribadi -->
      <div class="bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-xl font-semibold mb-4 border-b pb-2">Informasi Pribadi</h3>
        <div class="grid md:grid-cols-2 gap-4">
          <div>
            <label class="block font-medium mb-1"><i class="fas fa-map-marker-alt mr-2"></i>Alamat Lengkap</label>
            <textarea name="address" rows="3" class="w-full border p-3 rounded-lg" oninput="checkFormChanges()">{{ old('address', $user['address']) }}</textarea>
          </div>
          <div>
            <label class="block font-medium mb-1"><i class="fas fa-venus-mars mr-2"></i>Jenis Kelamin</label>
            <select name="gender" class="w-full border p-3 rounded-lg" onchange="checkFormChanges()">
              <option value="" disabled selected>Pilih Jenis Kelamin</option>
              <option value="Laki-laki" {{ $user['gender'] === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
              <option value="Perempuan" {{ $user['gender'] === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
          </div>
          <div>
            <label class="block font-medium mb-1"><i class="fas fa-calendar-alt mr-2"></i>Tanggal Lahir</label>
            <input type="date" name="birthdate" value="{{ old('birthdate', $user['birthdate']) }}" class="w-full border p-3 rounded-lg" oninput="checkFormChanges()">
          </div>
          <div>
            <label class="block font-medium mb-1"><i class="fas fa-map-signs mr-2"></i>Kecamatan</label>
            <input type="text" name="district" value="{{ old('district', $user['district']) }}" class="w-full border p-3 rounded-lg" oninput="checkFormChanges()">
          </div>
          <div>
            <label class="block font-medium mb-1"><i class="fas fa-city mr-2"></i>Kota/Kabupaten</label>
            <input type="text" name="city" value="{{ old('city', $user['city']) }}" class="w-full border p-3 rounded-lg" oninput="checkFormChanges()">
          </div>
          <div>
            <label class="block font-medium mb-1"><i class="fas fa-map mr-2"></i>Provinsi</label>
            <input type="text" name="province" value="{{ old('province', $user['province']) }}" class="w-full border p-3 rounded-lg" oninput="checkFormChanges()">
          </div>
          <div>
            <label class="block font-medium mb-1"><i class="fas fa-mail-bulk mr-2"></i>Kode Pos</label>
            <input type="text" name="postal_code" value="{{ old('postal_code', $user['postal_code']) }}" class="w-full border p-3 rounded-lg" oninput="checkFormChanges()">
          </div>
        </div>
      </div>

      <!-- Keamanan (Perubahan Email & Kata Sandi) -->
      <div class="bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-xl font-semibold mb-4 border-b pb-2">Keamanan</h3>
        <div class="grid md:grid-cols-2 gap-4">
          <div>
            <label class="block font-medium mb-1">
              <i class="fas fa-envelope mr-2"></i>Email Lama
            </label>
            <input type="email" name="old_email" placeholder="Masukkan email lama" class="w-full border p-3 rounded-lg" oninput="checkFormChanges()">
          </div>
          <div>
            <label class="block font-medium mb-1">
              <i class="fas fa-envelope-open-text mr-2"></i>Email Baru <span class="text-xs text-gray-500">(Opsional)</span>
            </label>
            <input type="email" name="new_email" placeholder="Masukkan email baru" class="w-full border p-3 rounded-lg" oninput="checkFormChanges()">
          </div>
        </div>
        <div class="mt-4 grid md:grid-cols-2 gap-4">
          <div>
            <label class="block font-medium mb-1">
              <i class="fas fa-lock mr-2"></i>Kata Sandi Lama
            </label>
            <input type="password" name="old_password" placeholder="Masukkan kata sandi lama" class="w-full border p-3 rounded-lg" oninput="checkFormChanges()">
          </div>
          <div>
            <label class="block font-medium mb-1">
              <i class="fas fa-key mr-2"></i>Kata Sandi Baru
            </label>
            <input type="password" name="new_password" placeholder="Masukkan kata sandi baru" class="w-full border p-3 rounded-lg" oninput="checkFormChanges()">
          </div>
        </div>
      </div>

      <!-- Tombol Simpan -->
      <div class="text-center">
        <button id="saveButton" type="submit" class="bg-gray-400 text-white px-8 py-3 rounded-lg text-lg cursor-not-allowed" disabled>
          <i class="fas fa-save mr-2"></i>Simpan Perubahan
        </button>
      </div>
    </form>
  </div>

  <!-- Modal Cropper -->
  <div id="cropModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
    <div class="bg-white p-4 rounded-lg max-w-2xl w-full">
      <h3 class="text-xl font-bold mb-4">Crop Foto</h3>
      <div class="flex justify-center">
        <img id="cropImage" src="" alt="Crop Image" class="max-w-full h-auto" style="max-height: 70vh;">
      </div>
      <!-- Tombol Tambahan untuk Rotasi, Zoom, dan Reset -->
      <div class="mt-4 flex flex-wrap justify-end gap-2">
        <!-- Tombol rotasi bisa ditambahkan bila diinginkan, pastikan element id-nya sesuai -->
        <button id="zoomIn" class="bg-gray-500 hover:bg-gray-600 transition duration-200 text-white px-4 py-2 rounded-lg">Zoom In</button>
        <button id="zoomOut" class="bg-gray-500 hover:bg-gray-600 transition duration-200 text-white px-4 py-2 rounded-lg">Zoom Out</button>
        <button id="resetCropper" class="bg-gray-500 hover:bg-gray-600 transition duration-200 text-white px-4 py-2 rounded-lg">Reset</button>
        <button id="cancelCrop" class="bg-gray-500 hover:bg-gray-600 transition duration-200 text-white px-4 py-2 rounded-lg">Batal</button>
        <button id="cropButton" class="bg-blue-600 hover:bg-blue-700 transition duration-200 text-white px-4 py-2 rounded-lg">Crop</button>
      </div>
    </div>
  </div>

  <script>
    const fullnameInput = document.getElementById("fullname");
    const emailInput = document.getElementById("email");
    const phoneInput = document.getElementById("phone");
    const saveButton = document.getElementById("saveButton");
    const displayName = document.getElementById("displayName");

    function updateProfile() {
      displayName.textContent = fullnameInput.value.trim() || "nama pengguna";
      checkFormChanges();
    }

    function checkFormChanges() {
      // Cek apakah ada perubahan pada input yang diperlukan
      const anyChanged = fullnameInput.value.trim() || emailInput.value.trim() ||
                         phoneInput.value.trim() || document.querySelector('input[name="old_email"]').value.trim() ||
                         document.querySelector('input[name="new_email"]').value.trim() ||
                         document.querySelector('input[name="old_password"]').value.trim() ||
                         document.querySelector('input[name="new_password"]').value.trim();
      if (anyChanged) {
        saveButton.disabled = false;
        saveButton.classList.replace("bg-gray-400", "bg-blue-600");
        saveButton.classList.remove("cursor-not-allowed");
      } else {
        saveButton.disabled = true;
        saveButton.classList.replace("bg-blue-600", "bg-gray-400");
        saveButton.classList.add("cursor-not-allowed");
      }
    }

    // Variabel untuk CropperJS
    let cropper;
    const cropModal = document.getElementById("cropModal");
    const cropImage = document.getElementById("cropImage");
    const profileInput = document.getElementById("profileInput");

    document.addEventListener("DOMContentLoaded", () => {
      const defaultAvatar = "{{ asset('images/default-avatar.png') }}";
      const profilePreview = document.getElementById("profilePreview");
      const removePhotoBtn = document.getElementById("removePhotoBtn");
      const removePhotoInput = document.getElementById("removePhotoInput");

      removePhotoBtn.addEventListener("click", () => {
        profilePreview.src = defaultAvatar;
        profileInput.value = "";
        removePhotoInput.value = "1";
        removePhotoBtn.classList.add("hidden");
        checkFormChanges();
      });

      // Buka modal cropper saat file input berubah
      profileInput.addEventListener("change", (e) => {
        const file = e.target.files[0];
        if (file) {
          removePhotoInput.value = "0";
          removePhotoBtn.classList.remove("hidden");
          const reader = new FileReader();
          reader.onload = function(event) {
            cropImage.src = event.target.result;
            cropModal.classList.remove("hidden");
            if (cropper) { cropper.destroy(); }
            cropper = new Cropper(cropImage, {
              aspectRatio: 1,
              viewMode: 1,
              autoCropArea: 0.8,
              movable: true,
              zoomable: true,
              rotatable: false,
              scalable: false,
            });
          }
          reader.readAsDataURL(file);
        }
      });

      // Batal crop
      document.getElementById("cancelCrop").addEventListener("click", () => {
        cropModal.classList.add("hidden");
        if (cropper) { cropper.destroy(); }
        profileInput.value = "";
      });

      // Tombol crop
      document.getElementById("cropButton").addEventListener("click", () => {
        if (cropper) {
          cropper.getCroppedCanvas().toBlob((blob) => {
            const fileName = "cropped_" + Date.now() + ".png";
            const croppedFile = new File([blob], fileName, { type: 'image/png' });
            const newImageUrl = URL.createObjectURL(croppedFile);
            profilePreview.src = newImageUrl;
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(croppedFile);
            profileInput.files = dataTransfer.files;
            cropModal.classList.add("hidden");
            cropper.destroy();
            checkFormChanges();
          }, 'image/png');
        }
      });

      // Tombol zoom dan reset tambahan
      document.getElementById("zoomIn").addEventListener("click", () => {
        if (cropper) {
          cropper.zoom(0.1);
        }
      });
      document.getElementById("zoomOut").addEventListener("click", () => {
        if (cropper) {
          cropper.zoom(-0.1);
        }
      });
      document.getElementById("resetCropper").addEventListener("click", () => {
        if (cropper) {
          cropper.reset();
        }
      });
    });
  </script>

</body>
</html>
</x-navbar>
