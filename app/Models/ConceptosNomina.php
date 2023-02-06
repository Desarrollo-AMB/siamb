<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConceptosNomina extends Model
{
    use HasFactory;
    protected $table = 'conceptos_nomina';
    protected $fillable = [
        '*',
    ];
    public $timestamps = false;
}
