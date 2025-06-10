<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductRating; // pastikan ada model ini

class DashboardController extends Controller
{
    public function index()
    {
        $ratings = ProductRating::with(['user', 'product'])->latest()->take(5)->get();

        return view('dashboard', compact('product_ratings'));
    }
}
