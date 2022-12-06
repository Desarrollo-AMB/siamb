<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriasMilitares extends Model
{
    use HasFactory;
    protected $table = 'categorias_militares';
    protected $fillable = [
        '*',
    ];
    public $timestamps = false;

    public function datos_militares() {
    	return $this->hasOne(DatosMilitares::class, 'codigo_categoria', 'codigo_categoria');
    }
}
