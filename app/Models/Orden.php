<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'estado',
        'precio_total',
        'consideraciones'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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
