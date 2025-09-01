@extends('layouts.app')

@section('title', 'Vista Previa de Orden #' . $orden->id)

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Vista Previa - Orden #{{ $orden->id }}</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver al Panel
        </a>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">Información de la Orden</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6>Información del Cliente</h6>
                    <p><strong>Nombre:</strong> {{ $orden->user->name }}</p>
                    <p><strong>Email:</strong> {{ $orden->user->email }}</p>
                    <p><strong>ID Usuario:</strong> {{ $orden->user_id }}</p>
                </div>
                <div class="col-md-6">
                    <h6>Detalles de la Orden</h6>
                    <p><strong>Estado:</strong> 
                        <span class="badge bg-{{ $orden->estado == 'aprobado' ? 'success' : ($orden->estado == 'denegado' ? 'danger' : 'warning') }}">
                            {{ ucfirst($orden->estado) }}
                        </span>
                    </p>
                    <p><strong>Precio Total:</strong> Bs{{ number_format($orden->precio_total, 2) }}</p>
                    <p><strong>Fecha Creación:</strong> {{ $orden->created_at->format('d/m/Y H:i') }}</p>
                    @if($orden->material)
                        <p><strong>Material:</strong> {{ $orden->material->nombre }}</p>
                    @endif
                    @if($orden->cantidad)
                        <p><strong>Cantidad:</strong> {{ $orden->cantidad }}</p>
                    @endif
                    <p><strong>Dimensiones:</strong> {{ $orden->ancho }} mm x {{ $orden->alto }} mm</p>
                </div>
            </div>

            <hr>

            <h6>Documento de Diseño</h6>
            @if($orden->documento_diseno)
                <div class="mb-2">
                    <span class="me-2"><i class="fas fa-file"></i> {{ basename($orden->documento_diseno) }}</span>
                    <a href="{{ route('ordens.downloadDiseno', $orden->id) }}" class="btn btn-success btn-sm" target="_blank">
                        <i class="fas fa-download"></i> Descargar diseño
                    </a>
                </div>
                <div class="mb-3 text-center" style="background: #f8f9fa; border-radius: 8px; padding: 20px;">
                    @php
                        $ext = strtolower(pathinfo($orden->documento_diseno, PATHINFO_EXTENSION));
                        $url = asset('storage/' . $orden->documento_diseno);
                    @endphp

                    @if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'svg']))
                        <img src="{{ $url }}" alt="Vista previa"
                             style="max-width: 100%; max-height: 400px; object-fit: contain; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); background: #fff;">
                    @elseif($ext === 'pdf')
                        <iframe src="{{ $url }}"
                                style="width: 100%; height: 400px; border: none; border-radius: 8px; background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.08);"
                                allowfullscreen>
                        </iframe>
                    @else
                        <div class="alert alert-secondary">
                            Vista previa no disponible para este tipo de archivo.
                        </div>
                    @endif
                </div>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    No hay documento de diseño adjunto para esta orden.
                </div>
            @endif

            <hr>

            @if(auth()->user() && auth()->user()->isAdmin())
                <h6>Acciones de Administración</h6>
                <div class="d-flex gap-2 flex-wrap">
                    <form action="{{ route('admin.ordens.update-status', $orden) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="estado" value="aprobado">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> Aprobar Orden
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.ordens.update-status', $orden) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="estado" value="denegado">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-times"></i> Denegar Orden
                        </button>
                    </form>

                    @if($orden->consideraciones)
                        <button class="btn btn-info" type="button" data-bs-toggle="collapse" 
                                data-bs-target="#consideracionesCollapse">
                            <i class="fas fa-comment"></i> Ver Consideraciones
                        </button>
                    @endif
                </div>

                @if($orden->consideraciones)
                    <div class="collapse mt-3" id="consideracionesCollapse">
                        <div class="card card-body">
                            <h6>Consideraciones:</h6>
                            <p>{{ $orden->consideraciones }}</p>
                        </div>
                    </div>
                @endif
            @endif

            <hr>

            <h6>Comentarios</h6>
            <form action="{{ route('admin.ordens.update-consideraciones', $orden->id) }}" method="POST" class="mb-3">
                @csrf
                @method('PUT')
                <div class="mb-2">
                    <textarea name="consideraciones" class="form-control" rows="3" placeholder="Agrega consideraciones para esta orden...">{{ old('consideraciones', $orden->consideraciones) }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">
                    Guardar Comentarios
                </button>
            </form>

            
        </div>
    </div>
</div>
@endsection