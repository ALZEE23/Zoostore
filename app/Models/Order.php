<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'order_id_midtrans', // Tambahkan ini
        'origin',
        'destination',
        'courier',
        'service',
        'weight',
        'total_price',
        'masukan',
        'alamat',
        'payment_photo',
        'status',
        'payment_method' // Pastikan ini juga ada jika belum
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'weight' => 'integer',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productRatings()
    {
        return $this->hasMany(ProductRating::class);
    }
}