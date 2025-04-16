<x-navbar>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Riwayat Transaksi - Zoes Store</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link 
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" 
    rel="stylesheet">
  
  <!-- html2pdf untuk download PDF -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
  
  <style>
    /* Reset dasar */
    * {
      margin: 0; 
      padding: 0; 
      box-sizing: border-box;
    }

    /* HTML & Body */
    html, body {
      width: 100%;
      height: 100%;
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #fff0ee, #ffffff);
      color: #333;
    }
    
    /* Navbar (jika ada x-navbar, buat style custom) */
    x-navbar {
      display: block;
      width: 100%;
      background-color: #fff;
    }

    /* Container utama: gunakan max-width agar konten berada di tengah */
    .container {
      width: 100%;
      max-width: 1200px; /* ubah sesuai kebutuhan */
      margin: 0 auto;    /* agar konten center */
      padding: 1rem;     /* spasi agar tidak mepet */
      position: relative; /* untuk watermark absolute */
    }

    .header {
      text-align: center;
      margin-bottom: 1.5rem;
    }
    .header h1 {
      font-size: 2rem;
      color: #B22222;
      margin-bottom: 0.5rem;
      font-weight: 600;
    }
    .header p {
      color: #666;
      font-size: 0.95rem;
    }

    /* Watermarks */
    .watermark {
      position: absolute;
      font-size: 7rem;
      font-weight: 900;
      color: rgba(220, 20, 60, 0.05);
      pointer-events: none;
      user-select: none;
      z-index: 0;
    }
    .wm1 { top: 5%; left: -2rem; transform: rotate(-15deg); }
    .wm2 { top: 40%; right: -2rem; transform: rotate(12deg); }
    .wm3 { bottom: 5%; left: 5%; transform: rotate(-12deg); }

    /* Card Transaksi */
    .glass-card {
      position: relative;
      background: rgba(255,255,255, 0.9);
      backdrop-filter: blur(8px);
      border-radius: 16px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
      margin-bottom: 1.5rem;  /* antar kartu */
      padding: 1.5rem;
      transition: transform 0.3s, box-shadow 0.3s;
      z-index: 1;
    }
    .glass-card:hover {
      transform: scale(1.02);
      box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
    }

    /* Grid responsif (bawaan) */
    .grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 1rem;
    }
    @media (min-width: 768px) {
      .grid-cols-2 {
        grid-template-columns: 1fr 1fr;
      }
    }

    /* Detail produk */
    .product-item {
      display: flex;
      gap: 1rem;
      align-items: center;
      margin-bottom: 1rem;
    }
    .product-item img {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    .product-item p {
      margin: 0;
      font-size: 0.9rem;
      color: #444;
    }

    /* Tombol */
    .btn {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      padding: 0.5rem 1rem;
      border: none;
      border-radius: 30px;
      cursor: pointer;
      font-size: 0.9rem;
      font-weight: 600;
      transition: transform 0.3s, box-shadow 0.3s;
    }
    .btn:hover {
      transform: scale(1.05);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    .btn-blue {
      background: #B22222; 
      color: #fff;
    }
    .btn-green {
      background: #228B22; 
      color: #fff;
    }
    .btn-gray {
      background: #6b7280; 
      color: #fff;
    }
    .btn-danger {
      background: #DC143C; 
      color: #fff;
    }

    /* Status Total */
    .total-price {
      margin-top: 1rem;
      font-weight: 600;
      color: #B22222;
    }

    /* Timeline (tanpa garis vertikal) */
    .timeline {
      margin-top: 1rem;
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }
    .timeline-step {
      display: flex;
      align-items: center;
      gap: 0.8rem;
    }
    .step-icon {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background-color: #ddd;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-size: 1rem;
      flex-shrink: 0;
    }
    .timeline-step.completed .step-icon {
      background-color: #228B22;
    }
    .step-text h4 {
      margin: 0;
      font-size: 0.9rem;
      color: #B22222;
      font-weight: 600;
    }
    .step-text p {
      margin: 0;
      font-size: 0.8rem;
      color: #666;
    }

    /* Modal Styles */
    .modal-overlay {
      position: fixed;
      inset: 0;
      display: none;
      justify-content: center;
      align-items: center;
      background: rgba(0, 0, 0, 0.4);
      z-index: 200;
    }
    .modal-overlay.flex {
      display: flex;
    }
    .modal-box {
      background: #fff;
      padding: 2rem;
      border-radius: 16px;
      width: 90%;
      max-width: 500px;
      box-shadow: 0 12px 30px rgba(0,0,0,0.2);
      position: relative;
      z-index: 999; /* di atas watermark */
    }
    .modal-box h2 {
      margin-top: 0;
      margin-bottom: 1rem;
      text-align: center;
      color: #B22222;
      font-size: 1.4rem;
      font-weight: 600;
    }
    .modal-box p {
      font-size: 0.9rem;
      color: #555;
      margin: 0.5rem 0;
    }
    .modal-box hr {
      border: none;
      border-top: 1px solid #eee;
      margin: 1rem 0;
    }

    /* Payment Methods */
    .payment-methods {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
      margin-top: 1rem;
    }
    .payment-option {
      flex: 1;
      min-width: 90px;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.5rem;
      border: 1px solid #ddd;
      border-radius: 8px;
      cursor: pointer;
      transition: border-color 0.3s;
    }
    .payment-option:hover,
    .payment-option.selected {
      border-color: #B22222;
    }
    .payment-option img {
      width: 28px;
      height: 28px;
    }

    /* QR Code */
    .qr-code {
      margin-top: 1rem;
      text-align: center;
    }
    .qr-code img {
      width: 200px;
      height: 200px;
      border: 2px solid #B22222;
      border-radius: 8px;
    }

    /* Responsive Penyesuaian tambahan */
    @media (max-width: 480px) {
      .header h1 {
        font-size: 1.6rem;
      }
      .header p {
        font-size: 0.85rem;
      }
      .product-item img {
        width: 70px;
        height: 70px;
      }
      .btn {
        font-size: 0.85rem;
      }
      .glass-card {
        margin-bottom: 0.8rem;
      }
      .modal-box {
        padding: 1rem;
      }
    }
  </style>
</head>
<body>

  <!-- Container utama -->
  <div class="container">
    <!-- Watermark -->
    <div class="watermark wm1">Zoes</div>
    <div class="watermark wm2">Zoes</div>
    <div class="watermark wm3">Zoes</div>

    <!-- Header -->
    <div class="header">
      <h1><i class="fas fa-store-alt"></i> Riwayat Transaksi - Zoes Store</h1>
      <p>History transaksi premium &amp; eksklusif Anda</p>
    </div>

    <!-- Daftar Transaksi -->
    <div id="transactionContainer">
      <!-- Transaksi 1 -->
      <div class="glass-card" data-id="TRX001">
        <div style="display:flex; flex-direction: column; gap: 1rem;">
          <div>
            <p style="font-size:1.05rem; font-weight:600;">
              <i class="fas fa-receipt"></i> ID: TRX001
            </p>
            <p><i class="fas fa-calendar-alt"></i> Tanggal &amp; Jam: 2025-04-08 14:30</p>
            <p><i class="fas fa-university"></i> Metode: <span class="method-text">Transfer Bank</span></p>
            <p style="font-weight:600; color: #228B22;">
              <i class="fas fa-check-circle"></i> Status: <span class="status-text">Selesai</span>
            </p>
          </div>
          <div style="display:flex; gap: 0.8rem;">
            <button class="btn btn-blue" onclick="showStruk(transactions[0])">
              <i class="fas fa-eye"></i> Lihat Struk
            </button>
          </div>
        </div>
        <div class="grid grid-cols-2">
          <!-- Detail Produk -->
          <div>
            <p style="font-weight:600; margin:1rem 0 0.5rem;">
              <i class="fas fa-box-open"></i> Detail Barang:
            </p>
            <div class="product-item">
              <!-- Ganti src sesuai asset Anda -->
              <img src="{{ asset('assets/baby.jpeg') }}" alt="Sepatu Bayi Pink">
              <div>
                <p>Sepatu Bayi Pink</p>
                <p style="font-size:0.85rem; color:#555;">Qty: 1 | Rp125.000</p>
              </div>
            </div>
            <div class="product-item">
              <img src="{{ asset('assets/baby.jpeg') }}" alt="Kaos Kaki Polos">
              <div>
                <p>Kaos Kaki Polos</p>
                <p style="font-size:0.85rem; color:#555;">Qty: 2 | Rp60.000</p>
              </div>
            </div>
          </div>
          <!-- Timeline Transaksi -->
          <div>
            <p style="font-weight:600; margin:1rem 0 0.5rem;">
              <i class="fas fa-stream"></i> Timeline Transaksi:
            </p>
            <div class="timeline">
              <div class="timeline-step completed">
                <div class="step-icon"><i class="fas fa-hourglass-start"></i></div>
                <div class="step-text">
                  <h4>Belum Lunas</h4>
                  <p>Menunggu Pembayaran</p>
                </div>
              </div>
              <div class="timeline-step completed">
                <div class="step-icon"><i class="fas fa-check-double"></i></div>
                <div class="step-text">
                  <h4>Konfirmasi</h4>
                  <p>Pembayaran Dikonfirmasi</p>
                </div>
              </div>
              <div class="timeline-step completed">
                <div class="step-icon"><i class="fas fa-cogs"></i></div>
                <div class="step-text">
                  <h4>Proses</h4>
                  <p>Sedang Diproses</p>
                </div>
              </div>
              <div class="timeline-step completed">
                <div class="step-icon"><i class="fas fa-shipping-fast"></i></div>
                <div class="step-text">
                  <h4>Dikirim</h4>
                  <p>Paket Dalam Pengiriman</p>
                </div>
              </div>
              <div class="timeline-step completed">
                <div class="step-icon"><i class="fas fa-thumbs-up"></i></div>
                <div class="step-text">
                  <h4>Selesai</h4>
                  <p>Transaksi Tuntas</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="total-price">
          <i class="fas fa-money-check-alt"></i> Total: Rp245.000
        </div>
      </div>

      <!-- Transaksi 2 -->
      <div class="glass-card" data-id="TRX002">
        <div style="display:flex; flex-direction: column; gap: 1rem;">
          <div>
            <p style="font-size:1.05rem; font-weight:600;">
              <i class="fas fa-receipt"></i> ID: TRX002
            </p>
            <p><i class="fas fa-calendar-alt"></i> Tanggal &amp; Jam: 2025-04-07 10:15</p>
            <p><i class="fas fa-shipping-fast"></i> Metode: <span class="method-text">COD</span></p>
            <p style="font-weight:600; color: #B22222;">
              <i class="fas fa-sync-alt"></i> Status: <span class="status-text">Dalam Proses</span>
            </p>
          </div>
          <div style="display:flex; gap: 0.8rem;">
            <button class="btn btn-blue" onclick="showStruk(transactions[1])">
              <i class="fas fa-eye"></i> Lihat Struk
            </button>
          </div>
        </div>
        <div class="grid grid-cols-2">
          <div>
            <p style="font-weight:600; margin:1rem 0 0.5rem;">
              <i class="fas fa-box-open"></i> Detail Barang:
            </p>
            <div class="product-item">
              <img src="{{ asset('assets/baby.jpeg') }}" alt="Baju Anak Laki">
              <div>
                <p>Baju Anak Laki</p>
                <p style="font-size:0.85rem; color:#555;">Qty: 1 | Rp175.000</p>
              </div>
            </div>
            <div class="product-item">
              <img src="{{ asset('assets/baby.jpeg') }}" alt="Topi Bayi">
              <div>
                <p>Topi Bayi</p>
                <p style="font-size:0.85rem; color:#555;">Qty: 1 | Rp150.000</p>
              </div>
            </div>
          </div>
          <!-- Timeline Transaksi -->
          <div>
            <p style="font-weight:600; margin:1rem 0 0.5rem;">
              <i class="fas fa-stream"></i> Timeline Transaksi:
            </p>
            <div class="timeline">
              <div class="timeline-step">
                <div class="step-icon"><i class="fas fa-hourglass-start"></i></div>
                <div class="step-text">
                  <h4>Belum Lunas</h4>
                  <p>Menunggu Pembayaran</p>
                </div>
              </div>
              <div class="timeline-step">
                <div class="step-icon"><i class="fas fa-money-check-alt"></i></div>
                <div class="step-text">
                  <h4>Pembayaran</h4>
                  <p>Verifikasi COD</p>
                </div>
              </div>
              <div class="timeline-step completed">
                <div class="step-icon"><i class="fas fa-cogs"></i></div>
                <div class="step-text">
                  <h4>Proses</h4>
                  <p>Sedang Diproses</p>
                </div>
              </div>
              <div class="timeline-step">
                <div class="step-icon"><i class="fas fa-shipping-fast"></i></div>
                <div class="step-text">
                  <h4>Dikirim</h4>
                  <p>Paket Dalam Pengiriman</p>
                </div>
              </div>
              <div class="timeline-step">
                <div class="step-icon"><i class="fas fa-thumbs-up"></i></div>
                <div class="step-text">
                  <h4>Selesai</h4>
                  <p>Transaksi Tuntas</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="total-price">
          <i class="fas fa-money-check-alt"></i> Total: Rp325.000
        </div>
      </div>

      <!-- Transaksi 3 -->
      <div class="glass-card" data-id="TRX003">
        <div style="display:flex; flex-direction: column; gap: 1rem;">
          <div>
            <p style="font-size:1.05rem; font-weight:600;">
              <i class="fas fa-receipt"></i> ID: TRX003
            </p>
            <p><i class="fas fa-calendar-alt"></i> Tanggal &amp; Jam: 2025-04-06 16:45</p>
            <p><i class="fas fa-wallet"></i> Metode: <span class="method-text">E-Wallet</span></p>
            <p style="font-weight:600; color: #F59E0B;">
              <i class="fas fa-hourglass-half"></i> Status: <span class="status-text">Menunggu Transfer</span>
            </p>
          </div>
          <div style="display:flex; gap: 0.8rem;">
            <button class="btn btn-blue" onclick="showStruk(transactions[2])">
              <i class="fas fa-eye"></i> Lihat Struk
            </button>
            <button class="btn btn-green" onclick="showTransfer(transactions[2])">
              <i class="fas fa-exchange-alt"></i> Transfer Dana
            </button>
          </div>
        </div>
        <div class="grid grid-cols-2">
          <div>
            <p style="font-weight:600; margin:1rem 0 0.5rem;">
              <i class="fas fa-box-open"></i> Detail Barang:
            </p>
            <div class="product-item">
              <img src="{{ asset('assets/baby.jpeg') }}" alt="Celana Bayi">
              <div>
                <p>Celana Bayi</p>
                <p style="font-size:0.85rem; color:#555;">Qty: 2 | Rp60.000</p>
              </div>
            </div>
          </div>
          <!-- Timeline Transaksi -->
          <div>
            <p style="font-weight:600; margin:1rem 0 0.5rem;">
              <i class="fas fa-stream"></i> Timeline Transaksi:
            </p>
            <div class="timeline">
              <div class="timeline-step">
                <div class="step-icon"><i class="fas fa-hourglass-start"></i></div>
                <div class="step-text">
                  <h4>Belum Lunas</h4>
                  <p>Menunggu Pembayaran</p>
                </div>
              </div>
              <div class="timeline-step">
                <div class="step-icon"><i class="fas fa-money-check-alt"></i></div>
                <div class="step-text">
                  <h4>Transfer</h4>
                  <p>Konfirmasi E-Wallet</p>
                </div>
              </div>
              <div class="timeline-step">
                <div class="step-icon"><i class="fas fa-cogs"></i></div>
                <div class="step-text">
                  <h4>Proses</h4>
                  <p>Sedang Diproses</p>
                </div>
              </div>
              <div class="timeline-step">
                <div class="step-icon"><i class="fas fa-shipping-fast"></i></div>
                <div class="step-text">
                  <h4>Dikirim</h4>
                  <p>Paket Dalam Pengiriman</p>
                </div>
              </div>
              <div class="timeline-step">
                <div class="step-icon"><i class="fas fa-thumbs-up"></i></div>
                <div class="step-text">
                  <h4>Selesai</h4>
                  <p>Transaksi Tuntas</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="total-price">
          <i class="fas fa-money-check-alt"></i> Total: Rp120.000
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Preview Struk -->
  <div id="strukModal" class="modal-overlay">
    <div class="modal-box">
      <h2><i class="fas fa-file-alt"></i> Preview Struk</h2>
      <div id="strukContent" style="margin-top:1rem; font-size:0.9rem;"></div>
      <div class="qr-code" id="qrCodeContainer">
        <!-- QR Code akan berisi link untuk menampilkan detail struk (data JSON) di halaman terpisah -->
        <img src="" alt="QR Code">
      </div>
      <div style="margin-top: 1rem; display:flex; justify-content: flex-end; gap: 0.5rem;">
        <button class="btn btn-green" onclick="downloadStruk()">
          <i class="fas fa-download"></i> Download PDF
        </button>
        <button class="btn btn-gray" onclick="closeStruk()">Tutup</button>
      </div>
    </div>
  </div>

  <!-- Modal Transfer -->
  <div id="transferModal" class="modal-overlay">
    <div class="modal-box">
      <h2><i class="fas fa-money-check-alt"></i> Transfer Dana</h2>
      <div id="transferContent" style="margin-top:1rem; font-size:0.9rem;">
        <p>Masukkan jumlah untuk transfer (ID Transaksi: <span id="transferID"></span>):</p>
        <input type="number" id="transferAmount" placeholder="Jumlah transfer" 
               style="width:100%; padding:0.6rem; margin-top:0.5rem; border:1px solid #ccc; border-radius:4px;">
        <p style="margin-top:1.2rem;">Pilih Metode Pembayaran:</p>
        <div class="payment-methods">
          <!-- Payment Options -->
          <div class="payment-option" onclick="selectPayment(this, 'Dana')">
            <!-- Ganti src sesuai asset Anda -->
            <img src="{{ asset('assets/dana.jpeg') }}" alt="Dana">
            <span>Dana</span>
          </div>
          <div class="payment-option" onclick="selectPayment(this, 'BCA')">
            <img src="{{ asset('assets/bca.jpeg') }}" alt="BCA">
            <span>BCA</span>
          </div>
          <div class="payment-option" onclick="selectPayment(this, 'Mandiri')">
            <img src="{{ asset('assets/mandiri.jpeg') }}" alt="Mandiri">
            <span>Mandiri</span>
          </div>
          <div class="payment-option" onclick="selectPayment(this, 'LinkAja')">
            <img src="{{ asset('assets/link.jpeg') }}" alt="LinkAja">
            <span>LinkAja</span>
          </div>
        </div>
      </div>
      <div style="margin-top: 1rem; display:flex; justify-content: flex-end; gap: 0.5rem;">
        <button class="btn btn-blue" onclick="executeTransfer()">
          <i class="fas fa-paper-plane"></i> Kirim
        </button>
        <button class="btn btn-danger" onclick="cancelTransfer()">Batalkan</button>
        <button class="btn btn-gray" onclick="closeTransfer()">Tutup</button>
      </div>
    </div>
  </div>

  <script>
    // Data dummy transaksi (sesuaikan dengan data real dari backend Anda)
    const transactions = [
      {
        id: 'TRX001',
        tanggal: '2025-04-08 14:30',
        total: 245000,
        metode: 'Transfer Bank',
        status: 'Selesai',
        kontak: {
          email: 'cs@zoesstore.com',
          phone: '081234567890',
          toko: 'Zoes Store'
        },
        timeline: [
          { step: 'Belum Lunas', completed: true },
          { step: 'Konfirmasi', completed: true },
          { step: 'Proses', completed: true },
          { step: 'Dikirim', completed: true },
          { step: 'Selesai', completed: true },
        ],
        items: [
          { nama: 'Sepatu Bayi Pink', qty: 1, harga: 125000, foto: '{{ asset('assets/baby.jpeg') }}' },
          { nama: 'Kaos Kaki Polos', qty: 2, harga: 60000, foto: '{{ asset('assets/baby.jpeg') }}' },
        ]
      },
      {
        id: 'TRX002',
        tanggal: '2025-04-07 10:15',
        total: 325000,
        metode: 'COD',
        status: 'Dalam Proses',
        kontak: {
          email: 'cs@zoesstore.com',
          phone: '081234567890',
          toko: 'Zoes Store'
        },
        timeline: [
          { step: 'Belum Lunas', completed: false },
          { step: 'Pembayaran', completed: false },
          { step: 'Proses', completed: true },
          { step: 'Dikirim', completed: false },
          { step: 'Selesai', completed: false },
        ],
        items: [
          { nama: 'Baju Anak Laki', qty: 1, harga: 175000, foto: '{{ asset('assets/baby.jpeg') }}' },
          { nama: 'Topi Bayi', qty: 1, harga: 150000, foto: '{{ asset('assets/baby.jpeg') }}' },
        ]
      },
      {
        id: 'TRX003',
        tanggal: '2025-04-06 16:45',
        total: 120000,
        metode: 'E-Wallet',
        status: 'Menunggu Transfer',
        kontak: {
          email: 'cs@zoesstore.com',
          phone: '081234567890',
          toko: 'Zoes Store'
        },
        timeline: [
          { step: 'Belum Lunas', completed: false },
          { step: 'Transfer', completed: false },
          { step: 'Proses', completed: false },
          { step: 'Dikirim', completed: false },
          { step: 'Selesai', completed: false },
        ],
        items: [
          { nama: 'Celana Bayi', qty: 2, harga: 60000, foto: '{{ asset('assets/baby.jpeg') }}' },
        ]
      }
    ];

    let currentStruk = null;
    let currentTransfer = null;
    let selectedPaymentMethod = null;

    /* ---------------- STRUK MODAL ---------------- */
    function showStruk(trx) {
      currentStruk = trx;
      const container = document.getElementById('strukContent');
      let html = `
        <p><strong>ID:</strong> ${trx.id}</p>
        <p><strong>Tanggal & Jam:</strong> ${trx.tanggal}</p>
        <p><strong>Metode Pembayaran:</strong> ${trx.metode}</p>
        <p><strong>Status:</strong> ${trx.status}</p>
        <hr>
        <p><strong>Detail Barang:</strong></p>
      `;
      trx.items.forEach(item => {
        html += `
          <div style="display:flex; gap:0.8rem; align-items:center; margin-bottom:0.5rem;">
            <img src="${item.foto}" alt="${item.nama}" style="width:60px; height:60px; object-fit:cover; border-radius:6px;">
            <span>${item.nama} x${item.qty} (Rp${parseInt(item.harga).toLocaleString('id-ID')})</span>
          </div>
        `;
      });
      html += `
        <hr>
        <p><strong>Total:</strong> Rp${parseInt(trx.total).toLocaleString('id-ID')}</p>
        <p><strong>Toko:</strong> ${trx.kontak.toko}</p>
        <p><strong>Email:</strong> ${trx.kontak.email}</p>
        <p><strong>No. Telp:</strong> ${trx.kontak.phone}</p>
      `;
      container.innerHTML = html;
      
      // Generate QR Code untuk link ke struk-preview.html + data JSON
      const previewUrl = 'http://contoh-domainmu.com/struk-preview.html'; 
      // GANTI DI ATAS dengan URL/file halaman "struk-preview.html" di server Anda
      
      // Encode data JSON ke param ?data=...
      const jsonString = JSON.stringify(trx);
      const encodedData = encodeURIComponent(jsonString);
      const finalLink = `${previewUrl}?data=${encodedData}`;

      // Tampilkan link ini di QR code
      document.querySelector('#qrCodeContainer img').src =
        `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(finalLink)}`;

      document.getElementById('strukModal').classList.add('flex');
    }

    function closeStruk() {
      document.getElementById('strukModal').classList.remove('flex');
    }

    function downloadStruk() {
      if (!currentStruk) return;
      const element = document.getElementById('strukContent');
      // Tambahkan QR code ke PDF (opsional, boleh juga tidak)
      const qrImgSrc = document.querySelector('#qrCodeContainer img').src;

      const wrapper = document.createElement('div');
      wrapper.innerHTML = `
        <div style="position:relative; padding:20px; font-family:'Poppins',sans-serif;">
          <div style="position:absolute; top:40%; left:50%; transform:translate(-50%,-50%) rotate(-30deg); font-size:2.5rem; font-weight:900; color:rgba(0,0,0,0.05);">
            Zoes Store
          </div>
          ${element.innerHTML}
          <div style="text-align:center; margin-top:1rem;">
            <img src="${qrImgSrc}" style="width:120px; height:120px; border:2px solid #B22222; border-radius:8px;" />
          </div>
        </div>
      `;
      const opt = {
        margin: 0.3,
        filename: `struk-${currentStruk.id}.pdf`,
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'in', format: 'A4', orientation: 'portrait' }
      };
      html2pdf().set(opt).from(wrapper).save();
    }

    /* ---------------- TRANSFER MODAL ---------------- */
    function showTransfer(trx) {
      currentTransfer = trx;
      selectedPaymentMethod = null;
      document.getElementById('transferID').innerText = trx.id;
      document.getElementById('transferAmount').value = '';
      document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('selected'));
      document.getElementById('transferModal').classList.add('flex');
    }

    function closeTransfer() {
      document.getElementById('transferModal').classList.remove('flex');
    }

    function selectPayment(element, method) {
      document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('selected'));
      element.classList.add('selected');
      selectedPaymentMethod = method;
    }

    function executeTransfer() {
      const amount = document.getElementById('transferAmount').value;
      if (!amount || amount <= 0) {
        alert('Masukkan jumlah yang valid.');
        return;
      }
      if (!selectedPaymentMethod) {
        alert('Pilih metode pembayaran terlebih dahulu.');
        return;
      }
      alert(`Transfer Rp${parseInt(amount).toLocaleString('id-ID')} via ${selectedPaymentMethod} untuk ${currentTransfer.id} sukses!`);
      // Update status di data dummy
      currentTransfer.status = 'Lunas';
      currentTransfer.metode = selectedPaymentMethod;
      currentTransfer.timeline.forEach(step => step.completed = true);

      // Update tampilan di card
      const card = document.querySelector(`.glass-card[data-id='${currentTransfer.id}']`);
      if (card) {
        card.querySelector('.status-text').innerText = 'Lunas';
        card.querySelector('.method-text').innerText = selectedPaymentMethod;
      }
      closeTransfer();
    }

    function cancelTransfer() {
      alert('Pembayaran dibatalkan!');
    }
  </script>
</body>
</html>
</x-navbar>
