@extends('extras.layout')

@section('content')
<div class="container mx-auto p-4 sm:p-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
        <h1 class="text-2xl sm:text-3xl font-bold text-center sm:text-left">Historial de productos restados</h1>

        <!-- Buscador por fecha -->
        <form action="{{ route('products.reduced') }}" method="GET" class="flex flex-col sm:flex-row gap-2 items-center w-full sm:w-auto">
            <input type="date" name="date" id="date"
                value="{{ request('date') }}"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1a5276] w-full sm:w-auto">
            <button type="submit"
                    class="px-4 py-2 bg-[#1a5276] text-white rounded hover:bg-[#154360] transition w-full sm:w-auto">
                Filtrar
            </button>
            <a href="{{ route('products.reduced') }}"
            class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition w-full sm:w-auto text-center">
                Limpiar
            </a>
        </form>
    </div>

    <!-- Tabla responsive -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded overflow-hidden text-sm sm:text-base">
            <thead class="bg-[#1a5276] text-white">
                <tr>
                    <th class="py-3 px-4 sm:px-6 text-left">Código</th>
                    <th class="py-3 px-4 sm:px-6 text-left">Nombre</th>
                    <th class="py-3 px-4 sm:px-6 text-left">Descripción</th>
                    <th class="py-3 px-4 sm:px-6 text-left">Usuario</th>
                    <th class="py-3 px-4 sm:px-6 text-left">Fecha</th>
                    <th class="py-3 px-4 sm:px-6 text-left">Hora</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($decrements as $dec)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="py-3 px-4 sm:px-6">{{ $dec->product->product_code ?? 'N/A' }}</td>
                        <td class="py-3 px-4 sm:px-6">{{ $dec->product->name ?? 'N/A' }}</td>
                        <td class="py-3 px-4 sm:px-6">{{ $dec->product->description ?? 'Sin descripción' }}</td>
                        <td class="py-3 px-4 sm:px-6">{{ $dec->user_id }}</td>
                        <td class="py-3 px-4 sm:px-6">{{ $dec->created_at->timezone('America/Costa_Rica')->format('d/m/Y') }}</td>
                        <td class="py-3 px-4 sm:px-6">{{ $dec->created_at->timezone('America/Costa_Rica')->format('H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-4 text-center text-gray-500">No hay registros de productos restados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="mt-4">
        {{ $decrements->links() }}
    </div>
</div>
@endsection
