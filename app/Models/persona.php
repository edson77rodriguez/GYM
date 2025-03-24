<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class Persona extends Model implements Authenticatable
{
    use HasFactory, AuthenticatableTrait;

    protected $table = 'personas';
    protected $primaryKey = 'id_persona'; // Indicar la clave primaria correcta

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
        return $this->belongsTo(Rol::class, 'id_rol', 'id_rol');  // Definir correctamente la clave foránea
    }

    public function proveedor()
    {
        return $this->hasOne(Proveedor::class, 'id_persona');
    }

    public function empleado()
    {
        return $this->hasOne(Empleado::class, 'id_persona');
    }

    public function socios()
    {
        return $this->hasMany(Socio::class, 'id_persona');
    }
    

    public function user()
    {
        return $this->hasMany(User::class, 'id_persona');
    }
}
