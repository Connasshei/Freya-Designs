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
        $ordens = Orden::where('user_id', Auth::id())->with(['items.material'])->get();
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
        'documento_diseno' => 'required|file|mimes:pdf,jpg,jpeg,png,gif,svg,dxf,dwg,ai',
    ]);

    // Guardar archivo
    $rutaArchivo = $request->file('documento_diseno')->store('disenos', 'public');

    // Calcular precio total
    $material = Material::find($request->material_id);
    $precio_total = $request->precio_total;

    Orden::create([
        'user_id' => auth()->id(),
        'material_id' => $request->material_id,
        'precio_total' => $precio_total,
        'documento_diseno' => $rutaArchivo,
        'consideraciones' => $request->consideraciones,
        'ancho' => $request->ancho,
        'alto' => $request->alto,
        'tiempo_corte' => $request->tiempo_corte,
        // 'estado' => 'pendiente', // por defecto
    ]);

    return redirect()->route('client.dashboard')->with('success', 'Orden creada correctamente.');
}

public function previewAdmin($id)
{
    $orden = Orden::with(['user', 'material', 'items.material'])->findOrFail($id);
    return view('orders.preview-admin', compact('orden'));
}

public function previewCliente($id)
{
    $orden = Orden::with(['user', 'material', 'items.material'])
        ->where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();
    return view('orders.preview-cliente', compact('orden'));
}

public function downloadDiseno($id)
{
    $orden = Orden::findOrFail($id);

    $user = auth()->user();
    /* if (!$user->isAdmin() && $orden->user_id !== $user->id) {
        abort(403, 'No tienes permisos para descargar este archivo');
    } */

    $filePath = storage_path('app/public/' . $orden->documento_diseno);

    if (!file_exists($filePath)) {
        abort(404, 'El archivo no se encontró en el servidor');
    }

    $nombre = basename($orden->documento_diseno);

    return response()->download($filePath, $nombre);
}

public function updateConsideraciones(Request $request, $id)
{
    $orden = Orden::findOrFail($id);
    $orden->consideraciones = $request->input('consideraciones');
    $orden->save();

    return redirect()->back()->with('success', 'Consideraciones actualizadas correctamente.');
}
}