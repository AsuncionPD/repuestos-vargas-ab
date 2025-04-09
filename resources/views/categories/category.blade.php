@extends('extras.layout')

@section('content')
<div class="container mx-auto p-4 sm:p-6">
    <!-- Encabezado con botón responsivo -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3 sm:gap-0">
        <h1 class="text-2xl sm:text-3xl font-bold text-center sm:text-left">Categorías</h1>
        <a href="{{ route('categories.create') }}" class="flex items-center px-4 py-2 text-[#1a5276] hover:text-[#154360] focus:outline-none hover:border-[#154360] transition">
            <i class="fas fa-plus mr-2"></i> Agregar Categoría
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4 text-center">
            {{ session('success') }}
        </div>
    @endif

    <!-- Buscador automático sin botón -->
    <div class="mb-4">
        <input type="text" id="search" placeholder="Buscar por nombre..."
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1a5276]" />
    </div>

    <!-- Tabla responsive -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded overflow-hidden text-sm sm:text-base">
            <thead class="bg-[#1a5276] text-white">
                <tr>
                    <th class="py-3 px-4 sm:px-6 text-left">ID</th>
                    <th class="py-3 px-4 sm:px-6 text-left">Nombre</th>
                    <th class="py-3 px-4 sm:px-6 text-left">Descripción</th>
                    <th class="py-3 px-4 sm:px-6 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody id="categoriesTable">
                @forelse ($categories as $category)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="py-3 px-4 sm:px-6">{{ $category->id }}</td>
                        <td class="py-3 px-4 sm:px-6">{{ $category->name }}</td>
                        <td class="py-3 px-4 sm:px-6">
                            {{ $category->description && trim($category->description) !== '' ? $category->description : 'Sin descripción' }}
                        </td>
                        <td class="py-3 px-4 sm:px-6 text-center">
                            <div class="flex flex-col sm:flex-row gap-2 justify-center">
                                <a href="{{ route('categories.edit', $category->id) }}" class="bg-[#1a5276] text-white px-3 py-2 rounded hover:bg-[#154360] transition text-xs sm:text-sm">Editar</a>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-3 py-2 rounded hover:bg-red-700 transition text-xs sm:text-sm">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-4 text-center text-gray-500">No hay categorías registradas.</td>
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
        const table = document.getElementById('categoriesTable');
        const rows = table.getElementsByTagName('tr');

        for (let i = 0; i < rows.length; i++) {
            // Se asume que la segunda columna (índice 1) contiene el nombre de la categoría
            const nameCell = rows[i].getElementsByTagName('td')[1];
            if (nameCell) {
                const nameText = nameCell.textContent || nameCell.innerText;
                // Si el input coincide con parte del nombre, la fila se muestra; de lo contrario, se oculta.
                if (nameText.toUpperCase().indexOf(filter) > -1) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }
    });
</script>
@endsection
