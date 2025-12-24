<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InscriptionDetail extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'INSCRIPCIONES_DETALLE';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'id_inscripcion_detalle';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id_inscripcion',
        'cedula_usuario',
        'id_evento',
        'fecha_registro',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'fecha_registro' => 'datetime',
    ];

    /**
     * Relationship with inscription
     */
    public function inscription()
    {
        return $this->belongsTo(Inscription::class, 'id_inscripcion', 'id_inscripcion');
    }

    /**
     * Relationship with user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'cedula_usuario', 'Cedula');
    }

    /**
     * Relationship with event
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'id_evento', 'id_evento');
    }
}
