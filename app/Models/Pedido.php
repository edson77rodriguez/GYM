<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'id_proveedor',
        'id_suplemento',
        'cantidad',
        'fecha_pedido',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

    public function suplemento()
    {
        return $this->belongsTo(Suplemento::class, 'id_suplemento');
    }
}
