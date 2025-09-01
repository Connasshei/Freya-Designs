<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'material_id',
        'cantidad',          
        'documento_diseno',  
        'estado',
        'precio_total',
        'consideraciones',
        'confirmada_por_cliente',
        'tiempo_corte',
        'ancho',
        'alto',
    ];
    protected $casts = [
        'confirmada_por_cliente' => 'boolean',
        'precio_total' => 'decimal:2',
        'cantidad' => 'integer'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function material() // ← NUEVA RELACIÓN IMPORTANTE
    {
        return $this->belongsTo(Material::class);
    }
    public function items()
    {
        return $this->hasMany(OrdenItem::class, 'orden_id');
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class, 'orden_id');
    }
}
