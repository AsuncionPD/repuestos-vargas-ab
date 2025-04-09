<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('products_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Nombre de la categoría
            $table->string('description')->nullable(); // Descripción opcional
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('products_categories');
    }
};

