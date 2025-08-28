@extends('layouts.client')

@section('title', 'Mis Pedidos')

@section('client-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 borden-bottom">
    <h1 class="h2">Mis Pedidos</h1>
    <a href="{{ route('client.ordens.create') }}" class="btn btn-primary">Nuevo Pedido</a>
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Precio Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ordens as $orden)
            <tr>
                <td>{{ $orden->id }}</td>
                <td>{{ $orden->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <span class="badge 
                        @if($orden->estado == 'pendiente') bg-warning
                        @elseif($orden->estado == 'aprobado') bg-success
                        @elseif($orden->estado == 'denegado') bg-danger
                        @elseif($orden->estado == 'completado') bg-info
                        @endif">
                        {{ ucfirst($orden->estado) }}
                    </span>
                </td>
                <td>Bs{{ number_format($orden->precio_total, 2) }}</td>
                <td>
                    <a href="#" class="btn btn-sm btn-info">Ver Detalles</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No tienes pedidos aún.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection