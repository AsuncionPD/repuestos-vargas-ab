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

            <div class="mb-6 relative">
                <label for="password" class="block text-gray-700 font-medium">Contraseña</label>
                <input type="password" id="password" name="password" class="w-full p-4 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a5276] focus:outline-none" required>
                <button type="button" onclick="togglePassword('password', 'eye-login')" class="absolute right-3 top-11 text-gray-600">
                    <svg id="eye-login" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>

            <div class="mb-6">
                <button type="submit" class="w-full bg-[#1a5276] text-white py-4 rounded-lg text-lg font-semibold hover:bg-[#154360] transition">
                    Iniciar sesión
                </button>
            </div>
        </form>
    </div>

    <script>
        function togglePassword(inputId, eyeId) {
            const input = document.getElementById(inputId);
            const eye = document.getElementById(eyeId);

            if (input.type === 'password') {
                input.type = 'text';
                eye.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.179-3.51m3.402-2.467A9.955 9.955 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.958 9.958 0 01-4.152 5.164M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                `;
            } else {
                input.type = 'password';
                eye.innerHTML = `
                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z"/>
                `;
            }
        }
    </script>
@endsection
