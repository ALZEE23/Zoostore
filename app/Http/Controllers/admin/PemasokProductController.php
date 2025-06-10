<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Import kelas Log untuk logging

class PemasokProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('staff.products.index', compact('products'));
    }

    public function create()
    {
        return view('staff.products.create');
    }

    public function store(Request $request)
    {
        // Debugging: Log semua data request yang masuk
        Log::info('Product store request received:', $request->all());

        try {
            // Validasi data
            // Ubah validasi 'photo' agar lebih spesifik untuk gambar
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'code' => 'required|numeric|unique:products,code', // Pastikan 'code' itu numerik dan unik di tabel 'products'
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048', // Tambahkan validasi gambar (max 2MB)
                'status' => 'required|in:aktif,nonaktif',
                'diskon' => 'nullable|numeric|min:0|max:100',
            ]);

            // Hitung harga_diskon
            $harga_diskon = $validatedData['price'];
            // Pastikan 'diskon' ada di validatedData sebelum digunakan
            if (isset($validatedData['diskon'])) { 
                $harga_diskon = $validatedData['price'] - ($validatedData['price'] * ($validatedData['diskon'] / 100));
            }

            // Handle upload foto
            $photoPath = null;
            if ($request->hasFile('photo')) {
                // Simpan ke storage 'public' dalam folder 'products'
                $photoPath = $request->file('photo')->store('products', 'public');
            }

            // Buat produk di database
            Product::create([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'code' => $validatedData['code'],
                'price' => $validatedData['price'],
                'stock' => $validatedData['stock'],
                'photo' => $photoPath, // Simpan path relatif dari file
                'status' => $validatedData['status'],
                'diskon' => $validatedData['diskon'] ?? 0, // Pastikan diskon default ke 0 jika null
                'harga_diskon' => $harga_diskon,
            ]);

            // Mengembalikan respons JSON untuk request AJAX
            return response()->json([
                'message' => 'Produk berhasil ditambahkan!',
                'redirect' => route('staff.products.index') // Beri tahu frontend untuk redirect
            ], 201); // Kode status 201 Created

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangani error validasi dari $request->validate()
            Log::warning('Product validation failed: ' . $e->getMessage(), ['errors' => $e->errors()]);
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $e->errors() // Mengembalikan detail error validasi
            ], 422); // Kode status 422 Unprocessable Entity
        } catch (\Exception $e) {
            // Tangani error umum lainnya
            Log::error('Product creation error: ' . $e->getMessage(), ['exception' => $e]);

            // Hapus foto yang mungkin sudah diupload jika terjadi error setelah itu
            if (isset($photoPath) && Storage::disk('public')->exists($photoPath)) {
                Storage::disk('public')->delete($photoPath);
            }

            // Mengembalikan respons JSON untuk error server
            return response()->json([
                'message' => 'Terjadi kesalahan internal server. Gagal menambahkan produk.',
                // 'error_detail' => $e->getMessage() // Komentar ini untuk production, jangan tampilkan error detail ke user
            ], 500); // Kode status 500 Internal Server Error
        }
    }


    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return view('staff.products.show', compact('product'));
    }

    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        return view('staff.products.edit', compact('product'));
    }

    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'code' => 'required|numeric|unique:products,code,' . $id,
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'status' => 'required|in:aktif,nonaktif',
                'diskon' => 'nullable|numeric|min:0|max:100',
            ]);

            $harga_diskon = $request->price - ($request->price * ($request->diskon / 100));
            $product = Product::findOrFail($id);

            if ($request->file('photo')) {
                if ($product->photo) {
                    Storage::delete('public/' . $product->photo);
                }
                $photoPath = $request->file('photo')->store('products', 'public');
                $product->photo = $photoPath;
            }

            $product->update([
                'name' => $request->name,
                'description' => $request->description,
                'code' => $request->code,
                'price' => $request->price,
                'stock' => $request->stock,
                'status' => $request->status,
                'diskon' => $request->diskon,
                'harga_diskon' => $harga_diskon,
            ]);

            return redirect()->route('staff.products.index')->with('success', 'Produk berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('staff.products.index')->with('error', 'Gagal memperbarui produk: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $product = Product::findOrFail($id);

            if ($product->photo && Storage::exists('public/' . $product->photo)) {
                Storage::delete('public/' . $product->photo);
            }

            $product->delete();

            return redirect()->route('staff.products.index')->with('success', 'Produk berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('staff.products.index')->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }
}
