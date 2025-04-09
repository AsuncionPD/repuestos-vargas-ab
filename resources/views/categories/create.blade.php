@extends('extras.layout')

@section('title', 'Agregar Categoría')

@section('content')
<div class="max-w-4xl mx-auto mt-12 bg-white p-8 rounded-2xl shadow-2xl border border-gray-100">
    <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-8">Agregar Nueva Categoría</h2>

    @if (session('success'))
        <div class="mb-4 text-green-600 bg-green-100 p-3 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('categories.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Nombre de la Categoría -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-600 mb-1">Nombre de la Categoría</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-[#1a5276] focus:outline-none transition">
                @error('name')
                    <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Descripción -->
            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-600 mb-1">Descripción</label>
                <textarea name="description" id="description" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-[#1a5276] focus:outline-none transition">{{ old('description') }}</textarea>
                @error('description')
                    <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="flex justify-between">
            <button type="submit"
                    class="w-full bg-[#1a5276] hover:bg-[#154360 text-white font-semibold py-3 rounded-xl transition shadow-lg">
                Guardar Categoría
            </button>
        </div>
    </form>
</div>
@endsection
