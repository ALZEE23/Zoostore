<x-layout>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Zoes Store</title>
  <link href="{{ asset('asset-landing-admin/css/dashboard-user.css') }}" rel="stylesheet" />
</head>
<body>
  <!-- HERO SECTION -->
  <section class="hero">
    <div class="hero-text">
      <h1>SELAMAT DATANG DI ZOES STORE!</h1>
      <p>Koleksi Sepatu Stylish Untuk Si Kecil, Anak Perempuan & Laki-Laki!</p>
    </div>
    <div class="hero-image">
      <img src="{{ asset('/assets/shozo.png') }}" alt="Sepatu">
    </div>
  </section>


  <!-- CUSTOMER REVIEW SECTION -->
  <section class="customer-review">
    <h2>— Customer Review —</h2>
    <div class="review-container">
      <div class="review-card">
        <img src="{{ asset('/assets/vies.jpeg') }}" alt="Ava Joshi" class="review-img" />
        <div class="review-content">
          <h3 class="review-name">Ava Joshi</h3>
          <p class="stars">⭐⭐⭐⭐☆</p>
          <p class="review-text">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod 
            tempor incididunt ut labore et dolore magna aliqua.
          </p>
        </div>
      </div>
      <div class="review-card">
        <img src="{{ asset('/assets/vies.jpeg') }}" alt="Otis Bisnoy" class="review-img" />
        <div class="review-content">
          <h3 class="review-name">Otis Bisnoy</h3>
          <p class="stars">⭐⭐⭐⭐☆</p>
          <p class="review-text">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod 
            tempor incididunt ut labore et dolore magna aliqua.
          </p>
        </div>
      </div>
    </div>
  </section>
</body>
</html>
</x-layout>