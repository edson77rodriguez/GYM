<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mantenimiento extends Model
{
    use HasFactory;

    protected $table = 'mantenimientos';

    protected $fillable = [
        'id_equipo',
        'id_empleado',
        'fecha_programada',
        'desc_estado',
    ];

    // Relaciones
    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'id_equipo');
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }

    // Para convertir la fecha programada en un formato legible
    public function getFechaProgramadaAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');  // Puedes cambiar el formato si lo deseas
    }
}
