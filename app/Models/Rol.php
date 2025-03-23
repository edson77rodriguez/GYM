<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Rol extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [
        'desc_rol',
    ];
    protected $primaryKey = 'persona_id';
    public function personas()
    {
        return $this->hasMany(Persona::class, 'id_rol');
    }
}
