<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConceptosNomina extends Model
{
    use HasFactory;
    protected $table = 'conceptos_nomina';
    protected $fillable = [
        '*',
    ];
   
    //protected $dates = ['deleted_at'];
    //public $timestamps = false;
}