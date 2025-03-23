<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Asistencia extends Model
{
    use HasFactory;

    protected $table = 'asistencias';

    protected $fillable = [
        'id_socio',
        'fecha_asi',
        'hora_entrada',
        'hora_salida',
    ];

    public function socio()
    {
        return $this->belongsTo(Socio::class, 'id_socio');
    }
}
