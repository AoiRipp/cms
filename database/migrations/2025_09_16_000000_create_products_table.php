<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_tags')->nullable();

            // Relations
            $table->foreignId('province_id')->constrained()->onDelete('cascade');
            $table->foreignId('regency_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');

            // Attributes
            $table->decimal('price', 15, 2)->nullable();
            $table->float('luas_tanah')->nullable();
            $table->float('luas_bangunan')->nullable();
            $table->integer('kamar_tidur')->nullable();
            $table->integer('kamar_mandi')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('path');
            $table->timestamps();
        });

        Schema::create('facility_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('facility_id')->constrained()->onDelete('cascade');
        });

        Schema::create('attribute_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('property_attribute_id')->constrained()->onDelete('cascade');
            $table->string('value')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('attribute_product');
        Schema::dropIfExists('facility_product');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('products');
    }
};
