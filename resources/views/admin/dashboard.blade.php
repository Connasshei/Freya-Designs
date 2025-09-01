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
                                            Vista Previa
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
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editMaterialModal{{ $material->id }}">
                                            Editar
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Control de Stock</h5>
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addMaterialModal">
                                <i class="fas fa-plus"></i> Nuevo Material
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modales para editar stock -->
@foreach($materials as $material)
<div class="modal fade" id="editMaterialModal{{ $material->id }}" tabindex="-1" aria-labelledby="editMaterialModalLabel{{ $material->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.materials.update', $material) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editMaterialModalLabel{{ $material->id }}">
                        Editar Material - {{ $material->nombre }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="nombre" value="{{ $material->nombre }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Costo Material (Bs/m²)</label>
                        <input type="number" class="form-control" name="precio_por_kg" value="{{ $material->precio_por_kg }}" min="0" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stock Disponible (m³)</label>
                        <input type="number" class="form-control" name="cantidad_stock" value="{{ $material->cantidad_stock }}" min="0" step="0.01" required>
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

<!-- Modal para agregar material -->
<div class="modal fade" id="addMaterialModal" tabindex="-1" aria-labelledby="addMaterialModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.materials.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addMaterialModalLabel">Agregar Nuevo Material</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nombre_material" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre_material" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="precio_material" class="form-label">Costo Material (Bs/m²)</label>
                        <input type="number" class="form-control" id="precio_material" name="precio_por_kg" min="0" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="cantidad_stock_material" class="form-label">Stock Disponible (m³)</label>
                        <input type="number" class="form-control" id="cantidad_stock_material" name="cantidad_stock" min="0" step="0.01" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Agregar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Font Awesome para iconos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- Incluir Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection