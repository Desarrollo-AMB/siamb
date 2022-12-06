<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuncionTripulante extends Model
{
    use HasFactory;
    protected $table = 'funcion_tripulante';
    protected $fillable = [
        '*'
    ];

    public function funcionTrip() {
        return $this->hasMany(Fam0001B1Tripulacion::class, 'funcion');
    }

}
