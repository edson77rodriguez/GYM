<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class Persona extends Model implements Authenticatable
{
    use HasFactory, AuthenticatableTrait;

    // Nombre de la tabla en la base de datos
    protected $table = 'personas';

    // Los campos que pueden ser asignados masivamente
    protected $fillable = [
        'nom', 'ap', 'am', 'correo', 'contrasena', 'id_rol'
    ];

    // Los campos que deben ser ocultados cuando se convierten a un array o JSON
    protected $hidden = [
        'contrasena', 'remember_token'
    ];

    // Si no estás usando un incremento automático para el campo 'id_persona'
    protected $primaryKey = 'id_persona';
}
