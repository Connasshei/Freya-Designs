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
    });
});

// Rutas para administradores
Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Ruta para actualizar estado de órdenes (FALTABA ESTA)
        Route::put('/ordens/{orden}/update-status', [AdminController::class, 'actualizarEstadoOrden'])->name('ordens.update-status');
        
        Route::put('/materials/{material}/update-stock', [AdminController::class, 'actualizarMaterialStock'])->name('materials.update-stock');
    });
});
