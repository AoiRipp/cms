<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ✅ Drop old pivot tables if exist
        Schema::dropIfExists('facility_product');
        Schema::dropIfExists('attribute_product');

        // ✅ Create product_promo
        Schema::create('product_promo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('promo_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // ✅ Create product_facility
        Schema::create('product_facility', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('facility_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // ✅ Create product_attribute
        Schema::create('product_attribute', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('property_attribute_id')->constrained()->onDelete('cascade');
            $table->string('value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Rollback (drop new pivot tables)
        Schema::dropIfExists('product_promo');
        Schema::dropIfExists('product_facility');
        Schema::dropIfExists('product_attribute');

        // Recreate old tables if rollback is needed
        Schema::create('facility_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('facility_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('attribute_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('property_attribute_id')->constrained()->onDelete('cascade');
            $table->string('value')->nullable();
            $table->timestamps();
        });
    }
};
