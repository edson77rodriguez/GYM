<?php

namespace App\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Membresia extends Model
{
    use HasFactory;

    protected $table = 'membresias';

    protected $fillable = [
        'id_socio',
        'id_plan',
        'fecha_inicio',
        'fecha_fin',
        'costo',
    ];
    // Asegura que las fechas se conviertan a Carbon automáticamente
    protected $dates = [
        'fecha_inicio',
        'fecha_fin',
    ];

    // Si no quieres agregar las fechas en el array $dates puedes usar un mutador para convertirlas
    public function getFechaInscripcionAttribute($value)
    {
        return Carbon::parse($value); // Convierte el valor a Carbon
    }

    public function getFechaVencimientoAttribute($value)
    {
        return Carbon::parse($value); // Convierte el valor a Carbon
    }

    public function socio()
    {
        return $this->belongsTo(Socio::class, 'id_socio');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'id_plan');
    }
}
