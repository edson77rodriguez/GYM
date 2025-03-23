<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Estado_Membresia extends Model
{
    use HasFactory;

    protected $table = 'estados_membresias';
    protected $primaryKey = 'id_estado_mem';
    protected $fillable = [
        'nom_estado',
    ];

    public function socios()
    {
        return $this->hasMany(Socio::class, 'id_estado_mem');
    }
}
