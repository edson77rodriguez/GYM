<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Detalle_Venta extends Model
{
    use HasFactory;

    protected $table = 'detalles_ventas';
    protected $primaryKey = 'id_detalle_venta';

    protected $fillable = [
        'id_venta',
        'id_suplemento',
        'cantidad',
        'subtotal',
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
