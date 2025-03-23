<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Suplemento extends Model
{
    use HasFactory;

    protected $table = 'suplementos';

    protected $fillable = [
        'nom_suplemento',
        'id_categoria',
        'id_marca',
        'desc_suplemento',
        'precio',
        'stock',
        'imagen_suplemento', // Si decides agregar una imagen también en esta tabla
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'id_marca');
    }

    public function detallesVentas()
    {
        return $this->hasMany(DetalleVenta::class, 'id_suplemento');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_suplemento');
    }
}
