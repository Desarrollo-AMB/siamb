<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parroquias extends Model
{
    use HasFactory;
    protected $table = 'parroquias';
    public $timestamps = false;
    /*use HasFactory;

    protected $fillable = [
        '*',
    ];*/

    public function municipios()
    {
        return $this->belongsTo(Municipios::class, 'id_municipio');
    }
}
