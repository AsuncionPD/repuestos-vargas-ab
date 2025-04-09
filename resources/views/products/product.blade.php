@extends('extras.layout')

@section('content')
<div class="container mx-auto p-4">
    <!-- Encabezado con botón responsivo -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3 sm:gap-0">
        <h1 class="text-3xl font-bold">Productos</h1>
        <!-- Verificar si el usuario está autenticado y si tiene el rol de admin -->
        <a href="{{ route('products.create') }}"
            class="flex items-center px-4 py-2 text-[#1a5276] hover:text-[#154360] focus:outline-none hover:border-[#154360] transition">
            + Agregar Producto
        </a>
    </div>

    <!-- Notificación de éxito -->
    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Buscador automático sin botón -->
    <div class="mb-4">
        <input type="text" id="search" placeholder="Buscar por nombre o código..."
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1a5276]" />
    </div>

    <!-- Tabla de productos -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-[#1a5276] text-white text-sm sm:text-base">
                <tr>
                    <th class="py-3 px-4 sm:px-6 text-left">Código</th>
                    <th class="py-3 px-4 sm:px-6 text-left">Nombre</th>
                    <th class="py-3 px-4 sm:px-6 text-left">Categoría</th>
                    <th class="py-3 px-4 sm:px-6 text-left">Descripción</th>
                    <th class="py-3 px-4 sm:px-6 text-left">Precio</th>
                    <th class="py-3 px-4 sm:px-6 text-left">Unidades</th>
                    <th class="py-3 px-4 sm:px-6 text-left">Ubicación</th>
                    <th class="py-3 px-4 sm:px-6 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody id="productsTable">
                @forelse ($products as $product)
                    <tr class="border-b hover:bg-gray-100 text-sm sm:text-base">
                        <td class="py-3 px-4 sm:px-6">{{ $product->product_code }}</td>
                        <td class="py-3 px-4 sm:px-6">{{ $product->name }}</td>
                        <td class="py-3 px-4 sm:px-6">
                            {{ $product->category->name ?? 'Sin categoría' }}
                        </td>
                        <td class="py-3 px-4 sm:px-6">
                            {{ $product->description && trim($product->description) !== '' ? $product->description : 'Sin descripción' }}
                        </td>
                        <td class="py-3 px-4 sm:px-6">₡{{ number_format($product->price, 2) }}</td>
                        <td class="py-3 px-4 sm:px-6">{{ $product->units }}</td>
                        <td class="py-3 px-4 sm:px-6">{{ $product->location ?? 'Sin ubicación' }}</td>
                        <td class="py-3 px-4 sm:px-6 text-center">
                            <div class="flex flex-col sm:flex-row gap-2 justify-center">
                                <a href="{{ route('products.edit', $product->id) }}" class="bg-[#1a5276] text-white px-3 py-2 rounded hover:bg-[#154360] transition text-xs sm:text-sm">Editar</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este producto?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-3 py-2 rounded hover:bg-red-700 transition text-xs sm:text-sm">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-4 text-center text-gray-500">No hay productos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Script para filtrado automático -->
<script>
    const searchInput = document.getElementById('search');
    searchInput.addEventListener('keyup', function() {
        const filter = searchInput.value.toUpperCase();
        const table = document.getElementById('productsTable');
        const rows = table.getElementsByTagName('tr');

        // Iterar por cada fila en la tabla
        for (let i = 0; i < rows.length; i++) {
            const codigoCell = rows[i].getElementsByTagName('td')[0];
            const nombreCell = rows[i].getElementsByTagName('td')[1];
            
            if (codigoCell && nombreCell) {
                const codigoText = codigoCell.textContent || codigoCell.innerText;
                const nombreText = nombreCell.textContent || nombreCell.innerText;
                
                // Verificar si el filtro coincide con el código o nombre
                if (codigoText.toUpperCase().indexOf(filter) > -1 || nombreText.toUpperCase().indexOf(filter) > -1) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }
    });
</script>
@endsection
