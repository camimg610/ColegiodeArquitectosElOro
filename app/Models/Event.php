<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'EVENTOS';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'id_evento';

    /**
     * Indicates if the IDs are auto-incrementing.
     */
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'id_salon',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'hora_inicio' => 'integer',
        'hora_fin' => 'integer',
        'id_salon' => 'integer',
    ];

    /**
     * Relationship with salon
     */
    public function salon()
    {
        return $this->belongsTo(Salon::class, 'id_salon', 'id_salon');
    }

    /**
     * Relationship with inscriptions
     */
    public function inscriptions()
    {
        return $this->hasMany(InscriptionDetail::class, 'id_evento', 'id_evento');
    }
}
