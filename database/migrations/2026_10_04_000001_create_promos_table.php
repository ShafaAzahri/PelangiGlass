<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category')->nullable();
            $table->text('desc')->nullable();
            $table->string('img')->nullable();
            $table->string('badge')->nullable();
            $table->string('original_price')->nullable();
            $table->string('promo_price')->nullable();
            $table->string('discount_percent')->nullable();
            $table->string('discount')->nullable();
            $table->string('code')->nullable();
            $table->string('valid_until')->nullable();
            $table->string('vehicle_compatibility')->nullable();
            $table->json('benefits')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
