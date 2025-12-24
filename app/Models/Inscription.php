<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'INSCRIPCIONES';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'id_inscripcion';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'fecha_inscripcion',
        'estado',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'estado' => 'string',
    ];

    /**
     * Relationship with details
     */
    public function details()
    {
        return $this->hasMany(InscriptionDetail::class, 'id_inscripcion', 'id_inscripcion');
    }

    /**
     * Relationship with event
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'id_evento', 'id_evento');
    }

    /**
     * Relationship with user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'cedula_usuario', 'Cedula');
    }
}
