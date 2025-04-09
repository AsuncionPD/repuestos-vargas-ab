<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Mostrar formulario de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Login de usuario
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
    
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password], $request->remember)) {
            return redirect()->intended('/'); // Aquí se redirige luego de iniciar sesión
        }
    
        return back()->withErrors(['username' => 'Las credenciales no son correctas.']);
    }
    

    // Mostrar formulario de registro
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Registrar nuevo usuario
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,collaborator',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Auth::login($user);

        return redirect('/auth/dashboard')->with('success', 'Usuario creado correctamente.');
    }

    // Cerrar sesión
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function dashboard()
    {
        $users = User::all(); // Obtener todos los usuarios
        return view('auth.dashboard', compact('users'));
    }
    
    public function edit(User $user)
    {
        return view('auth.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,collaborator',
        ]);

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('auth.dashboard')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('auth.dashboard')->with('success', 'Usuario eliminado correctamente.');
    }


    
}
