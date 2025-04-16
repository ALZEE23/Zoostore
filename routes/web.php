<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProdukdetailController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\CekotController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;

//Route Welcome
Route::get('/', function () {
    return view('welcome');
});

//Route Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Route Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/datapribadi', [ProfileController::class, 'datapribadi'])->name('profile.datapribadi');
});

//Route Shoop
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/collection', [CollectionController::class, 'index'])->name('collection.index');
Route::get('/faqs', [FaqsController::class, 'index'])->name('faqs.index');
Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');

//Route Riwayat Pesanan
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/produkdetail', [ProdukdetailController::class, 'index'])->name('produkdetail.index');
Route::get('/cekot', [CekotController::class, 'index'])->name('cekot.index');

//Route Riwayat Transaksi
Route::get('/riwayat/pemesanan/', [RiwayatController::class, 'index']) ->name('riwayat.pemesanan.pesanan');
Route::get('/riwayat/pemesanan/detail', [RiwayatController::class, 'detail']) ->name('riwayat.pemesanan.detail'); 
Route::get('/riwayat/transaksi/', [RiwayatController::class, 'trans']) ->name('riwayat.transaksi.trans');
Route::get('/riwayat/transaksi/struk-preview', [RiwayatController::class, 'struk']) ->name('riwayat.transaksi.struk-preview');

require __DIR__.'/auth.php';
