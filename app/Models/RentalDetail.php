<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalDetail extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'ALQUILER_DETALLE';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'id_alquiler_detalle';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id_alquiler',
        'cedula_usuario',
        'id_salon',
        'fecha_registro',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'fecha_registro' => 'datetime',
    ];

    /**
     * Relationship with rental
     */
    public function rental()
    {
        return $this->belongsTo(Rental::class, 'id_alquiler', 'id_alquiler');
    }

    /**
     * Relationship with user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'cedula_usuario', 'Cedula');
    }

    /**
     * Relationship with salon
     */
    public function salon()
    {
        return $this->belongsTo(Salon::class, 'id_salon', 'id_salon');
    }
}
