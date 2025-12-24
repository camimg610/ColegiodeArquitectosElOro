<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     */
    protected $table = 'USUARIO';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'Cedula';

    /**
     * Indicates if the IDs are auto-incrementing.
     */
    public $incrementing = false;

    /**
     * The data type of the auto-incrementing ID.
     */
    protected $keyType = 'integer';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'Cedula',
        'Nombre',
        'Apellido',
        'Direccion',
        'Email',
        'Usuario',
        'Contraseña',
        'Activo',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'Contraseña',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'Activo' => 'boolean',
    ];

    /**
     * Get the password for the user.
     */
    public function getAuthPassword()
    {
        return $this->Contraseña;
    }

    /**
     * Get the username for the user.
     */
    public function getAuthIdentifier()
    {
        return $this->Usuario;
    }

    /**
     * Get the username field for authentication.
     */
    public function getAuthIdentifierName()
    {
        return 'Usuario';
    }

    /**
     * Relationship with roles
     */
    public function roles()
    {
        return $this->belongsToMany(
            Role::class,
            'USUARIO_ROLES',
            'cedula_usuario',
            'id_rol'
        )->wherePivot('activo', true);
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole($role)
    {
        return $this->roles()->where('tipo_rol', $role)->exists();
    }

    /**
     * Check if user has any of the given roles
     */
    public function hasAnyRole($roles)
    {
        $userRoles = array_map(fn($r) => trim(mb_strtolower($r)), $this->roles()->pluck('tipo_rol')->toArray());
        $requiredRoles = array_map(fn($r) => trim(mb_strtolower($r)), (array) $roles);
        return !empty(array_intersect($userRoles, $requiredRoles));
    }
}
