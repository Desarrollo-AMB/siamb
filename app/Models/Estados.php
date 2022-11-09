<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estados extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_estado';
    public $timestamps = false;
    /*use HasFactory;

    protected $fillable = [
        '*',
    ];*/

    public function ubicaciones()
{
    return $this->belongsTo(Ubicaciones::class, 'codigo_estado', 'id_estado');
}
}
