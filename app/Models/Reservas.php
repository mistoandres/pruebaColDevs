<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservas extends Model
{
    use HasFactory;
    protected $fillable = ['id_tour', 'usuario', 'fecha_reserva', 'cantidad_personas'];

    public function tours()
    {
        return $this->belongsTo(Tours::class, 'id_tour'); //belongsTo indica que una reserva pertenece a un tour específico.
    }
}