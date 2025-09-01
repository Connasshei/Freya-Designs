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
        
        $ordenesPendientes = Orden::where('estado', 'pendiente')
        ->with(['user']) // Cargar relación user
        ->get(['id', 'user_id', 'precio_total', 'estado']);
        
        $materials = Material::get(['id', 'nombre', 'precio_por_kg', 'cantidad_stock']);
        
        return view('admin.dashboard', compact('ordenesPendientes', 'materials'));
    }

    public function actualizarEstadoOrden(Request $request, Orden $orden)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,aprobado,denegado,completado',
            // 'consideraciones' => 'nullable|string' // Solo si realmente lo envías
        ]);

        $data = ['estado' => $request->estado];

        // Solo actualiza consideraciones si viene en el request
        if ($request->has('consideraciones')) {
            $data['consideraciones'] = $request->consideraciones;
        }

        $orden->update($data);

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
    public function storeMaterial(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio_por_kg' => 'required|numeric|min:0',
            'cantidad_stock' => 'required|numeric|min:0',
        ]);
        Material::create($request->only('nombre', 'precio_por_kg', 'cantidad_stock'));
        return redirect()->back()->with('success', 'Material agregado correctamente.');
    }

    public function updateMaterial(Request $request, Material $material)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio_por_kg' => 'required|numeric|min:0',
            'cantidad_stock' => 'required|numeric|min:0',
        ]);
        $material->update($request->only('nombre', 'precio_por_kg', 'cantidad_stock'));
        return redirect()->back()->with('success', 'Material actualizado correctamente.');
    }
}   
