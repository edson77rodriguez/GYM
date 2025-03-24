<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Disponibilidad extends Model
{
    use HasFactory;

    protected $table = 'disponibilidades';
    protected $primaryKey = 'id_disponibilidad';

    protected $fillable = [
        'desc_dispo',
    ];

    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'id_disponibilidad');
    }
}
