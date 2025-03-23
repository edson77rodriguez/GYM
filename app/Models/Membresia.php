<?php

namespace App\Models;

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

    public function socio()
    {
        return $this->belongsTo(Socio::class, 'id_socio');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'id_plan');
    }
}
