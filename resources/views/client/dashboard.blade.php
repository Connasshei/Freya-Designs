@extends('layouts.app')

@section('title', 'Panel de Cliente')

@section('content')
<!-- Header con navegación -->
<style>
    body{
        background: #ffeff;
    }
    .bg-primary{
        background: linear-gradient(to right, #f92, #f99);
    }
    .text-black{
        color: #777;
    }
    .bg-contact{
        background: linear-gradient(to left, #f62, #f66);
    }
    .nav-link-custom {
        color: #333;
        text-decoration: none !important;
        margin-right: 1.5rem;
        font-weight: 500;
    }
    .nav-link-custom:last-child {
        margin-right: 0;
    }
    .nav-link-custom:hover {
        color: black;
    }
</style>
<header class="bg-primary text-black py-4 mb-4 shadow-sm">
    <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
        <h1 class="mb-2 mb-md-0" style="font-weight: 700; letter-spacing: 1px;">
            <i class="fas fa-industry me-2"></i> FREYA DESIGNS
        </h1>
        <nav class="d-flex align-items-center">
            <a href="#empresa" class="nav-link-custom">Sobre Nosotros</a>
            <a href="#pedidos" class="nav-link-custom">Mis Pedidos</a>
            <a href="#contacto" class="nav-link-custom">Contacto</a>
            <form action="{{ route('logout') }}" method="POST" class="d-inline ms-3">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">
                    Cerrar sesión
                </button>
            </form>
        </nav>
    </div>
</header>

<!-- Sección principal: Sobre la empresa -->
<section id="empresa" class="container mb-5">
    <div class="row align-items-center">
        <div class="col-md-7">
            <h2 class="mb-3" style="font-weight: 600;">Diseño y Corte Láser Profesional</h2>
            <p class="lead">
                "Si puedes imaginarlo, podemos crearlo. En FREYA DESIGN damos vida a tus ideas con precisión, estilo y pasión por el diseño personalizado."            </p>
            <ul>
                <li>Impresión y corte de materiales avanzados</li>
                
                <li>Entrega rápida y personalizada</li>
            </ul>
        </div>
        <div class="col-md-5 text-center">
            <img src="{{ asset('img/empresa-ilustracion.svg') }}" alt="Empresa" class="img-fluid" style="max-height: 220px;">
        </div>
    </div>
</section>

<!-- Sección de pedidos del cliente -->
<section id="pedidos" class="container mb-5">

    {{-- Aquí va tu tabla de pedidos, NO se modifica --}}
    @include('client.partials.tabla-pedidos')
</section>

<!-- Sección de contacto -->
<section id="contacto" class="bg-primary py-5">
    <div class="container">
        <h2 class="mb-4" style="font-weight: 600;">Contacto</h2>
        <div class="row justify-content-center align-items-center">
            <div class="col-md-4 mb-3 ">
                <div class="d-flex align-items-center bg-contact rounded shadow-sm p-3 h-100">
    
                    <div>
                        <h5 class="mb-1">Email</h5>
                        <p class="mb-0">freyaDESIGNS@gmail.com</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3 ">
                <div class="d-flex align-items-center bg-contact rounded shadow-sm p-3 h-100">
                    
                    <div>
                        <h5 class="mb-1">Teléfono</h5>
                        <p class="mb-0">+591 700 00000</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3 ">
                <div class="d-flex align-items-center bg-contact rounded shadow-sm p-3 h-100">
                    
                    <div>
                        <h5 class="mb-1">Dirección</h5>
                        <p class="mb-0">Calle Lindaura Campero N°8</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection