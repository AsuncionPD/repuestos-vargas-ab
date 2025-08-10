@extends('extras.layout')

@section('content')
    <div class="max-w-md mx-auto bg-white p-8 shadow-md rounded">
        <h2 class="text-2xl font-bold text-center mb-6">Registrar nuevo usuario</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Nombre</label>
                <input type="text" id="name" name="name" class="w-full p-3 border border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
                <label for="username" class="block text-gray-700">Usuario</label>
                <input type="text" id="username" name="username" class="w-full p-3 border border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Correo electrónico</label>
                <input type="email" id="email" name="email" class="w-full p-3 border border-gray-300 rounded" required>
            </div>
            
            <div class="mb-4 relative">
                <label for="password" class="block text-gray-700">Contraseña</label>
                <input type="password" id="password" name="password" class="w-full p-3 border border-gray-300 rounded pr-10" required>
                <button type="button" onclick="togglePassword('password', 'eye-password')" class="absolute right-3 top-10 text-gray-600">
                    <svg id="eye-password" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>
            
            <div class="mb-4 relative">
                <label for="password_confirmation" class="block text-gray-700">Confirmar contraseña</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="w-full p-3 border border-gray-300 rounded pr-10" required>
                <button type="button" onclick="togglePassword('password_confirmation', 'eye-confirm')" class="absolute right-3 top-10 text-gray-600">
                    <svg id="eye-confirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
                <p id="password-error" class="text-red-500 text-sm mt-1 hidden">Las contraseñas no coinciden.</p>
            </div>

            
            <div class="mb-4">
                <label for="role" class="block text-gray-700">Rol</label>
                <select id="role" name="role" class="w-full p-3 border border-gray-300 rounded" required>
                    <option value="admin">Administrador</option>
                    <option value="collaborator">Colaborador</option>
                </select>
            </div>
            <div class="mb-4">
                <button type="submit" class="w-full bg-[#1a5276] text-white p-3 rounded" id="submit-btn" disabled>Registrar</button>
            </div>
        </form>
    </div>

    <script>
        const password = document.getElementById('password');
        const passwordConfirmation = document.getElementById('password_confirmation');
        const passwordError = document.getElementById('password-error');
        const submitBtn = document.getElementById('submit-btn');
    
        function checkPasswordMatch() {
            if (password.value === passwordConfirmation.value) {
                passwordError.classList.add('hidden');
                submitBtn.disabled = false;
            } else {
                passwordError.classList.remove('hidden');
                submitBtn.disabled = true;
            }
        }
    
        password.addEventListener('input', checkPasswordMatch);
        passwordConfirmation.addEventListener('input', checkPasswordMatch);
    
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
