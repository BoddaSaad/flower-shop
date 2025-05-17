<?php

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Product::class)->constrained()->cascadeOnDelete();
            $table->string('quantity');
            $table->string('message');
            $table->string('receiver_number');
            $table->string('delivery_date');
            $table->string('unit_price_in_cents');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_product');
    }
};
