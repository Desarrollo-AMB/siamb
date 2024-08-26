<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipios extends Model
{
    use HasFactory;
    protected $table = 'municipios';
    public $timestamps = false;
    /*use HasFactory;

    protected $fillable = [
        '*',
    ];*/

    public function estados()
    {
        return $this->belongsTo(Estados::class, 'id_estado');
    }
}
