<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_code', 4)->unique(); // Código de producto de 4 dígitos
            $table->foreignId('category_id')
                  ->constrained('products_categories')
                  ->onDelete('cascade'); // Relación con la categoría
                  
            $table->string('name')->unique(); // Nombre del producto
            $table->text('description')->nullable(); // Descripción opcional
            $table->decimal('price', 10, 2)->default(0); // ✅ Precio con valor por defecto
            $table->string('location')->nullable(); // Ubicación opcional
            $table->integer('units')->default(0); // Cantidad en stock
            $table->string('image')->nullable(); // Imagen del producto
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('products');
    }
};
