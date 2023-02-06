<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConceptosPagados extends Model
{
    use HasFactory;
    protected $table = 'conceptos_pagados';
    protected $fillable = [
        '*',
    ];
    public $timestamps = false;
}
