<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Marca extends Model
{
    use HasFactory;

    protected $table = 'marcas';

    protected $fillable = [
        'nom_marca',
    ];

    public function suplementos()
    {
        return $this->hasMany(Suplemento::class, 'id_marca');
    }
}
