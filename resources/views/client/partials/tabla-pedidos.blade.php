
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 borden-bottom">
    <h1 class="h2">Mis Pedidos</h1>
    <a href="{{ route('client.ordens.create') }}" class="btn btn-primary">Nuevo Pedido</a>
</div>

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
        @foreach($ordens as $orden)
            <tr>
                <td>{{ $orden->id }}</td>
                <td>{{ $orden->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <span class="badge bg-{{ $orden->estado == 'borrador' ? 'secondary' : ($orden->estado == 'pendiente' ? 'warning' : ($orden->estado == 'aprobado' ? 'success' : 'danger')) }}">
                        {{ ucfirst($orden->estado) }}
                    </span>
                </td>
                <td>Bs{{ number_format($orden->precio_total, 2) }}</td>
                <td>
                    <a href="{{ route('client.orders.preview', $orden->id) }}" 
                        class="btn btn-info btn-sm">
                        Ver Detalles
                    </a>
                    
                    @if($orden->estado == 'borrador')
                    <form action="{{ route('orders.confirm', $orden->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success">
                            <i class="fas fa-check"></i> Confirmar
                        </button>
                    </form>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>