<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Los atributos que deben ser asignados masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'role',
    ];

    /**
     * Los atributos que deben ser ocultados para los arreglos.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos de datos nativos.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Para que la autenticación use el username en lugar del email.
     */
    public function getAuthIdentifierName()
    {
        return 'username'; // Cambiamos 'email' por 'username'
    }
}
