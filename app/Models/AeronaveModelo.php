<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AeronaveModelo extends Model
{
    use HasFactory;
    protected $table = 'aeronave_modelo';
    protected $fillable = [
        'aeronave',
        'modelo'
    ];
    public function matriculas()
    {
        return $this->hasMany(AeronaveMatricula::class);
    }
}
