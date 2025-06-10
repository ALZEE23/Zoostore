<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Zoes Store</title>

  <!-- font awesome -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
  />

  <!-- tailwind css -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    /* dropdown animasi (desktop) */
    .dropdown-enter { transform: scale(0); opacity: 0; transform-origin: top center; }
    .dropdown-enter-active { transition: transform .2s ease, opacity .2s ease; transform: scale(1); opacity:1; }

    /* animasi modal */
    @keyframes fadeIn { from{opacity:0;} to{opacity:1;} }
    @keyframes zoomIn { from{transform:scale(0.95);} to{transform:scale(1);} }
    .animate-fadeIn { animation: fadeIn .3s ease-out forwards; }
    .animate-zoomIn { animation: zoomIn .3s ease-out forwards; }

    /* animasi drawer mobile */
    @keyframes slideDrawer{0%{transform:translateX(-100%);opacity:0;}100%{transform:translateX(0);opacity:1;}}
    @keyframes hideDrawer{0%{transform:translateX(0);opacity:1;}100%{transform:translateX(-100%);opacity:0;}}
    .animate-slideDrawer{animation:slideDrawer .3s ease forwards;}
    .animate-hideDrawer{animation:hideDrawer .3s ease forwards;}

    /* animasi oops drawer */
    @keyframes slideOops{0%{transform:translateX(100%);opacity:0;}100%{transform:translateX(0);opacity:1;}}
    @keyframes hideOops{0%{transform:translateX(0);opacity:1;}100%{transform:translateX(100%);opacity:0;}}
    .animate-slideOops{animation:slideOops .3s ease forwards;}
    .animate-hideOops{animation:hideOops .3s ease forwards;}
  </style>
