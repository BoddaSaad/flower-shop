<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->enum('status', ['pending', 'cancelled', 'confirmed'])->default('pending');
            $table->enum('shipping_status', ['pending', 'preparing', 'shipped', 'delivered'])->default('pending');
            $table->string('reference')->unique();
            $table->string('transaction')->nullable();
            $table->unsignedBigInteger('amount_in_cents');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
