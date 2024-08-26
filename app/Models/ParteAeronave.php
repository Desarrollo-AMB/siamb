<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParteAeronave extends Model
{
    use HasFactory;
    protected $table = 'parte_aeronave';
    protected $fillable = [
        'unidad',
        'sistema',
        'matricula',
        'serial',
        'situacion',
        'fecha',
        'observacion',
        'user_created',
        'user_updated',
    ];
}
