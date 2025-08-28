<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use App\Models\Material;
use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrdenController extends Controller
{
    public function clientDashboard()
    {
        $ordens = Orden::where('user_id', Auth::id())->with(['items.material', 'documentos'])->get();
        return view('client.dashboard', compact('ordens'));
    }

    public function create()
    {
        $materiales = Material::all();
        return view('client.crear-orden', compact('materiales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'cantidad' => 'required|integer|min:1',
            'documento_diseno' => 'required|file|mimes:dxf,svg,dwg,ai,pdf|max:10240'
        ]);

        // Calcular precio
        $material = Material::find($request->material_id);
        $precioBase = $material->precio_por_kg * 0.1; // Precio base por unidad
        
        // Procesar archivo
        $precio = 0;
        $archivo = null;
        $nombreDocumento = null;
        $path = null;
        $tiempoCorte = 0;

        if ($request->hasFile('documento_diseno')) {
            $archivo = $request->file('documento_diseno');
            $nombreDocumento = time() . '_' . $archivo->getClientOriginalName();
            $path = $archivo->storeAs('disenos', $nombreDocumento, 'public');
            
            // Calcular tiempo de corte 
            $tamanoArchivo = $archivo->getSize(); // en bytes
            $tiempoCorte = $tamanoArchivo / 1000; // Ejemplo: 0.01 min por cada 1000 bytes
            
            $precio = $precioBase * $request->cantidad * (1 + $tiempoCorte / 10);
        }

        // Crear pedido
        $orden = Orden::create([
            'user_id' => Auth::id(),
            'estado' => 'pendiente',
            'precio_total' => $precio
        ]);

        // Crear item del pedido
        $orden->items()->create([
            'material_id' => $request->material_id,
            'cantidad' => $request->cantidad,
            'precio' => $precio
        ]);

        // Guardar archivo
        if ($archivo) {
            $orden->documentos()->create([
                'nombre_documento' => $nombreDocumento,
                'nombre_original' => $archivo->getClientOriginalName(),
                'path' => $path,
                'tiempo_corte' => $tiempoCorte
            ]);
        }

        return redirect()->route('client.dashboard')->with('success', 'Pedido enviado correctamente.');
    }
}