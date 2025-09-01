<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdenPreviewController extends Controller
{
    // Vista previa compartida (para cliente y admin)
    public function show($ordenId)
    {
        $orden = Orden::with(['user', 'items.material', 'documentos'])
                    ->findOrFail($ordenId);

        // Verificar permisos
        if (Auth::user()->role !== 'admin' && Auth::user()->id !== $orden->user_id) {
            abort(403, 'No tienes permisos para ver esta orden');
        }

        return view('orders.preview', compact('orden'));
    }

    // Confirmación por parte del cliente
    public function confirmarOrden($ordenId)
    {
        $orden = Orden::where('user_id', Auth::id())
                    ->where('id', $ordenId)
                    ->where('estado', 'borrador')
                    ->firstOrFail();

        $orden->confirmar();

        // TODO: Enviar notificación al admin

        return redirect()->route('client.dashboard')
                        ->with('success', 'Orden confirmada y enviada para aprobación');
    }

    // Acciones del administrador
    public function accionAdmin(Request $request, $ordenId)
    {
        $orden = Orden::findOrFail($ordenId);
        
        $request->validate([
            'accion' => 'required|in:aprobar,rechazar',
            'comentarios' => 'nullable|string|max:500'
        ]);

        if ($request->accion === 'aprobar') {
            $orden->update([
                'estado' => Orden::ESTADO_APROBADO,
                'consideraciones' => $request->comentarios
            ]);
            $mensaje = 'Orden aprobada correctamente';
        } else {
            $orden->update([
                'estado' => Orden::ESTADO_DENEGADO,
                'consideraciones' => $request->comentarios
            ]);
            $mensaje = 'Orden rechazada correctamente';
        }

        // TODO: Enviar notificación al cliente

        return redirect()->route('admin.dashboard')->with('success', $mensaje);
    }
}