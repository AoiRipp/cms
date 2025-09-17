<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Example: "Panjang Tanah"
            $table->string('unit')->nullable(); // Example: "m", "carport", etc.
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_attributes');
    }
};
