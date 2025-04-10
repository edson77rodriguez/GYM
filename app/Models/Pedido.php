<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';
    protected $primaryKey = 'id_pedido';

    protected $fillable = [
        'id_proveedor',
        'id_suplemento',
        'cantidad',
        'fecha_pedido',
        'recibido'
    ];
    protected $dates = [
        'fecha_pedido',
        'created_at',
        'updated_at'
    ];
    protected $casts = [
        'recibido' => 'boolean',
        'fecha_pedido' => 'datetime'
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }
    
    public function suplemento()
    {
        return $this->belongsTo(Suplemento::class, 'id_suplemento');
    }
    // Agregar estos métodos al modelo Pedido

public function getEstadoAttribute()
{
    // Lógica para determinar el estado (puedes implementar tu propia lógica)
    return 'Pendiente'; // Ejemplo básico
}

public function scopeProveedor($query, $proveedorId)
{
    if ($proveedorId) {
        return $query->where('id_proveedor', $proveedorId);
    }
    return $query;
}

public function scopeSuplemento($query, $suplementoId)
{
    if ($suplementoId) {
        return $query->where('id_suplemento', $suplementoId);
    }
    return $query;
}

public function scopeEntreFechas($query, $inicio, $fin)
{
    if ($inicio && $fin) {
        return $query->whereBetween('fecha_pedido', [$inicio, $fin]);
    }
    return $query;
}
}
