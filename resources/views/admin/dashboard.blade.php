@extends('layouts.app')

@section('title', 'Panel de Administración')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Panel de Administración</h1>
        <div>
            <span class="me-3">Usuario: {{ Auth::user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">Cerrar Sesión</button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Pedidos Pendientes</h5>
                </div>
                <div class="card-body">
                    @if($ordenesPendientes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Precio</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ordenesPendientes as $orden)
                                <tr>
                                    <td>{{ $orden->id }}</td>
                                    <td>{{ $orden->user->name }}</td>
                                    <td>Bs{{ number_format($orden->precio_total, 2) }}</td>
                                    <td>
                                        <span class="badge bg-warning">{{ ucfirst($orden->estado) }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.orders.preview', $orden->id) }}" 
                                            class="btn btn-info btn-sm mb-1">
                                            <i class="fas fa-eye"></i> Vista Previa
                                        </a>
                                        
                                        <form action="{{ route('admin.ordens.update-status', $orden) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="estado" value="aprobado">
                                            <button type="submit" class="btn btn-success btn-sm">Aprobar</button>
                                        </form>
                                        <form action="{{ route('admin.ordens.update-status', $orden) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="estado" value="denegado">
                                            <button type="submit" class="btn btn-danger btn-sm">Denegar</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach 
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-center">No hay pedidos pendientes</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">Control de Stock</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Material</th>
                                    <th>Precio/cm³</th>
                                    <th>Stock Disponible</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($materials as $material)
                                <tr>
                                    <td>{{ $material->nombre }}</td>
                                    <td>Bs{{ number_format($material->precio_por_kg, 2) }}</td>
                                    <td>{{ $material->cantidad_stock }} m³</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editStockModal{{ $material->id }}">
                                            Editar Stock
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modales para editar stock -->
@foreach($materials as $material)
<div class="modal fade" id="editStockModal{{ $material->id }}" tabindex="-1" aria-labelledby="editStockModalLabel{{ $material->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStockModalLabel{{ $material->id }}">
                    Editar Stock - {{ $material->nombre }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.materials.update-stock', $material) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="cantidad_stock_{{ $material->id }}" class="form-label">
                            Cantidad en Stock
                        </label>
                        <input type="number" class="form-control" 
                                id="cantidad_stock_{{ $material->id }}" 
                                name="cantidad_stock" 
                                value="{{ $material->cantidad_stock }}" 
                                min="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Font Awesome para iconos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- Incluir Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection