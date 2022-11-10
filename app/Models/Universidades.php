<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use illuminate\Database\Eloquent\SoftDeletes;

class Universidades extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    public $timestamps = false;

}
