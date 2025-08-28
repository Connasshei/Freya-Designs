@extends('layouts.client')

@section('title', 'Nuevo Pedido')

@section('client-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Nuevo Pedido de Corte Láser</h1>
</div>

@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('client.ordens.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="material_id" class="form-label">Material</label>
                <select class="form-select" id="material_id" name="material_id" required>
                    <option value="">Seleccione un material</option>
                    @foreach($materiales as $material)
                    <option value="{{ $material->id }}" 
                        {{ old('material_id') == $material->id ? 'selected' : '' }}>
                        {{ $material->nombre }} - ${{ number_format($material->precio_por_kg, 2) }}/kg
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" 
                    value="{{ old('cantidad') }}" min="1" required>
            </div>
        </div>
    </div>
    
    <div class="mb-3">
        <label for="documento_diseno" class="form-label">Archivo de diseño</label>
        <input type="file" class="form-control" id="documento_diseno" name="documento_diseno" accept=".dxf,.svg,.dwg,.ai,.pdf" required>
        <div class="form-text">Formatos aceptados: DXF, SVG, DWG, AI, PDF. Tamaño máximo: 10MB</div>
    </div>
    
    <div class="mb-3">
        <div class="form-text">El precio se calculará automáticamente después de subir el archivo, considerando el material, la cantidad y la complejidad del diseño.</div>
    </div>
    
    <button type="submit" class="btn btn-primary">Enviar Pedido</button>
    <a href="{{ route('client.dashboard') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection