@extends('extras.layout')

@section('content')
    <div class="max-w-md mx-auto bg-white p-8 shadow-md rounded">
        <h2 class="text-2xl font-bold text-center mb-6">Editar usuario</h2>
        <form method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Nombre</label>
                <input type="text" id="name" name="name" class="w-full p-3 border border-gray-300 rounded" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="mb-4">
                <label for="username" class="block text-gray-700">Usuario</label>
                <input type="text" id="username" name="username" class="w-full p-3 border border-gray-300 rounded" value="{{ old('username', $user->username) }}" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700">Correo electrónico</label>
                <input type="email" id="email" name="email" class="w-full p-3 border border-gray-300 rounded" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700">Contraseña</label>
                <input type="password" id="password" name="password" class="w-full p-3 border border-gray-300 rounded" placeholder="Dejar vacío si no deseas cambiarla">
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700">Confirmar contraseña</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="w-full p-3 border border-gray-300 rounded" placeholder="Dejar vacío si no deseas cambiarla">
                <p id="password-error" class="text-red-500 text-sm mt-1 hidden">Las contraseñas no coinciden.</p>
            </div>

            <div class="mb-4">
                <label for="role" class="block text-gray-700">Rol</label>
                <select id="role" name="role" class="w-full p-3 border border-gray-300 rounded" required>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrador</option>
                    <option value="collaborator" {{ $user->role === 'collaborator' ? 'selected' : '' }}>Colaborador</option>
                </select>
            </div>

            <div class="mb-4">
                <button type="submit" class="w-full bg-[#1a5276] text-white p-3 rounded">Actualizar</button>
            </div>
        </form>
    </div>

    <script>
        const password = document.getElementById('password');
        const passwordConfirmation = document.getElementById('password_confirmation');
        const passwordError = document.getElementById('password-error');
        const submitBtn = document.querySelector('button[type="submit"]');

        // Función para verificar que las contraseñas coincidan
        function checkPasswordMatch() {
            if (password.value === passwordConfirmation.value) {
                passwordError.classList.add('hidden');
                submitBtn.disabled = false;
            } else {
                passwordError.classList.remove('hidden');
                submitBtn.disabled = true;
            }
        }

        // Verificar mientras se escribe
        password.addEventListener('input', checkPasswordMatch);
        passwordConfirmation.addEventListener('input', checkPasswordMatch);
    </script>
@endsection
