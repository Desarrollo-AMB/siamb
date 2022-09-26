<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AeronaveMatricula extends Model
{
    use HasFactory;
    protected $table = 'aeronave_matricula';
    protected $fillable = [
        'matricula',
        'aeronave_id'
    ];
    public function aeronaves()
    {
        return $this->belongsTo(AeronaveModelo::class);
    }
}
