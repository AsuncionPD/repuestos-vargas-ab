@extends('extras.layout')

@section('content')
<div class="max-w-6xl mx-auto mt-12 p-6 bg-white rounded-xl shadow-lg">
    <div class="flex flex-col md:flex-row">
        <!-- Imagen del producto -->
        <div class="md:w-1/2">
            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-80 object-contain rounded-lg">
        </div>

        <!-- Información del producto -->
        <div class="md:w-1/2 md:pl-6 mt-4 md:mt-0 flex flex-col justify-center">
            <div class="flex flex-col gap-3">
                <h2 class="text-3xl font-bold text-gray-800">{{ $product->name }}</h2>
                @auth
                    <p class="text-lg text-[#1a5276] font-semibold">₡{{ number_format($product->price) }}</p>
                    <p class="mt-2">{{ $product->description }}</p>
                @endauth
                <p class="text-md"><strong>Código:</strong> {{ $product->product_code }}</p>
                <p class="text-md"><strong>Categoría:</strong> {{ $product->category->name }}</p>

                @auth
                    <p><strong>Ubicación:</strong> {{ $product->location ?? 'No especificada' }}</p>
                    <p><strong>Unidades disponibles:</strong> <span id="units-{{ $product->id }}">{{ $product->units }}</span></p>
                    
                    <button onclick="decreaseUnits({{ $product->id }})" class="mt-2 text-red-600 rounded-lg hover:text-red-700 underline">
                        Restar Unidad
                    </button>

                @endauth
                
                <a href="https://wa.me/50660391515?text=Hola,%20quiero%20información%20del%20producto:%20{{ urlencode($product->name) }}"
                   target="_blank"
                   class="mt-4 inline-block bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg text-center transition duration-200">
                    Pedir por WhatsApp
                </a>
                
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
        <div class="bg-white p-4 rounded-lg shadow-md flex flex-col justify-between h-full">
            <div>
                <img src="{{ $randomProduct->image }}" alt="{{ $randomProduct->name }}" class="w-full h-48 object-contain rounded-lg">
                <h4 class="text-lg font-semibold text-gray-800 mt-3">{{ $randomProduct->name }}</h4>
            </div>
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
    const unitsElement = document.getElementById(`units-${productId}`);
    const currentUnits = parseInt(unitsElement.textContent);

    if (currentUnits <= 0) {
        alert("⚠️ No hay unidades disponibles para restar.");
        return;
    }

    let password = prompt("Ingrese la contraseña para disminuir unidades:");
    if (password === "1234") {
        fetch(`/products/${productId}/decrease`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({})
        })
        .then(async response => {
            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`HTTP ${response.status}: ${errorText}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                unitsElement.textContent = data.units;
            } else {
                alert("No se pudo actualizar.");
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Error en la petición: " + error.message);
        });
    } else {
        alert("Contraseña incorrecta.");
    }
}


</script>


@endsection
