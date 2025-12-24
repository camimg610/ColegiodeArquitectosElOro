<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'PERMISOS';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'id_permiso';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nombre_permiso',
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
     * Relationship with roles
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'ROLES_PERMISOS', 'id_permiso', 'id_rol', 'id_permiso', 'id_rol');
    }
}
