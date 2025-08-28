<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $fillable = [
        'orden_id', 
        'nombre_documento', 
        'nombre_original', 
        'path', 
        'tiempo_corte'
    ];

    public function orden()
    {
        return $this->belongsTo(Orden::class);
    }
}
