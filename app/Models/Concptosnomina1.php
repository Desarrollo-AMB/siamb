<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Concptosnomina1 extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'primas_deducciones';
    protected $fillable = [
        '*',
    ];
     protected $dates = ['deleted_at'];
    public $timestamps = false;
}