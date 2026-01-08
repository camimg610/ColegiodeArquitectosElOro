<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'ALQUILER';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'id_alquiler';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'fecha',
        'hora_inicio',
        'hora_fin',
        'costo',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'costo' => 'integer',
    ];

    /**
     * Relationship with details
     */
    public function details()
    {
        return $this->hasMany(RentalDetail::class, 'id_alquiler', 'id_alquiler');
    }

    /**
     * Get the first user through details
     */
    public function user()
    {
        $detail = $this->details()->first();
        return $detail ? $detail->user : null;
    }

    /**
     * Accesor para obtener el primer salón a través de los detalles
     */
    public function getSalonDetalleAttribute()
    {
        $detail = $this->details()->first();
        return $detail ? $detail->salon : null;
    }
}
