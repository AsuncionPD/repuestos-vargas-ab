@extends('extras.layout')

@section('content')
<div class="max-w-4xl mx-auto mt-12 bg-white p-8 rounded-2xl shadow-2xl border border-gray-100">
    <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-8">Editar Producto</h2>

    @if (session('success'))
        <div class="mb-4 text-green-600 bg-green-100 p-3 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Nombre del Producto -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-600 mb-1">Nombre del Producto</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-[#1a5276] focus:outline-none transition">
            </div>

            <!-- Precio -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-600 mb-1">Precio (₡)</label>
                <input type="number" name="price" step="0.01" min="0" value="{{ old('price', $product->price) }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-[#1a5276] focus:outline-none transition">
            </div>

            <!-- Descripción -->
            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-600 mb-1">Descripción</label>
                <textarea name="description" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-[#1a5276] focus:outline-none transition">{{ old('description', $product->description) }}</textarea>
            </div>

            <!-- Unidades -->
            <div>
                <label for="units" class="block text-sm font-medium text-gray-600 mb-1">Unidades Disponibles</label>
                <input type="number" name="units" min="0" value="{{ old('units', $product->units) }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-[#1a5276] focus:outline-none transition">
            </div>

            <!-- Ubicación -->
            <div>
                <label for="location" class="block text-sm font-medium text-gray-600 mb-1">Ubicación (opcional)</label>
                <input type="text" name="location" value="{{ old('location', $product->location) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-[#1a5276] focus:outline-none transition">
            </div>

            <!-- Categoría -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-600 mb-1">Categoría</label>
                <select name="category_id" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-[#1a5276] focus:outline-none transition">
                    <option value="">Selecciona una categoría</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Imagen -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-600 mb-1">Imagen del Producto</label>
                <input type="file" name="image" accept="image/*"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-[#1a5276] focus:outline-none transition">

                @if($product->image)
                    <div class="mt-2">
                        <img src="{{ asset($product->image) }}" alt="Imagen actual" class="w-24 h-24 object-cover rounded-xl border">
                    </div>
                @endif
            </div>
        </div>

        <!-- Botón -->
        <div class="pt-4">
            <button type="submit"
                    class="w-full bg-[#1a5276] hover:bg-[#154360] text-white font-semibold py-3 rounded-xl transition shadow-lg">
                Actualizar Producto
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const priceInput = document.querySelector('input[name="price"]');
    const unitsInput = document.querySelector('input[name="units"]');

    function restrictToNumbers(event) {
        event.target.value = event.target.value.replace(/[^\d.]/g, '');
    }

    function restrictToIntegers(event) {
        event.target.value = event.target.value.replace(/\D/g, '');
    }

    priceInput.addEventListener('input', restrictToNumbers);
    unitsInput.addEventListener('input', restrictToIntegers);
});
</script>
@endsection
