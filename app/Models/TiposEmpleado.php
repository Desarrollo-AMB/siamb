<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiposEmpleado extends Model
{
    use HasFactory;

    protected $primaryKey = 'tipo_emp';
    public $timestamps = false;
}
