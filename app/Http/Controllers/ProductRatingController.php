<?php

namespace App\Http\Controllers;

use App\Models\ProductRating;
use Illuminate\Support\Facades\Storage;

class ProductRatingController extends Controller
{
    public function index()
    {
        $ratings = ProductRating::with(['user', 'product'])->get();
        return view('product_ratings.index', compact('ratings'));
    }
}

