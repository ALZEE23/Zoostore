<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;
use Illuminate\Support\Facades\Auth;


class ChekoutController extends Controller
{
    public function __construct()
    {
        // Set your Merchant Server Key
        Config::$serverKey = config('midtrans.serverKey');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        Config::$isProduction = config('midtrans.isProduction');
        // Set sanitization on (default)
        Config::$isSanitized = config('midtrans.isSanitized');
        // Set 3DS transaction for credit card to true
        Config::$is3ds = config('midtrans.is3ds');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('cekot.index', [
            'items' => collect(),
            'subtotal' => 0,
            'cities' => [],
            'costs' => [],
        ]);
    }

    public function checkout(Request $request)
    {
        try {
            // Get selected cart items
            $itemIds = json_decode($request->selected_items);
            $items = Cart::with('product')->whereIn('id', $itemIds)->get();

            // Calculate subtotal from cart items
            $subtotal = $items->sum(function ($item) {
                return $item->product->harga_diskon * $item->quantity;
            });

            // Get cities from RajaOngkir
            $response = Http::withHeaders([
                'key' => '316e4f0570ad8482913c3cd334873531'
            ])->get('https://api.rajaongkir.com/starter/city');

            if (!$response->successful()) {
                throw new \Exception('Gagal mengambil data kota');
            }

            $citiesData = $response->json();
            $cities = $citiesData['rajaongkir']['results'] ?? [];

            return view('cekot.index', compact('items', 'subtotal', 'cities'));

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function getCities($provinceId)
    {
        $citiesResponse = Http::withHeaders([
            'key' => '316e4f0570ad8482913c3cd334873531'
        ])->get("https://api.rajaongkir.com/starter/city?province=$provinceId");

        $citiesData = $citiesResponse->json();

        return response()->json($citiesData['rajaongkir']['results']);
    }

    public function checkShippingCost(Request $request)
    {
        try {
            $request->validate([
                'origin' => 'required',
                'destination' => 'required',
                'weight' => 'required|numeric',
                'courier' => 'required|in:jne,pos,tiki'
            ]);

            $response = Http::withHeaders([
                'key' => '316e4f0570ad8482913c3cd334873531'
            ])->asForm()->post('https://api.rajaongkir.com/starter/cost', [
                        'origin' => $request->origin,
                        'destination' => $request->destination,
                        'weight' => $request->weight,
                        'courier' => $request->courier
                    ]);

            if (!$response->successful()) {
                throw new \Exception('Gagal mendapatkan data ongkir');
            }

            $result = $response->json();

            return response()->json([
                'status' => 'success',
                'data' => $result['rajaongkir']['results'][0]['costs']
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function getSnapToken(Request $request)
    {
        try {
            // Validasi input gross_amount
            $request->validate([
                'gross_amount' => 'required|numeric|min:1',
                'selected_items' => 'required|json',
                'shipping_cost' => 'nullable|numeric',
            ]);

            $orderId = uniqid('ORDER-'); // Ini akan menjadi order_id_midtrans
            $grossAmount = (int) $request->gross_amount;

            $itemIds = json_decode($request->selected_items);
            $cartItems = Cart::with('product')->whereIn('id', $itemIds)->get();
            $itemDetails = [];
            foreach ($cartItems as $item) {
                $itemDetails[] = [
                    'id' => $item->product->id,
                    'price' => (int) $item->product->harga_diskon,
                    'quantity' => (int) $item->quantity,
                    'name' => $item->product->name,
                ];
            }

            if ($request->shipping_cost > 0) {
                $itemDetails[] = [
                    'id' => 'shipping-cost',
                    'price' => (int) $request->shipping_cost,
                    'quantity' => 1,
                    'name' => 'Biaya Pengiriman',
                ];
            }

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => $grossAmount,
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'phone' => Auth::user()->phone ?? '081234567890',
                ],
                'item_details' => $itemDetails,
            ];

            $snapToken = Snap::getSnapToken($params);

            // Kita juga kembalikan orderId yang kita generate, untuk disimpan di frontend (jika perlu)
            return response()->json(['token' => $snapToken, 'order_id' => $orderId]);

        } catch (\Exception $e) {
            Log::error('Gagal mendapatkan Snap Token: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mendapatkan Snap Token: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'destination' => 'required|string',
                'courier' => 'required|string',
                'service' => 'required|string',
                'alamat' => 'required|string',
                'masukan' => 'nullable|string',
                'shipping_cost' => 'required|numeric',
                'gross_amount' => 'required|numeric',
                'payment_method_selected' => 'required|in:qris,midtrans',
                'payment_photo'=> $request->payment_method_selected === 'qris' ? 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' : 'nullable',
                'selected_items' => 'required|json',
                'midtrans_order_id' => 'nullable|string', // Tambahkan validasi ini
                'midtrans_status' => 'nullable|string', // Tambahkan validasi ini
            ]);

            $cartItems = Cart::whereIn('id', json_decode($request->selected_items))->get();
            $subtotal = $cartItems->sum(function ($item) {
                return $item->product->harga_diskon * $item->quantity;
            });
            $weight = $cartItems->sum(function ($item) {
                return $item->quantity * ($item->product->weight ?? 1000);
            });

            $paymentPhotoPath = null;
            if ($request->hasFile('payment_photo')) {
                $paymentPhotoPath = $request->file('payment_photo')->store('payment_photos', 'public');
            }

            $totalPrice = (int) $request->gross_amount;

            $status = 'Pending';
            if ($request->payment_method_selected === 'midtrans' && $request->midtrans_status === 'success') {
                $status = 'Paid';
            } elseif ($request->payment_method_selected === 'midtrans' && $request->midtrans_status === 'pending') {
                $status = 'Pending Payment';
            }
            // else { status tetap 'Pending' }

            $order = Order::create([
                'user_id' => Auth::user()->id,
                'order_id_midtrans' => $request->midtrans_order_id, // Simpan ID dari Midtrans
                'origin' => 'Bogor',
                'destination' => $request->destination,
                'courier' => $request->courier,
                'service' => $request->service,
                'weight' => $weight,
                'total_price' => $totalPrice,
                'masukan' => $request->masukan,
                'alamat' => $request->alamat,
                'payment_photo' => $paymentPhotoPath,
                'status' => $status, // Gunakan status yang sudah ditentukan
                'payment_method' => $request->payment_method_selected,
            ]);

            foreach ($cartItems as $item) {
                $order->orderItems()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->harga_diskon,
                ]);

                $item->product->decrement('stock', $item->quantity);
                $item->delete();
            }

            return redirect()->route('welcome')->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal: ' . $e->getMessage(),
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Gagal membuat pesanan: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal membuat pesanan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function handleMidtransCallback(Request $request)
    {
        $serverKey = config('midtrans.serverKey');
        $hashed = hash('sha512', $request->order_id.$request->status_code.$request->gross_amount.$serverKey);

        if($hashed != $request->signature_key) {
            Log::warning("Midtrans Callback: Invalid Signature Key for Order ID: {$request->order_id}");
            return response('Invalid Signature Key', 403);
        }

        $transactionStatus = $request->transaction_status;
        $fraudStatus = $request->fraud_status;
        $orderId = $request->order_id; // Ini adalah order_id_midtrans yang Anda kirim ke Snap
        $grossAmount = $request->gross_amount;

        // Cari pesanan berdasarkan order_id_midtrans yang Anda simpan di database
        $order = Order::where('order_id_midtrans', $orderId)->first();
        if (!$order) {
            Log::warning("Midtrans Callback: Order not found for ID: {$orderId}");
            return response('Order not found', 404);
        }

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $order->status = 'Challenged';
            } else if ($fraudStatus == 'accept') {
                $order->status = 'Paid';
            }
        } else if ($transactionStatus == 'settlement') {
            $order->status = 'Paid';
        } else if ($transactionStatus == 'pending') {
            $order->status = 'Pending Payment';
        } else if ($transactionStatus == 'deny') {
            $order->status = 'Denied';
        } else if ($transactionStatus == 'expire') {
            $order->status = 'Expired';
        } else if ($transactionStatus == 'cancel') {
            $order->status = 'Cancelled';
        }
        $order->save();

        Log::info("Midtrans Callback: Order ID {$orderId}, Status: {$transactionStatus}, New Order Status: {$order->status}");

        return response('OK', 200);
    }
}