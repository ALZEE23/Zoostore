<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\admin\AdminProductController;
use App\Http\Controllers\admin\PemasokProductController; // Perbaiki ini jika salah ketik
use App\Http\Controllers\admin\AdminUserController;
use App\Http\Controllers\admin\AdminOrderController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProdukdetailController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\ChekoutController; // Pastikan ini ChekoutController yang benar
use App\Http\Controllers\DataProdukController; // Ini sepertinya tidak digunakan, bisa dihapus jika tidak ada
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\ProductRatingController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Dashboard umum
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Duplikasi route, pilih salah satu
Route::get('/product_ratings', [ProductRatingController::class, 'index'])->name('product_ratings.index');
// Route::get('/product-ratings', [ProductRatingController::class, 'index'])->name('product_ratings.index');


// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// **ADMIN ROUTE** dengan prefix `/admin` dan middleware `admin`
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () { // Grouping untuk admin
    Route::get('/dashboard', [AdminController::class, 'index']); // hapus middleware di sini jika sudah di group
    Route::resource('/products', AdminProductController::class);
    Route::resource('/users', AdminUserController::class);
    Route::resource('/orders', AdminOrderController::class);
    Route::post('/orders/{id}/update-status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
});


// **PEMASOK ROUTE** dengan prefix `/staff` dan middleware `staff`
Route::middleware(['auth', 'staff'])->prefix('staff')->group(function () {
    Route::get('/dashboard', [PemasokController::class, 'index'])->name('pemasok.dashboard');
    Route::resource('/products', PemasokProductController::class)->names('staff.products');
});

// Route Shoop
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/produkdetail/{id}', [ProdukdetailController::class, 'index'])->name('produkdetail.index');
Route::get('/faqs', [FaqsController::class, 'index'])->name('faqs.index');
Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');

// Route Riwayat Pesanan
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

Route::middleware('auth')->group(function () { // Grouping untuk user-specific routes
    // Route untuk menampilkan halaman rating produk dalam sebuah pesanan
    Route::get('/user/orders/{order}/rate', [UserOrderController::class, 'rateForm'])->name('user.orders.rate_form');
    // Route untuk submit rating
    Route::post('/user/orders/{order}/submit-ratings', [UserOrderController::class, 'submitRatings'])->name('user.orders.submit_ratings');

    // Route untuk daftar pesanan user
    Route::get('/user/orders', [UserOrderController::class, 'index'])->name('user.orders.index');
    Route::delete('/user/orders/{order}', [UserOrderController::class, 'destroy'])->name('user.orders.destroy'); // Pastikan ini tidak duplikat dengan /my-orders

    // Route Riwayat Transaksi
    Route::get('/riwayat/pemesanan/', [RiwayatController::class, 'index'])->name('riwayat.pemesanan.pesanan');
    Route::get('/riwayat/pemesanan/detail', [RiwayatController::class, 'detail'])->name('riwayat.pemesanan.detail');
    Route::get('/riwayat/transaksi/', [RiwayatController::class, 'trans'])->name('riwayat.transaksi.trans');
    Route::get('/riwayat/transaksi/struk-preview', [RiwayatController::class, 'struk'])->name('riwayat.transaksi.struk-preview');

    // Cart routes
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
    Route::delete('/cart/deleteItem/{id}', [CartController::class, 'deleteItem'])->name('item.delete'); // Perbaiki nama named parameter

    // Checkout Routes
    Route::resource('/cekot', ChekoutController::class)->only(['index', 'store']); // Hanya izinkan index dan store
    Route::post('/cekot/checkout', [ChekoutController::class, 'checkout'])->name('checkout'); // Route untuk menampilkan halaman checkout dengan item yang dipilih
    Route::post('/get-snap-token', [ChekoutController::class, 'getSnapToken'])->name('checkout.token'); // Ini route untuk mendapatkan snap token
    Route::post('/checkCost', [ChekoutController::class, 'checkShippingCost'])->name('checkCost'); // Pastikan ini unik

    // RajaOngkir related routes
    Route::get('/get-cities/{provinceId}', [ChekoutController::class, 'getCities']);

    // Ini adalah route untuk callback dari Midtrans. TEMPATKAN DI LUAR GROUP MIDDLEWARE 'auth' JIKA TIDAK ADA AUTH DI CALLBACK MIDTRANS
    // Karena Midtrans tidak akan mengirimkan kredensial login user Anda saat mengirim notifikasi.
    // Paling baik diletakkan di luar group middleware 'auth' atau di group middleware terpisah yang tidak memerlukan autentikasi session.
});

// Route untuk Midtrans Callback - TEMPATKAN DI LUAR MIDDLWARE 'auth' ATAU SEPERTI INI AGAR BISA DI AKSES MIDTRANS
Route::post('/midtrans-callback', [ChekoutController::class, 'handleMidtransCallback']);


// Duplikasi route, pilih salah satu
// Route::get('/my-orders', [UserOrderController::class, 'index'])->name('user.orders.index');
// Route::delete('/my-orders/{order}', [UserOrderController::class, 'destroy'])->name('user.orders.destroy');


require __DIR__ . '/auth.php';