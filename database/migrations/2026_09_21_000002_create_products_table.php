<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('product_categories')->restrictOnDelete();
            $table->string('name', 200);
            $table->string('slug', 220)->unique();
            $table->string('badge', 50)->nullable();
            $table->string('vehicle_compatibility', 255)->nullable();
            $table->text('short_description')->nullable();
            $table->longText('full_description')->nullable();
            $table->decimal('estimated_price', 12, 2)->nullable();
            $table->string('main_image', 255)->nullable();
            $table->json('gallery_images')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
