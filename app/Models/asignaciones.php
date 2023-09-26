<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class asignaciones extends Model
{
    use SoftDeletes;
    use HasFactory;
    
    protected $fillable = ['*'];
    protected $table = 'asignaciones';
    protected $dates = ['deleted_at'];
    
    /*public function conceptoNomina()
    {
        return $this->belongsTo(ConceptosNomina::class,  'codigo_concepto','id_concepto');
    }*/
}