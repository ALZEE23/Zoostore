<x-layout>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Halaman Pengaturan E-Commerce</title>
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .fade-in {
      animation: fadeIn 0.6s ease-in-out;
    }
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
<body class="bg-gray-50 text-gray-900 transition duration-300">

  <!-- Header & Role Selector -->
  <div class="container mx-auto px-4 sm:px-6 md:px-8 p-4 flex flex-col sm:flex-row items-center justify-between">
    <h1 class="text-3xl font-bold mb-4 sm:mb-0">Pengaturan Website E-Commerce</h1>
    <div class="flex items-center space-x-2">
      <label for="roleSelect" class="font-semibold">Login sebagai:</label>
      <select id="roleSelect" class="border border-gray-300 rounded-md px-3 py-1 focus:outline-none">
        <option value="user" selected>User</option>
        <option value="admin">Admin</option>
      </select>
    </div>
  </div>

  <!-- Grid Card Pengaturan -->
  <div class="container mx-auto px-4 sm:px-6 md:px-8 p-4">
    <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
      <!-- Card Template -->
      <template id="card-template">
        <div class="fade-in text-left w-full rounded-2xl border border-gray-300 p-4 bg-white hover:shadow-xl hover:border-gray-500 transition duration-200">
          <h2 class="text-xl font-semibold mb-2"></h2>
          <ul class="list-disc list-inside space-y-1 text-sm mb-3"></ul>
          <button class="open-modal-btn mt-3 inline-block px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800 transition">
            Open Setting
          </button>
        </div>
      </template>
      <!-- Container for the cards -->
      <div id="settings-container" class="contents"></div>
    </div>
  </div>

  <!-- Modal (Pengaturan) -->
  <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 p-4">
    <div class="bg-white text-black rounded-xl p-6 w-full max-w-md sm:max-w-lg shadow-xl relative">
      <div class="flex justify-between items-center mb-4">
        <h3 id="modal-title" class="text-xl font-semibold"></h3>
        <button onclick="toggleSettingsModal(false)" class="text-gray-600 hover:text-black text-2xl leading-none">&times;</button>
      </div>
      <div id="modal-content" class="space-y-3">
        <!-- Diisi oleh JS -->
      </div>
    </div>
  </div>

  <!-- Modal Password untuk login Admin -->
  <div id="passwordModal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center hidden z-50 p-4">
    <div class="bg-white rounded-xl p-6 w-full max-w-sm shadow-xl">
      <h3 class="text-xl font-semibold mb-4">Masuk sebagai Admin</h3>
      <p class="mb-4">Silahkan masukkan password:</p>
      <input id="passwordInput" type="password" placeholder="Password" class="w-full border border-gray-300 p-2 rounded-md focus:outline-none focus:border-black">
      <p id="passwordError" class="text-red-500 text-sm mt-2 hidden">Password salah. Silahkan coba lagi.</p>
      <div class="flex justify-end space-x-3 mt-4">
        <button id="cancelPassword" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition">Batal</button>
        <button id="submitPassword" class="px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800 transition">Submit</button>
      </div>
    </div>
  </div>

  <script>
    // ==============================
    // Global State Simulasi
    // ==============================
    let state = {
      // Contoh data
      products: [
        { name: "Produk A", price: 100000, stock: 10 },
        { name: "Produk B", price: 150000, stock: 5 }
      ],
      wishlist: ["Produk X", "Produk Y"],
      orders: [
        { id: "ORD123", status: "pending" },
        { id: "ORD124", status: "dikirim" }
      ],
      loyaltyPoints: 120,
      // Toggle 2FA
      is2faEnabled: false,
      // To-do list
      tasks: [
        { id: 1, text: "Coba Beli Produk A", done: false },
        { id: 2, text: "Review Produk B", done: false }
      ]
    };

    // ==============================
    // Data Pengaturan
    // ==============================
    const data = [
      {
        title: 'Pengaturan Produk',
        items: [
          'Tambah/Edit/Hapus Produk (Admin Only)',
          'Stok Barang (Admin Only)',
          'Variasi Produk (warna, ukuran) (Admin Only)',
          'Kategori & Tag Produk (Admin Only)',
          'Harga & Diskon (Admin Only)',
        ],
        actions: [
          {
            label: 'Tambah Produk',
            description: 'Form untuk menambah produk baru.',
            adminOnly: true,
          },
          {
            label: 'Cek Stok',
            description: 'Tampilkan stok produk terbaru.',
            adminOnly: true,
          }
        ]
      },
      {
        title: 'Pengaturan Pengguna',
        items: [
          'Manajemen Akun Pelanggan (Admin Only)',
          'Hak Akses Admin/Staff (Admin Only)',
          'Histori Pembelian User (User & Admin)',
          'Wish List / Favorit (User Only)'
        ],
        actions: [
          {
            label: 'Lihat Wish List',
            description: 'Tampilkan produk di wishlist pengguna.',
            userOnly: true,
          },
          {
            label: 'Kelola Akun Pelanggan',
            description: 'Tambah/Hapus user, atur role, dsb.',
            adminOnly: true,
          }
        ]
      },
      {
        title: 'Pengaturan Pembayaran',
        items: [
          'Metode Pembayaran (User & Admin)',
          'Integrasi Payment Gateway (Admin Only)',
          'Pengaturan Mata Uang (Admin Only)',
          'Pajak (Admin Only)'
        ],
        actions: [
          {
            label: 'Update Metode Pembayaran',
            description: 'User dapat menambah/menghapus metode pembayaran pribadi.',
            userOnly: true,
          },
          {
            label: 'Atur Payment Gateway',
            description: 'Integrasi Payment Gateway hanya boleh dikelola oleh admin.',
            adminOnly: true,
          }
        ]
      },
      {
        title: 'Pengaturan Pengiriman',
        items: [
          'Ongkir (Admin Only)',
          'Jasa Kurir (Admin Only)',
          'Zona Pengiriman (Admin Only)',
          'Estimasi Pengiriman (User & Admin)'
        ],
        actions: [
          {
            label: 'Cek Estimasi Pengiriman',
            description: 'User dapat cek estimasi pengiriman berdasar lokasi.',
            userOnly: true,
          },
          {
            label: 'Atur Kurir',
            description: 'Admin mengatur jasa kurir yang tersedia.',
            adminOnly: true,
          }
        ]
      },
      {
        title: 'Pengaturan Pesanan',
        items: [
          'Status Pesanan (User & Admin)',
          'Notifikasi Pembeli (Admin Only)',
          'Invoice & Tracking (User & Admin)',
          'Retur Barang (User & Admin)'
        ],
        actions: [
          {
            label: 'Lihat Status Pesanan',
            description: 'User melihat status pesanan yang sedang berjalan.',
            userOnly: true,
          },
          {
            label: 'Konfirmasi Pengiriman',
            description: 'Admin konfirmasi paket telah dikirim.',
            adminOnly: true,
          }
        ]
      },
      {
        title: 'Pengaturan Tampilan',
        items: [
          'Tema/Layout Website (Admin Only)',
          'Banner Promo (Admin Only)',
          'Homepage Carousel (Admin Only)',
          'Warna/Font/Logo (Admin Only)'
        ],
        actions: [
          {
            label: 'Kustom Tema',
            description: 'Admin mengubah tema, warna, dan font website.',
            adminOnly: true,
          }
        ]
      },
      {
        title: 'Pengaturan Promosi',
        items: [
          'Kode Voucher (Admin Only)',
          'Flash Sale (Admin Only)',
          'Integrasi Iklan (Admin Only)',
          'Sistem Poin/Loyalty (User & Admin)'
        ],
        actions: [
          {
            label: 'Cek Poin Saya',
            description: 'User melihat jumlah poin loyalty yang dimiliki.',
            userOnly: true,
          },
          {
            label: 'Buat Flash Sale Baru',
            description: 'Admin membuat event flash sale baru.',
            adminOnly: true,
          }
        ]
      },
      {
        title: 'Pengaturan Analitik',
        items: [
          'Dashboard Penjualan (Admin Only)',
          'Laporan Pendapatan (Admin Only)',
          'Produk Terlaris (Admin Only)',
          'Pengunjung & Konversi (Admin Only)'
        ],
        actions: [
          {
            label: 'Lihat Ringkasan Laporan',
            description: 'Admin melihat laporan pendapatan dan penjualan.',
            adminOnly: true,
          }
        ]
      },
      {
        title: 'Pengaturan Keamanan',
        items: [
          'Login 2FA (User & Admin)',
          'Enkripsi Data (Admin Only)',
          'Log Aktivitas Admin (Admin Only)',
          'Proteksi dari Fraud (Admin Only)'
        ],
        actions: [
          {
            label: 'Aktifkan 2FA',
            description: 'User dapat menyalakan/mematikan 2FA di akunnya.',
            userOnly: true,
          },
          {
            label: 'Pantau Log Admin',
            description: 'Admin memantau log aktivitas admin yang lain.',
            adminOnly: true,
          }
        ]
      },
      // Tambahkan satu menu untuk To-do List
      {
        title: 'Pengaturan Tools',
        items: [
          'To-do List (User & Admin)'
        ],
        actions: [
          {
            label: 'Kelola To-do List',
            description: 'Tambah, hapus, dan tandai task to-do.',
            // Boleh diakses oleh user maupun admin
          }
        ]
      }
    ];

    // ==============================
    // Elemen DOM
    // ==============================
    const container = document.getElementById('settings-container');
    const template = document.getElementById('card-template');
    const modal = document.getElementById('modal');
    const modalTitle = document.getElementById('modal-title');
    const modalContent = document.getElementById('modal-content');
    const roleSelect = document.getElementById('roleSelect');
    const passwordModal = document.getElementById('passwordModal');
    const passwordInput = document.getElementById('passwordInput');
    const passwordError = document.getElementById('passwordError');
    const cancelPassword = document.getElementById('cancelPassword');
    const submitPassword = document.getElementById('submitPassword');

    // Simpan role sebelumnya untuk revert jika validasi gagal
    let previousRole = 'user';

    // ==============================
    // Fungsi Simulasi Aksi dengan Logika Tambahan
    // ==============================
    function simulateAction(action) {
      modalContent.innerHTML = ""; // Bersihkan konten modal

      // Judul aksi
      const heading = document.createElement('h4');
      heading.classList.add('text-xl', 'font-semibold', 'mb-4');
      heading.textContent = action.label;
      modalContent.appendChild(heading);

      // Cek label aksi agar bisa menampilkan simulasi berbeda
      if (action.label.toLowerCase().includes("aktifkan 2fa")) {
        // Tampilkan status 2FA sekarang, dan tombol toggle
        const statusP = document.createElement('p');
        statusP.classList.add('mb-4');
        statusP.textContent = state.is2faEnabled 
          ? "2FA saat ini: AKTIF. Ingin mematikannya?" 
          : "2FA saat ini: NON-AKTIF. Ingin mengaktifkannya?";
        modalContent.appendChild(statusP);

        const toggleBtn = document.createElement('button');
        toggleBtn.classList.add('px-4','py-2','bg-black','text-white','rounded-md','hover:bg-gray-800','transition');
        toggleBtn.textContent = state.is2faEnabled ? "Matikan 2FA" : "Aktifkan 2FA";
        toggleBtn.addEventListener('click', () => {
          state.is2faEnabled = !state.is2faEnabled;
          alert(`Sekarang 2FA di akun ini: ${state.is2faEnabled ? "AKTIF" : "NON-AKTIF"}`);
          toggleSettingsModal(true, modalTitle.textContent, action.parentActions || []);
        });
        modalContent.appendChild(toggleBtn);

      } else if (action.label.toLowerCase().includes("kelola to-do list")) {
        // Tampilkan to-do list + form input
        renderTodoListUI(action);
        
      } else if (action.label.toLowerCase().includes("tambah produk")) {
        // Form menambah produk
        const form = document.createElement('form');
        form.innerHTML = `
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Nama Produk:</label>
            <input type="text" id="prodName" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:border-black" required>
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Harga:</label>
            <input type="number" id="prodPrice" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:border-black" required>
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Stok:</label>
            <input type="number" id="prodStock" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:border-black" required>
          </div>
          <button type="submit" class="px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800 transition">Submit</button>
        `;
        form.addEventListener('submit', function(e) {
          e.preventDefault();
          // Ambil data dari form
          const name = document.getElementById('prodName').value;
          const price = parseInt(document.getElementById('prodPrice').value);
          const stock = parseInt(document.getElementById('prodStock').value);
          // Simpan produk ke state
          state.products.push({ name, price, stock });
          alert(`Produk "${name}" berhasil ditambahkan!`);
          // Kembali ke menu aksi
          toggleSettingsModal(true, modalTitle.textContent, action.parentActions || []);
        });
        modalContent.appendChild(form);

      } else if (action.label.toLowerCase().includes("cek stok")) {
        // Daftar stok produk
        const list = document.createElement('ul');
        list.classList.add('list-disc', 'list-inside', 'mb-4');
        if (state.products.length > 0) {
          state.products.forEach(prod => {
            const li = document.createElement('li');
            li.textContent = `${prod.name}: ${prod.stock} unit (Harga: Rp${prod.price})`;
            list.appendChild(li);
          });
        } else {
          const li = document.createElement('li');
          li.textContent = "Belum ada produk yang ditambahkan.";
          list.appendChild(li);
        }
        modalContent.appendChild(list);

      } else if (action.label.toLowerCase().includes("lihat wish list")) {
        // Tampilkan wishlist
        const list = document.createElement('ul');
        list.classList.add('list-disc', 'list-inside', 'mb-4');
        if (state.wishlist.length > 0) {
          state.wishlist.forEach(item => {
            const li = document.createElement('li');
            li.textContent = item;
            list.appendChild(li);
          });
        } else {
          const li = document.createElement('li');
          li.textContent = "Wishlist masih kosong.";
          list.appendChild(li);
        }
        modalContent.appendChild(list);

      } else if (action.label.toLowerCase().includes("update metode pembayaran")) {
        // Simulasi update metode pembayaran
        const form = document.createElement('form');
        form.innerHTML = `
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Metode Pembayaran Baru:</label>
            <input type="text" id="paymentMethod" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:border-black" placeholder="E-wallet, Kartu Kredit, dsb." required>
          </div>
          <button type="submit" class="px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800 transition">Perbarui</button>
        `;
        form.addEventListener('submit', function(e) {
          e.preventDefault();
          const method = document.getElementById('paymentMethod').value;
          alert(`Metode pembayaran telah di-update ke: "${method}" (simulasi).`);
          toggleSettingsModal(true, modalTitle.textContent, action.parentActions || []);
        });
        modalContent.appendChild(form);

      } else if (action.label.toLowerCase().includes("konfirmasi pengiriman")) {
        // Simulasi konfirmasi pengiriman
        if (state.orders.length > 0) {
          const list = document.createElement('ul');
          list.classList.add('list-disc', 'list-inside', 'mb-4');
          state.orders.forEach(order => {
            const li = document.createElement('li');
            li.textContent = `Order ID ${order.id} - Status: ${order.status}`;
            list.appendChild(li);
          });
          modalContent.appendChild(list);
          const confirmBtn = document.createElement('button');
          confirmBtn.classList.add('mt-2','px-4','py-2','bg-black','text-white','rounded-md','hover:bg-gray-800','transition');
          confirmBtn.textContent = 'Konfirmasi Pengiriman Order Pertama';
          confirmBtn.addEventListener('click', () => {
            if(state.orders.length > 0) {
              state.orders[0].status = 'dikonfirmasi';
              alert(`Order ${state.orders[0].id} telah dikonfirmasi pengirimannya (simulasi)`);
              toggleSettingsModal(true, modalTitle.textContent, action.parentActions || []);
            }
          });
          modalContent.appendChild(confirmBtn);
        } else {
          const msg = document.createElement('p');
          msg.textContent = "Tidak ada order untuk dikonfirmasi.";
          modalContent.appendChild(msg);
        }

      } else if (action.label.toLowerCase().includes("cek poin saya")) {
        const msg = document.createElement('p');
        msg.textContent = `Anda memiliki ${state.loyaltyPoints} poin loyalty.`;
        modalContent.appendChild(msg);

      } else {
        // Aksi default
        const msg = document.createElement('p');
        msg.textContent = `Simulasi aksi "${action.label}" berhasil dijalankan.`;
        modalContent.appendChild(msg);
      }

      // Tombol "Kembali ke Pengaturan"
      const backButton = document.createElement('button');
      backButton.classList.add('mt-4','px-4','py-2','bg-gray-500','text-white','rounded-md','hover:bg-gray-600','transition');
      backButton.textContent = 'Kembali ke Pengaturan';
      backButton.addEventListener('click', () => {
        toggleSettingsModal(true, modalTitle.textContent, action.parentActions || []);
      });
      modalContent.appendChild(backButton);
    }

    // ==============================
    // Fungsi Render To-do List
    // ==============================
    function renderTodoListUI(action) {
      // Tampilkan daftar tasks
      const taskList = document.createElement('ul');
      taskList.classList.add('list-disc','list-inside','mb-4');

      // Jika belum ada tasks
      if (state.tasks.length === 0) {
        const emptyItem = document.createElement('li');
        emptyItem.textContent = "Belum ada tugas (task).";
        taskList.appendChild(emptyItem);
      } else {
        state.tasks.forEach(task => {
          const li = document.createElement('li');
          li.classList.add('flex','justify-between','items-center','mb-2');
          
          const span = document.createElement('span');
          span.textContent = (task.done ? "[Selesai] " : "") + task.text;
          li.appendChild(span);

          // Tombol "Done"/"Undo"
          const doneBtn = document.createElement('button');
          doneBtn.classList.add('ml-2','px-2','py-1','bg-green-600','text-white','rounded','hover:bg-green-700','transition');
          doneBtn.textContent = task.done ? "Undo" : "Done";
          doneBtn.addEventListener('click', () => {
            task.done = !task.done;
            toggleSettingsModal(true, modalTitle.textContent, action.parentActions || []);
          });
          li.appendChild(doneBtn);

          // Tombol "Delete"
          const delBtn = document.createElement('button');
          delBtn.classList.add('ml-2','px-2','py-1','bg-red-600','text-white','rounded','hover:bg-red-700','transition');
          delBtn.textContent = "Delete";
          delBtn.addEventListener('click', () => {
            // Hapus task dari state
            state.tasks = state.tasks.filter(t => t.id !== task.id);
            toggleSettingsModal(true, modalTitle.textContent, action.parentActions || []);
          });
          li.appendChild(delBtn);

          taskList.appendChild(li);
        });
      }
      modalContent.appendChild(taskList);

      // Form tambah task
      const form = document.createElement('form');
      form.innerHTML = `
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Tambah Task Baru:</label>
          <input type="text" id="newTask" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:border-black" placeholder="Isi tugas..." required>
        </div>
        <button type="submit" class="px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800 transition">Tambah</button>
      `;
      form.addEventListener('submit', (e) => {
        e.preventDefault();
        const newTaskText = document.getElementById('newTask').value;
        const newId = Date.now(); // ID unik sederhana
        state.tasks.push({ id: newId, text: newTaskText, done: false });
        toggleSettingsModal(true, modalTitle.textContent, action.parentActions || []);
      });
      modalContent.appendChild(form);
    }

    // ==============================
    // Modal Pengaturan Handler
    // ==============================
    function toggleSettingsModal(show, title = '', actions = []) {
      if (!show) {
        modal.classList.add('hidden');
        return;
      }
      modal.classList.remove('hidden');
      modalTitle.textContent = title;
      modalContent.innerHTML = '';

      const currentRole = roleSelect.value;
      if (actions && actions.length > 0) {
        actions.forEach(action => {
          // Filter role
          if (action.adminOnly && currentRole !== 'admin') return;
          if (action.userOnly && currentRole !== 'user') return;

          const actionDiv = document.createElement('div');
          actionDiv.classList.add('p-3','border','border-gray-200','rounded-md','mb-3');
          
          const label = document.createElement('h4');
          label.classList.add('font-semibold','mb-1');
          label.textContent = action.label;
          
          const desc = document.createElement('p');
          desc.classList.add('text-sm','text-gray-600');
          desc.textContent = action.description;

          const btn = document.createElement('button');
          btn.classList.add('mt-2','px-4','py-2','rounded-md','bg-black','text-white','hover:bg-gray-800','transition');
          btn.textContent = 'Coba Aksi';
          btn.addEventListener('click', () => {
            // Simpan daftar aksi induk agar kita bisa kembali
            action.parentActions = actions;
            simulateAction(action);
          });

          actionDiv.appendChild(label);
          actionDiv.appendChild(desc);
          actionDiv.appendChild(btn);
          modalContent.appendChild(actionDiv);
        });
      } else {
        const info = document.createElement('p');
        info.textContent = 'Tidak ada aksi khusus untuk pengaturan ini.';
        modalContent.appendChild(info);
      }
    }

    // ==============================
    // Render Kartu Pengaturan
    // ==============================
    function renderCards() {
      container.innerHTML = '';
      const currentRole = roleSelect.value;

      data.forEach(setting => {
        const card = template.content.cloneNode(true);
        const titleEl = card.querySelector('h2');
        const listEl = card.querySelector('ul');
        const openModalBtn = card.querySelector('.open-modal-btn');

        titleEl.textContent = setting.title;
        listEl.innerHTML = '';

        // Filter item "Admin Only" atau "User Only"
        setting.items.forEach(item => {
          const isAdminOnly = item.toLowerCase().includes('(admin only)');
          const isUserOnly = item.toLowerCase().includes('(user only)');
          if (isAdminOnly && currentRole !== 'admin') return;
          if (isUserOnly && currentRole !== 'user') return;

          const li = document.createElement('li');
          li.textContent = item.replace(' (Admin Only)', '').replace(' (User Only)', '');
          listEl.appendChild(li);
        });

        // Jika tidak ada item muncul, beri pesan
        if (!listEl.hasChildNodes()) {
          const li = document.createElement('li');
          li.textContent = 'Tidak ada pengaturan yang dapat diakses.';
          listEl.appendChild(li);
        }

        // Buka modal pengaturan
        openModalBtn.addEventListener('click', () => {
          toggleSettingsModal(true, setting.title, setting.actions);
        });
        container.appendChild(card);
      });
    }

    // ==============================
    // Password Modal Handlers
    // ==============================
    function openPasswordModal() {
      passwordInput.value = '';
      passwordError.classList.add('hidden');
      passwordModal.classList.remove('hidden');
      passwordInput.focus();
    }
    function closePasswordModal() {
      passwordModal.classList.add('hidden');
    }

    // ==============================
    // Event Listeners
    // ==============================
    roleSelect.addEventListener('change', () => {
      if (roleSelect.value === 'admin') {
        openPasswordModal();
      } else {
        previousRole = 'user';
        renderCards();
      }
    });

    cancelPassword.addEventListener('click', () => {
      closePasswordModal();
      roleSelect.value = previousRole;
      renderCards();
    });

    submitPassword.addEventListener('click', () => {
      const pass = passwordInput.value;
      if (pass !== 'lenovoadmin123') {
        passwordError.classList.remove('hidden');
      } else {
        closePasswordModal();
        previousRole = 'admin';
        renderCards();
      }
    });

    // Inisialisasi awal
    renderCards();
  </script>
</body>
</html>
</x-layout>
