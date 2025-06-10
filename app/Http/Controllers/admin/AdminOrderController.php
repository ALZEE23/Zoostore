<?php

namespace App\Http\Controllers\admin;

use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // AdminOrderController@index
public function index()
{
    $orders = Order::with(['user', 'orderItems.product'])->latest()->get();
    return view('admin.orders.index', compact('orders'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $order = Order::create([
            'customer_name' => $validated['customer_name'],
        ]);

        foreach ($validated['products'] as $productData) {
            $product = Product::find($productData['product_id']);
            $order->items()->create([
                'product_id' => $product->id,
                'quantity' => $productData['quantity'],
                'price' => $product->price,
            ]);
        }

        return response()->json(['message' => 'Pesanan berhasil dibuat']);
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:Pending,Processed,Delivery,Completed,Cancelled'
            ]);

            $order = Order::findOrFail($id);
            $order->update(['status' => $request->status]);

            return response()->json([
                'status' => 'success',
                'message' => 'Status pesanan berhasil diperbarui'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memperbarui status: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
