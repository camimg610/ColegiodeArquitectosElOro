<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salon extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'SALONES';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'id_salon';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nombre',
        'capacidad',
        'ubicacion',
        'activo',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'capacidad' => 'integer',
        'activo' => 'boolean',
    ];

    /**
     * Relationship with events
     */
    public function events()
    {
        return $this->hasMany(Event::class, 'id_salon', 'id_salon');
    }

    /**
     * Relationship with rentals
     */
    public function rentals()
    {
        return $this->hasMany(RentalDetail::class, 'id_salon', 'id_salon');
    }
}
