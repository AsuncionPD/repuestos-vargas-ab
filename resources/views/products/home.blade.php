@extends('extras.layout')

@section('content')
<div class="px-8 mt-12">
    <!-- Encabezado y Buscador -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Nuestros Productos</h2>
    </div>


    <!-- Buscador -->
    <div class="mb-6">
        <input type="text" id="searchInput" placeholder="Buscar producto..."
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a5276] focus:outline-none">
    </div>

    <!-- Grid de Productos -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="productGrid">
        @foreach ($products as $product)
            <a href="{{ route('products.show', $product->id) }}" class="block bg-white rounded-xl shadow-lg p-4 hover:shadow-2xl transition-transform duration-300 product-item">
                <div class="w-full h-48 overflow-hidden rounded-lg">
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-contain">
                </div>
                
                <div class="mt-4">
                    <h3 class="text-xl font-bold text-gray-800 product-name">{{ $product->name }}</h3>
                    <p class="text-gray-500 product-code hidden">{{ $product->product_code }}</p>
                    
                    @auth
                        <p class="product-description hidden">{{ $product->description }}</p>
                        <p class="text-lg text-cyan-600 font-semibold">₡{{ number_format($product->price) }}</p>
                    @endauth
                
                    @auth
                        @if ($product->units === 0)
                            <div class="mt-2 text-red-600 text-sm font-semibold flex items-center gap-1">
                                ⚠️ Producto agotado
                            </div>
                        @endif
                    @endauth
                    
                </div>
            </a>
        @endforeach
    </div>


</div>

<!-- Script para el buscador -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const productItems = document.querySelectorAll(".product-item");

    function normalize(text) {
        return text
            .toLowerCase()
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .replace(/[^\w\s]/gi, "")
            .trim();
    }

    searchInput.addEventListener("input", function () {
        const searchTerm = normalize(searchInput.value);
        const searchWords = searchTerm.split(" ");

        productItems.forEach(item => {
            const name = normalize(item.querySelector(".product-name").textContent);
            const code = normalize(item.querySelector(".product-code").textContent);
            const descElement = item.querySelector(".product-description");

            const description = descElement ? normalize(descElement.textContent) : "";

            const combined = name + " " + code + " " + description;

            const matches = searchWords.every(word => combined.includes(word));

            item.style.display = matches ? "block" : "none";
        });
    });
});
</script>
@endsection