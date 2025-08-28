<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 
        'precio_por_kg', 
        'cantidad_stock'
    ];

    public function ordenItems()
    {
        return $this->hasMany(OrdenItem::class);
    }
}
