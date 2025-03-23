<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    protected $fillable = [
        'nom_cat',
    ];

    public function suplementos()
    {
        return $this->hasMany(Suplemento::class, 'id_categoria');
    }
}
