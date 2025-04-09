@extends('extras.layout')

@section('content')
<div class="max-w-4xl mx-auto mt-12 bg-white p-8 rounded-2xl shadow-2xl border border-gray-100">
    <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-8">Editar Categoría</h2>

    @if (session('success'))
        <div class="mb-4 text-green-600 bg-green-100 p-3 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('categories.update', $category->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Nombre de la Categoría -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-600 mb-1">Nombre</label>
                <input type="text" name="name" id="name" value="{{ $category->name }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-[#1a5276] focus:outline-none transition">
            </div>

            <!-- Descripción -->
            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-600 mb-1">Descripción</label>
                <textarea name="description" id="description" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-[#1a5276] focus:outline-none transition">{{ $category->description }}</textarea>
            </div>
        </div>

        <div class="flex justify-between">
            <button type="submit"
                    class="w-full bg-[#1a5276] hover:bg-[#154360] text-white font-semibold py-3 rounded-xl transition shadow-lg">
                Actualizar
            </button>
        </div>
    </form>
</div>
@endsection
