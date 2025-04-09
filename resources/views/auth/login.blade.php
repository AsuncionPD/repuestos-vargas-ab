@extends('extras.layout')

@section('content')
    <div class="max-w-lg w-full mx-auto bg-white p-10 shadow-lg rounded-lg">
        <h2 class="text-3xl font-bold text-center mb-4">INICIAR SESIÓN</h2>
        
        <!-- Mensaje de acceso restringido -->
        <p class="text-center text-gray-700 bg-gray-100 border border-gray-300 rounded-lg p-3 mb-6">
            Este acceso es exclusivo para nuestro equipo de trabajo. Si no tienes autorización, por favor, contacta con el administrador.
        </p>

        <!-- Mostrar errores de autenticación -->
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-6">
                <label for="username" class="block text-gray-700 font-medium">Usuario</label>
                <input type="text" id="username" name="username" class="w-full p-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a5276] focus:outline-none" required>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-700 font-medium">Contraseña</label>
                <input type="password" id="password" name="password" class="w-full p-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a5276] focus:outline-none" required>
            </div>
            <div class="mb-6">
                <button type="submit" class="w-full bg-[#1a5276] text-white py-4 rounded-lg text-lg font-semibold hover:bg-[#154360] transition">
                    Iniciar sesión
                </button>
            </div>
        </form>
    </div>
@endsection
