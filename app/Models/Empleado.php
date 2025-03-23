<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Empleado extends Model
{
    use HasFactory;

    protected $table = 'empleados';

    protected $fillable = [
        'id_persona',
        'id_disponibilidad',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }

    public function disponibilidad()
    {
        return $this->belongsTo(Disponibilidad::class, 'id_disponibilidad');
    }

    public function mantenimientos()
    {
        return $this->hasMany(Mantenimiento::class, 'id_empleado');
    }
}
