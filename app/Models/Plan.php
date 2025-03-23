<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Plan extends Model
{
    use HasFactory;

    protected $table = 'planes';
    protected $primaryKey = 'id_plan';
    protected $fillable = [
        'nom_plan',
        'desc_plan',
        'costo',
    ];

    public function membresias()
    {
        return $this->hasMany(Membresia::class, 'id_plan');
    }
}
