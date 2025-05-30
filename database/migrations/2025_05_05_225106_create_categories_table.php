<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->boolean('featured')->default(false);
            $table->boolean('landing')->default(false);
            $table->boolean('navbar')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
