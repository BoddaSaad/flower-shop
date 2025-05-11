<?php

use App\Models\CartItem;
use App\Models\Gift;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cart_item_gift', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CartItem::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Gift::class)->constrained()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_item_gift');
    }
};
