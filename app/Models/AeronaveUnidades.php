<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AeronaveUnidades extends Model
{
    use HasFactory;
    protected $table = 'aeronave_unidad';
    protected $fillable = [
        'unidad',
        'codigos'
    ];
}
