<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductRating;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth; // Tambahkan ini

class UserOrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan pengguna.
     */
    public function index(): View
    {
        // Memuat relasi user, orderItems, dan produknya
        $orders = Order::with(['user', 'orderItems.product'])
            ->where('user_id', Auth::id()) // Hanya pesanan milik pengguna yang sedang login
            ->latest() // Urutkan dari yang terbaru
            ->get();

        return view('user.orders.index', compact('orders'));
    }

    /**
     * Menampilkan form untuk memberikan rating pada produk di dalam pesanan.
     */
    public function rateForm(Order $order): View | RedirectResponse
    {
        // Pastikan hanya pesanan milik pengguna yang sedang login
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk melihat halaman ini.');
        }

        // Hanya izinkan rating untuk pesanan yang Completed
        if (strtolower($order->status) !== 'completed') {
            return redirect()->route('user.orders.index')->with('error', 'Pesanan ini tidak bisa di-rating karena statusnya belum selesai.');
        }

        // Muat item pesanan beserta produknya
        // Muat juga rating yang mungkin sudah ada untuk produk-produk ini oleh user yang sedang login
        $order->load(['orderItems.product.ratings' => function($query) use ($order) {
            $query->where('user_id', Auth::id())->where('order_id', $order->id);
        }]);

        return view('user.orders.rate_form', compact('order'));
    }

    /**
     * Menyimpan rating produk dari form.
     */
    public function submitRatings(Request $request, Order $order): JsonResponse
    {
        // Pastikan hanya pesanan milik pengguna yang sedang login
        if ($order->user_id !== Auth::id()) {
            return response()->json(['message' => 'Anda tidak memiliki akses.'], 403);
        }

        // Hanya izinkan rating untuk pesanan yang Completed
        if (strtolower($order->status) !== 'completed') {
            return response()->json(['message' => 'Pesanan ini tidak bisa di-rating.'], 400);
        }

        try {
            // Validasi untuk setiap rating produk
            $request->validate([
                'ratings' => 'required|array', // Harus ada array ratings
                'ratings.*.product_id' => 'required|exists:products,id', // Setiap rating harus punya product_id yang valid
                'ratings.*.rating' => 'required|integer|min:1|max:5', // Rating bintang 1-5
                'ratings.*.comment' => 'nullable|string|max:500', // Komentar opsional
            ]);

            foreach ($request->ratings as $itemRating) {
                // Pastikan produk ada di dalam order ini
                $orderItem = $order->orderItems->first(function($item) use ($itemRating) {
                    return $item->product_id == $itemRating['product_id'];
                });

                if (!$orderItem) {
                    Log::warning('Product ID ' . $itemRating['product_id'] . ' not found in order ' . $order->id . ' for user ' . Auth::id());
                    continue; // Skip jika produk tidak ada di pesanan ini (bisa jadi tempering data)
                }

                // Buat atau perbarui rating produk
                ProductRating::updateOrCreate(
                    [
                        'user_id' => Auth::id(),
                        'product_id' => $itemRating['product_id'],
                        'order_id' => $order->id, // Menyimpan konteks order_id
                    ],
                    [
                        'rating' => $itemRating['rating'],
                        'comment' => $itemRating['comment'] ?? null,
                    ]
                );
            }

            return response()->json([
                'message' => 'Rating Anda berhasil disimpan. Terima kasih!',
                'redirect' => route('user.orders.index') // Redirect kembali ke halaman daftar pesanan
            ], 200);

        } catch (ValidationException $e) {
            Log::warning('Product rating validation failed: ' . $e->getMessage(), ['errors' => $e->errors(), 'order_id' => $order->id, 'user_id' => Auth::id()]);
            return response()->json([
                'message' => 'Validasi gagal. Cek kembali rating Anda.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error submitting product ratings: ' . $e->getMessage(), ['exception' => $e, 'order_id' => $order->id, 'user_id' => Auth::id()]);
            return response()->json([
                'message' => 'Terjadi kesalahan server saat menyimpan rating.',
            ], 500);
        }
    }


    /**
     * Menghapus pesanan tertentu.
     * Dirancang untuk merespons JSON (untuk permintaan AJAX).
     */
    public function destroy(Order $order): JsonResponse
    {
        // Pastikan hanya pesanan milik pengguna yang sedang login yang bisa dihapus
        if ($order->user_id !== Auth::id()) {
            return response()->json(['message' => 'Anda tidak memiliki akses untuk menghapus pesanan ini.'], 403);
        }

        // Pastikan hanya pesanan dengan status 'completed' yang boleh dihapus
        if (strtolower($order->status) !== 'completed') {
            return response()->json(['message' => 'Pesanan ini tidak dapat dihapus karena statusnya belum selesai.'], 400);
        }

        try {
            $order->delete();
            return response()->json(['message' => 'Pesanan berhasil dihapus.'], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting order: ' . $e->getMessage(), ['order_id' => $order->id, 'user_id' => Auth::id()]);
            return response()->json(['message' => 'Gagal menghapus pesanan. Terjadi kesalahan server.'], 500);
        }
    }
}