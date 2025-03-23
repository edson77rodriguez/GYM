<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Socio extends Model
{
    use HasFactory;

    protected $table = 'socios';

    protected $fillable = [
        'id_persona',
        'fecha_inscripcion',
        'fecha_vencimiento',
        'id_estado_mem',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }

    public function estadoMembresia()
    {
        return $this->belongsTo(EstadoMembresia::class, 'id_estado_mem');
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'id_socio');
    }

    public function membresias()
    {
        return $this->hasMany(Membresia::class, 'id_socio');
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'id_socio');
    }
}
