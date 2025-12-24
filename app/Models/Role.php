<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'ROLES';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'id_rol';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'tipo_rol',
        'descripcion',
        'activo',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Relationship with users
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'USUARIO_ROLES', 'id_rol', 'cedula_usuario', 'id_rol', 'Cedula');
    }

    /**
     * Relationship with permissions
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'ROLES_PERMISOS', 'id_rol', 'id_permiso', 'id_rol', 'id_permiso');
    }
}
