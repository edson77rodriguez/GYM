<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Socio extends Model
{
    use HasFactory;

    protected $table = 'socios';
    protected $primaryKey = 'id_socio';
    protected $fillable = [
        'id_persona',
        'fecha_inscripcion',
        'fecha_vencimiento',
        'id_estado_mem',
    ];

     // Asegura que las fechas se conviertan a Carbon automáticamente
     protected $dates = [
        'fecha_inscripcion',
        'fecha_vencimiento',
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
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }

    public function estadoMembresia()
    {
        return $this->belongsTo(Estado_Membresia::class, 'id_estado_mem');
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
