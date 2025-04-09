@extends('extras.layout')

@section('content')
<div class="max-w-6xl mx-auto mt-12 p-6 bg-white rounded-xl shadow-lg">
    <div class="flex flex-col md:flex-row">
        <!-- Imagen del producto -->
        <div class="md:w-1/2">
            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-80 object-cover rounded-lg">
        </div>

        <!-- Información del producto -->
        <div class="md:w-1/2 md:pl-6 mt-4 md:mt-0 flex flex-col justify-center">
            <div class="flex flex-col gap-3">
                <h2 class="text-3xl font-bold text-gray-800">{{ $product->name }}</h2>
                <p class="text-lg text-[#1a5276] font-semibold">${{ number_format($product->price, 2) }}</p>
                <p class="mt-2">{{ $product->description }}</p>
                <p class="text-md"><strong>Código:</strong> {{ $product->product_code }}</p>
                <p class="text-md"><strong>Categoría:</strong> {{ $product->category->name }}</p>

                @auth
                    <p><strong>Ubicación:</strong> {{ $product->location ?? 'No especificada' }}</p>
                    <p><strong>Unidades disponibles:</strong> <span id="units">{{ $product->units }}</span></p>

                    <button onclick="decreaseUnits({{ $product->id }})" class="mt-2 text-red-600 rounded-lg hover:text-red-700 underline">
                        Restar Unidad
                    </button>
                @endauth
            </div>
        </div>
    </div>
</div>




<!-- Sección de Productos Aleatorios -->
@if($randomProducts->count() > 0)
<div class="max-w-6xl mx-auto mt-12 p-6">
    <h3 class="text-2xl font-semibold text-gray-800 text-center mb-6">También te puede interesar</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($randomProducts as $randomProduct)
        <div class="bg-white p-4 rounded-lg shadow-md">
            <img src="{{ $randomProduct->image }}" alt="{{ $randomProduct->name }}" class="w-full h-48 object-cover rounded-lg">
            <h4 class="text-lg font-semibold text-gray-800 mt-3">{{ $randomProduct->name }}</h4>
            <p class="text-[#1a5276] font-bold mt-1">${{ number_format($randomProduct->price, 2) }}</p>
            <a href="{{ route('products.show', $randomProduct->id) }}" class="block text-center bg-[#1a5276] text-white py-2 mt-3 rounded-lg hover:bg-[#154360] transition">
                Ver más
            </a>
        </div>
        @endforeach
    </div>
</div>
@endif

<script>
function decreaseUnits(productId) {
    let password = prompt("Ingrese la contraseña para disminuir unidades:");
    if (password === "1234") {
        fetch(`/products/${productId}/decrease`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById("units").textContent = data.units;
            } else {
                alert("No se pudo actualizar.");
            }
        })
        .catch(error => console.error('Error:', error));
    } else {
        alert("Contraseña incorrecta.");
    }
}
</script>

@endsection
