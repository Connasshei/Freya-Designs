<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use App\Models\Material;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function dashboard()
    {
        //seleccionar los elementos de las ordenes que están con estado = pendiente, esto para mostrarlas a los administradores
        $ordenesPendientes = Orden::where('estado', 'pendiente')        
            ->get(['id', 'user_id', 'precio_total', 'estado']);
        
        //seleccionar los materiales disponibles, esto para mostrarlos en el dashboard
        $materials = Material::get(['id', 'nombre', 'precio_por_kg', 'cantidad_stock']);
        
        return view('admin.dashboard', compact('ordenesPendientes', 'materials'));
    }

    public function actualizarEstadoOrden(Request $request, Orden $orden)       
    {
        $request->validate([
            'estado' => 'required|in:pendiente,aprobado,denegado,completado',
            'consideraciones' => 'nullable|string'
        ]);

        $orden->update([
            'estado' => $request->estado,
            'consideraciones' => $request->consideraciones
        ]);

        return redirect()->back()->with('success', 'Estado del pedido actualizado correctamente.');
    }

    public function actualizarMaterialStock(Request $request, Material $material)      
    {
        $request->validate([
            'cantidad_stock' => 'required|integer|min:0'
        ]);

        $material->update([
            'cantidad_stock' => $request->cantidad_stock
        ]);

        return redirect()->back()->with('success', 'Stock actualizado correctamente.');
    }
}
