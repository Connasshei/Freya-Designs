<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrdenController;




Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');



// Rutas para clientes
Route::middleware(['auth'])->group(function () {
    Route::prefix('client')->name('client.')->group(function () {
        Route::get('/dashboard', [OrdenController::class, 'clientDashboard'])->name('dashboard');
        Route::get('/ordens/create', [OrdenController::class, 'create'])->name('ordens.create');
        Route::post('/ordens', [OrdenController::class, 'store'])->name('ordens.store');
        Route::get('/orders/{orden}/preview', [OrdenController::class, 'previewCliente'])
            ->name('orders.preview');
        Route::get('orders/{orden}', [OrdenController::class, 'show'])->name('orders.show');
    
            
    });
});

// Rutas para administradores
Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        Route::put('/ordens/{orden}/update-status', [AdminController::class, 'actualizarEstadoOrden'])->name('ordens.update-status');
        
        Route::put('/materials/{material}/update-stock', [AdminController::class, 'actualizarMaterialStock'])->name('materials.update-stock');
        
        Route::get('/orders/{orden}/preview', [OrdenController::class, 'previewAdmin'])
            ->name('orders.preview'); // ← Mismo nombre pero diferente namespace
    });
});


// Dashboard cliente
Route::get('/client/dashboard', [OrdenController::class, 'clientDashboard'])->name('client.dashboard');

// Crear orden (cliente)
Route::get('/client/ordens/create', [OrdenController::class, 'create'])->name('client.ordens.create');
Route::post('/client/ordens', [OrdenController::class, 'store'])->name('client.ordens.store');

// Vista previa de orden (admin y cliente)
Route::get('/admin/ordens/{id}/preview', [OrdenController::class, 'previewAdmin'])->name('admin.ordens.preview');
Route::get('/client/ordens/{id}/preview', [OrdenController::class, 'previewCliente'])->name('client.ordens.preview');

// Descargar documento de diseño
Route::get('/ordens/{id}/descargar-diseno', [OrdenController::class, 'downloadDiseno'])->name('ordens.downloadDiseno');

// Actualizar consideraciones (admin)
Route::put('/admin/ordens/{id}/consideraciones', [OrdenController::class, 'updateConsideraciones'])->name('admin.ordens.update-consideraciones');

// Rutas para materiales (admin)
Route::post('/admin/materials', [AdminController::class, 'storeMaterial'])->name('admin.materials.store');
Route::put('/admin/materials/{material}', [AdminController::class, 'updateMaterial'])->name('admin.materials.update');