@extends('extras.layout')

@section('content')
    <div class="container mx-auto max-w-full px-6 lg:flex lg:space-x-8">
        <!-- Tarjeta de Perfil -->
        <div class="bg-white p-8 shadow-lg rounded-lg mb-8 lg:mb-0 lg:w-1/4">
            <h1 class="text-3xl font-semibold text-center text-gray-800 mb-6">Perfil</h1>

            <div class="space-y-5">
                <div class="flex items-center justify-between border-b pb-8">
                    <p class="text-gray-700 font-medium">Nombre:</p>
                    <p class="text-gray-900">{{ Auth::user()->name }}</p>
                </div>

                <div class="flex items-center justify-between border-b pb-8">
                    <p class="text-gray-700 font-medium">Usuario:</p>
                    <p class="text-gray-900">{{ Auth::user()->username }}</p>
                </div>

                <div class="flex items-center justify-between border-b pb-8">
                    <p class="text-gray-700 font-medium">Correo:</p>
                    <p class="text-gray-900">{{ Auth::user()->email }}</p>
                </div>

                <div class="flex items-center justify-between">
                    <p class="text-gray-700 font-medium">Rol:</p>
                    <span class="px-3 py-1 rounded-full
                        {{ Auth::user()->role === 'admin' ? 'text-blue-600' : 'text-green-500' }}">
                        {{ ucfirst(Auth::user()->role) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Tabla de Usuarios -->
        @if(Auth::user()->role === 'admin')
            <div class="bg-white p-8 shadow-lg rounded-lg lg:w-3/4">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-3xl font-semibold text-gray-800">Lista de Usuarios</h2>
                    <a href="{{ route('register') }}" class="hidden lg:flex text-[#1a5276] hover:text-[#154360] focus:outline-none px-5 py-2.5 flex items-center gap-2 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 4v16m8-8H4"/>
                        </svg>
                        Agregar Usuario
                    </a>
                </div>

                <a href="{{ route('register') }}" class="lg:hidden text-[#1a5276] hover:text-[#154360] focus:outline-none px-5 py-2.5 flex items-center gap-2 mb-6 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 4v16m8-8H4"/>
                    </svg>
                    Agregar Usuario
                </a>

                <div class="overflow-y-auto max-h-72">
                    <table class="w-full border border-gray-300 shadow-sm rounded-lg">
                        <thead>
                            <tr class="bg-gray-100 text-gray-800 uppercase text-sm">
                                <th class="py-4 px-6 text-left">Nombre</th>
                                <th class="py-4 px-6 text-left">Usuario</th>
                                <th class="py-4 px-6 text-left">Correo</th>
                                <th class="py-4 px-6 text-left">Rol</th>
                                <th class="py-4 px-6 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach($users as $user)
                                <tr class="border-t hover:bg-gray-100 transition">
                                    <td class="py-4 px-6">{{ $user->name }}</td>
                                    <td class="py-4 px-6">{{ $user->username }}</td>
                                    <td class="py-4 px-6">{{ $user->email }}</td>
                                    <td class="py-4 px-6">
                                        <span class="px-3 py-1 rounded-full
                                            {{ $user->role === 'admin' ? 'text-blue-600' : 'text-green-500' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 flex justify-center gap-3">
                                        <a href="{{ route('users.edit', $user) }}" class="bg-[#1a5276] text-white px-4 py-2 rounded-lg shadow-md flex items-center gap-2 hover:bg-[#154360] transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M12 20h9"/>
                                                <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4Z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-md flex items-center gap-2 hover:bg-red-600 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M3 6h18"/>
                                                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                                    <path d="M10 11v6"/>
                                                    <path d="M14 11v6"/>
                                                    <path d="M5 6h14v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

    <!-- Botones de administrar categorías y productos con iconos más bonitos -->
    <div class="flex flex-col lg:flex-row justify-center space-y-6 lg:space-y-0 lg:space-x-6 mt-8">
        <!-- Botón para administrar categorías -->
        <a href="{{ route('categories.table') }}" class="bg-[#1a5276] text-white px-8 py-4 rounded-lg shadow-lg text-xl font-semibold hover:underline transition duration-300 flex items-center gap-3 justify-center">
            <!-- Icono de categorías (Folder) -->
            <i class="fas fa-folder-open text-2xl"></i>
            Administrar Categorías
        </a>
        
        <!-- Botón para administrar productos -->
        <a href="{{ route('products.adminTable') }}" class="bg-[#1a5276] text-white px-8 py-4 rounded-lg shadow-lg text-xl font-semibold hover:underline transition duration-300 flex items-center gap-3 justify-center">
            <!-- Icono de productos (Box) -->
            <i class="fas fa-box-open text-2xl"></i>
            Administrar Productos
        </a>

    </div>



@endsection
