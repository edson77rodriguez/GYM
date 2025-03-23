<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Detalle_Venta extends Model
{
    use HasFactory;

    protected $table = 'detalles_ventas';

    protected $fillable = [
        'id_venta',
        'id_suplemento',
        'cantidad',
        'precio',
    ];

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'id_venta');
    }

    public function suplemento()
    {
        return $this->belongsTo(Suplemento::class, 'id_suplemento');
    }
}
