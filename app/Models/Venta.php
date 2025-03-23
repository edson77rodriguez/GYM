<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Venta extends Model
{
    use HasFactory;

    protected $table = 'ventas';

    protected $fillable = [
        'id_socio',
        'fecha_venta',
        'total',
    ];

    public function socio()
    {
        return $this->belongsTo(Socio::class, 'id_socio');
    }

    public function detallesVentas()
    {
        return $this->hasMany(DetalleVenta::class, 'id_venta');
    }
}