</head>
<body class="flex flex-col min-h-screen bg-gray-100">
  <!-- navbar fixed -->
  <header class="fixed top-0 left-0 w-full bg-white/90 backdrop-blur-md shadow-md z-20">
    <div class="max-w-7xl mx-auto px-4 md:px-8 py-4 flex items-center justify-between">
      <button onclick="window.location.href='/'" class="text-2xl font-extrabold hover:text-gray-700 focus:outline-none">Zoes</button>
      <nav class="hidden md:flex items-center space-x-6 text-lg font-medium">
        <a href="/" class="hover:text-gray-700">Home</a>
        @auth
          <a href="/shop" class="hover:text-gray-700">Shop</a>
          <a href="/faqs" class="hover:text-gray-700">Faqs</a>
          <a href="/product_ratings" class="hover:text-gray-700">Ratings</a>
        @else
          <a href="javascript:void(0)" onclick="showOopsDrawer()" class="hover:text-gray-700">Shop</a>
          <a href="javascript:void(0)" onclick="showOopsDrawer()" class="hover:text-gray-700">Faqs</a>
          <a href="javascript:void(0)" onclick="showOopsDrawer()" class="hover:text-gray-700">Ratings</a>
        @endauth
      </nav>
      <div class="hidden md:flex items-center space-x-4">
        @auth
          <!-- Cart icon -->
          <a href="{{ route('cart.index') }}" class="p-2 rounded-full text-xl hover:text-gray-700 hover:bg-gray-200 focus:outline-none">
            <i class="fas fa-shopping-cart"></i>
          </a>
        @else
          {{-- <button onclick="showOopsDrawer()" class="p-2 rounded-full text-xl hover:text-gray-700 hover:bg-gray-200 focus:outline-none">
            <i class="fas fa-search"></i>
          </button> --}}
          <!-- Cart icon untuk guest -->
          <a href="javascript:void(0)" onclick="showOopsDrawer()" class="p-2 rounded-full text-xl hover:text-gray-700 hover:bg-gray-200 focus:outline-none">
            <i class="fas fa-shopping-cart"></i>
          </a>
        @endauth
        <div class="relative inline-block">
          <button id="userMenuBtn" class="flex items-center gap-2 px-4 py-2 rounded-md shadow bg-gradient-to-r from-white/50 to-white/20 border border-white/30 hover:from-white/70 hover:to-white/40 transition-all">
            <i class="fas fa-user"></i>
            <span class="font-semibold">
              @guest Login / Register @else My Account @endguest
            </span>
          </button>
          <div id="userDropdown" class="hidden absolute top-full left-1/2 transform -translate-x-1/2 mt-2 w-52 bg-white text-gray-700 border border-gray-200 rounded-lg shadow-lg py-2 dropdown-enter">
            @guest
              <a href="{{ route('login') }}" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100">
                <i class="fas fa-sign-in-alt"></i> Login
              <a href="{{ route('login') }}" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100">
                <i class="fas fa-sign-in-alt"></i> Login Admin
              <a href="{{ route('register') }}" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100">
                <i class="fas fa-user-plus"></i> Register
              </a>
            @else
              <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100">
                <i class="fas fa-user"></i> Profile
              </a>
              <a href="{{ route('user.orders.index') }}" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100">
                <i class="fas fa-shopping-bag"></i> Pesanan Saya
              </a>
              <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 text-red-600 hover:text-red-800">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
              </form>
            @endguest
          </div>
        </div>
      </div>
      <button id="menu-btn" class="md:hidden text-2xl focus:outline-none"><i class="fas fa-bars"></i></button>
    </div>
  </header>

  <!-- mobile menu -->
  <div id="mobile-menu-overlay" class="fixed inset-0 bg-black opacity-50 hidden z-40"></div>
  <aside id="mobile-menu-drawer" class="fixed inset-y-0 left-0 w-64 bg-white shadow-md transform -translate-x-full z-50">
    <div class="p-4">
      <button id="closeMenuBtn" class="text-2xl mb-4 focus:outline-none"><i class="fas fa-times"></i></button>
      <nav class="flex flex-col space-y-4 text-lg font-medium">
        <a href="/" class="hover:text-gray-700">Home</a>
        @auth
          <a href="{{ route('shop.index') }}" class="hover:text-gray-700">Shop</a>
          <a href="{{ route('faqs.index') }}" class="hover:text-gray-700">Faqs</a>
        @else
          <a href="javascript:void(0)" onclick="showOopsDrawer()" class="hover:text-gray-700">Shop</a>
          <a href="javascript:void(0)" onclick="showOopsDrawer()" class="hover:text-gray-700">Faqs</a>
        @endauth
      </nav>
      <div class="mt-6 border-t pt-4">
        <button id="mobileUserBtn" class="flex items-center gap-2 w-full text-left text-lg focus:outline-none">
          <i class="fas fa-user"></i> @guest Login / Register @else My Account @endguest
        </button>
        <div id="mobileUserDropdown" class="hidden flex-col mt-2">
          @guest
            <a href="{{ route('login') }}" class="px-2 py-1 hover:bg-gray-100">Login</a>
            <a href="{{ route('register') }}" class="px-2 py-1 hover:bg-gray-100">Register</a>
          @else
            <a href="/profile" class="px-2 py-1 hover:bg-gray-100">Profile</a>
            <a href="{{ route('user.orders.index') }}" class="px-2 py-1 hover:bg-gray-100">
                <i class="fas fa-shopping-bag mr-2"></i>Pesanan Saya
            </a>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                class="px-2 py-1 hover:bg-gray-100 text-red-600 hover:text-red-800">Logout</a>
          @endauth
        </div>
      </div>
      <div class="mt-6 flex flex-col gap-2">
        @auth
          {{-- <button class="w-full p-2 rounded-md bg-gray-200 text-left search-trigger">
            <i class="fas fa-search mr-2"></i> Cari Produk
          </button> --}}
        @else
          {{-- <button onclick="showOopsDrawer()" class="w-full p-2 rounded-md bg-gray-200 text-left">
            <i class="fas fa-search mr-2"></i> Cari Produk
          </button> --}}
        @endauth
        <!-- Cart icon Mobile -->
        <a href="{{ route('cart.index') }}" class="w-full p-2 rounded-md bg-gray-200 text-left">
          <i class="fas fa-shopping-cart mr-2"></i> Keranjang
        </a>
      </div>
    </div>
  </aside>

  <!-- konten utama -->
  <main class="flex-1 pt-20 container mx-auto px-4 py-8">
    {{ $slot }}
  </main>

  @auth
  <!-- footer -->
  <footer class="mt-auto bg-black text-white">
    <div class="container mx-auto px-8 py-10 flex flex-wrap justify-between gap-8">
      <!-- kiri -->
      <div class="flex-1 min-w-[250px]">
        <h2 class="text-xl font-semibold mb-4">Zoes</h2>
        <p class="mb-2">Temukan koleksi sepatu bayi terbaik untuk langkah kecil si kecil. Nyaman, stylish, dan aman untuk menemani petualangan pertama mereka.</p>
        <p class="mb-4">&copy; 2025 Zoes. Semua hak dilindungi.</p>
        <div class="flex gap-4">
          <a href="#" class="text-2xl hover:scale-110 transform transition"><i class="fab fa-facebook"></i></a>
          <a href="#" class="text-2xl hover:scale-110 transform transition"><i class="fab fa-instagram"></i></a>
        </div>
      </div>
      <!-- tengah -->
      {{-- <div class="flex-1 min-w-[300px]">
        <h3 class="text-lg font-semibold mb-4">Contact</h3>
        <form action="#" method="POST" class="flex flex-col gap-3">
          <!-- @csrf kalau pake laravel -->
          <input
            type="text"
            name="name"
            placeholder="Nama Anda..."
            required
            class="p-2 rounded-md bg-gray-200 text-black placeholder-black focus:outline-none"
          />
          <input
            type="email"
            name="email"
            placeholder="Email Anda..."
            required
            class="p-2 rounded-md bg-gray-200 text-black placeholder-black focus:outline-none"
          />
          <textarea
            name="message"
            placeholder="Pesan Anda..."
            required
            class="p-2 rounded-md bg-gray-200 text-black placeholder-black focus:outline-none h-24 resize-none"
          ></textarea>
          <button
            type="submit"
            class="mt-2 p-2 bg-white text-black rounded-md hover:bg-gray-100 transition"
          >
            Kirim Pesan
          </button>
        </form>
      </div> --}}
    </div>
  </footer>
  @endauth

  <!-- oops drawer -->
  <div id="oopsOverlay" class="hidden fixed inset-0 bg-black/50 z-50"></div>
  <div id="oopsDrawer" class="hidden fixed inset-y-0 right-0 w-full sm:w-96 bg-white shadow-2xl z-50 flex flex-col animate-slideOops" style="max-width:400px">
    <div class="p-6 flex-1 flex flex-col justify-center items-center text-center">
      <h1 class="text-2xl font-bold mb-4">Oops, Anda Harus Login Dulu</h1>
      <p class="mb-6">
        Silakan <a href="{{ route('login') }}" class="underline text-blue-500">Login</a> atau
        <a href="{{ route('register') }}" class="underline text-blue-500">Register</a> untuk mengakses halaman ini.
      </p>
      <button onclick="hideOopsDrawer()" class="px-4 py-2 border rounded hover:bg-gray-100 transition">Tutup</button>
    </div>
  </div>

  <!-- search modal -->
  <div id="searchModal" class="fixed inset-0 z-50 hidden flex items-start justify-center pt-10 px-4 bg-white/95 animate-fadeIn">
    <div class="relative w-full max-w-md p-6 bg-white rounded-xl shadow-2xl animate-zoomIn">
      <button id="closeSearch" class="absolute top-3 right-3 text-2xl text-gray-700 hover:text-gray-900 focus:outline-none">
        <i class="fas fa-times"></i>
      </button>
      <h2 class="text-xl font-semibold mb-4 text-gray-700">Cari Produk</h2>
      <div class="relative">
        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
          <i class="fas fa-search"></i>
        </span>
        <input id="searchInput" type="text" placeholder="Cari Produk..." class="w-full pl-10 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" />
      </div>
    </div>
  </div>

  <!-- scripts -->
  <script>
    // elements
    const menuBtn = document.getElementById('menu-btn');
    const closeMenuBtn = document.getElementById('closeMenuBtn');
    const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
    const mobileMenuDrawer = document.getElementById('mobile-menu-drawer');
    const userMenuBtn = document.getElementById('userMenuBtn');
    const userDropdown = document.getElementById('userDropdown');
    const mobileUserBtn = document.getElementById('mobileUserBtn');
    const mobileUserDropdown = document.getElementById('mobileUserDropdown');
    const oopsOverlay = document.getElementById('oopsOverlay');
    const oopsDrawer = document.getElementById('oopsDrawer');
    const searchTriggers = document.querySelectorAll('.search-trigger');
    const searchModal = document.getElementById('searchModal');
    const closeSearch = document.getElementById('closeSearch');
    const searchInput = document.getElementById('searchInput');

    // oops drawer
    function showOopsDrawer() {
      oopsOverlay.classList.remove('hidden');
      oopsDrawer.classList.remove('hidden','animate-hideOops');
      oopsDrawer.classList.add('animate-slideOops');
    }
    function hideOopsDrawer() {
      oopsDrawer.classList.remove('animate-slideOops');
      oopsDrawer.classList.add('animate-hideOops');
      setTimeout(()=>{
        oopsDrawer.classList.add('hidden');
        oopsOverlay.classList.add('hidden');
      },300);
    }
    oopsOverlay.addEventListener('click', hideOopsDrawer);

    // mobile menu
    menuBtn.addEventListener('click', ()=>{
      mobileMenuOverlay.classList.remove('hidden');
      mobileMenuDrawer.classList.remove('-translate-x-full');
      mobileMenuDrawer.classList.add('animate-slideDrawer');
    });
    function hideMobileMenu() {
      mobileMenuOverlay.classList.add('hidden');
      mobileMenuDrawer.classList.remove('animate-slideDrawer');
      mobileMenuDrawer.classList.add('animate-hideDrawer');
      setTimeout(()=>{
        mobileMenuDrawer.classList.add('-translate-x-full');
        mobileMenuDrawer.classList.remove('animate-hideDrawer');
      },300);
    }
    closeMenuBtn?.addEventListener('click', hideMobileMenu);
    mobileMenuOverlay?.addEventListener('click', hideMobileMenu);

    // desktop user dropdown
    userMenuBtn.addEventListener('click', e=>{
      e.stopPropagation();
      userDropdown.classList.toggle('hidden');
      userDropdown.classList.toggle('dropdown-enter-active');
    });
    document.addEventListener('click', e=>{
      if(!userDropdown.contains(e.target) && !userMenuBtn.contains(e.target)){
        userDropdown.classList.add('hidden');
        userDropdown.classList.remove('dropdown-enter-active');
      }
    });

    // mobile user dropdown
    mobileUserBtn?.addEventListener('click', e=>{
      e.stopPropagation();
      mobileUserDropdown.classList.toggle('hidden');
    });
    document.addEventListener('click', e=>{
      if(mobileUserDropdown && !mobileUserDropdown.contains(e.target) && !mobileUserBtn.contains(e.target)){
        mobileUserDropdown.classList.add('hidden');
      }
    });

    // search modal
    searchTriggers.forEach(trigger=>{
      trigger.addEventListener('click', e=>{
        e.stopPropagation();
        searchModal.classList.remove('hidden');
        searchInput.focus();
      });
    });
    closeSearch.addEventListener('click', ()=> searchModal.classList.add('hidden'));
    searchModal.addEventListener('click', e=>{
      if(e.target===searchModal) searchModal.classList.add('hidden');
    });
    searchInput.addEventListener('keydown', e => {
        if(e.key === 'Enter') {
            e.preventDefault();
            const query = searchInput.value.trim();
            if(query) {
                window.location.href = `{{ route('shop.index') }}?search=${encodeURIComponent(query)}`;
            }
        }
    });
  </script>
</body>
</html>
