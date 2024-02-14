<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tours extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'descripcion', 'fecha', 'precio'];

    public function reservas()
    {
        return $this->hasMany(Reservas::class, 'id_tour'); //hasMany indica que un tour puede tener múltiples reservas.
    }
}
