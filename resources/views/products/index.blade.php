@extends('extras.layout')

@section('content')
<div class="px-8 mt-12">
    <h2 class="text-3xl font-bold text-gray-800 mb-3">{{ $category->name }}</h2>

    <div class="mb-6">
        <input type="text" id="searchInput" placeholder="Buscar producto..."
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-600 focus:outline-none">
    </div>

    @if ($products->isEmpty())
        <p class="text-gray-600 text-lg">No hay productos en esta categoría.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="productGrid">
            @foreach ($products as $product)
                <a href="{{ route('products.show', $product->id) }}" class="block bg-white rounded-xl shadow-lg p-4 hover:shadow-2xl transition-transform duration-300 product-item">
                    <div class="w-full h-48 overflow-hidden rounded-lg">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    </div>
                    <div class="mt-4">
                        <h3 class="text-xl font-bold text-gray-800 product-name">{{ $product->name }}</h3>
                        <p class="text-lg text-cyan-600 font-semibold">${{ number_format($product->price, 2) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const productItems = document.querySelectorAll(".product-item");

    searchInput.addEventListener("input", function () {
        const searchTerm = searchInput.value.toLowerCase();

        productItems.forEach(item => {
            const productName = item.querySelector(".product-name").textContent.toLowerCase();
            item.style.display = productName.includes(searchTerm) ? "block" : "none";
        });
    });
});
</script>
@endsection
