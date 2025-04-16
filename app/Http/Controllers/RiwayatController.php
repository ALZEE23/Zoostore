<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RiwayatController extends Controller
{
   public function index()
{
    // resources/views/riwayat/pemesanan/pesanan.blade.php
    return view('riwayat.pemesanan.pesanan');
}

public function detail()
{
    // resources/views/riwayat/pemesanan/detailpesanan.blade.php
    return view('riwayat.pemesanan.detailpesanan');
}

public function trans()
{
    // resources/views/riwayat/pemesanan/detailpesanan.blade.php
    return view('riwayat.transaksi.trans');
}

public function struk()
{
    // resources/views/riwayat/pemesanan/detailpesanan.blade.php
    return view('riwayat.transaksi.struk-preview');
}

}
