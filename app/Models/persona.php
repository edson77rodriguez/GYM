<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class Persona extends Model implements Authenticatable
{
    use HasFactory;

    protected $table = 'personas';

    protected $fillable = [
        'nom',
        'ap',
        'am',
        'telefono',
        'correo',
        'contrasena',
        'id_rol',
    ];

    public function rol()
    {
        return $this->belongsTo(Role::class, 'id_rol');
    }

    public function proveedor()
    {
        return $this->hasOne(Proveedor::class, 'id_persona');
    }

    public function empleado()
    {
        return $this->hasOne(Empleado::class, 'id_persona');
    }

    public function socio()
    {
        return $this->hasOne(Socio::class, 'id_persona');
    }
}
