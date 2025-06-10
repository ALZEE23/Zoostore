<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null'); // Opsional, untuk konteks pesanan
            $table->integer('rating'); // Rating bintang (1-5)
            $table->text('comment')->nullable(); // Deskripsi/komentar rating
            $table->timestamps();

            $table->unique(['user_id', 'product_id', 'order_id'], 'user_product_order_unique_rating'); // Pastikan user hanya bisa rating produk di order tertentu sekali
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_ratings');
    }
};