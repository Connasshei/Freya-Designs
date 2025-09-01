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
<header class="bg-primary text-black mb-4 shadow-sm">
    <nav class="navbar navbar-expand-md navbar-light bg-transparent">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="#">
                <i class="fas fa-industry me-2"></i>
                FREYA DESIGNS
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto mb-2 mb-md-0 align-items-md-center">
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#empresa">Sobre Nosotros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#pedidos">Mis Pedidos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#contacto">Contacto</a>
                    </li>
                    <li class="nav-item ms-md-3">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm mt-2 mt-md-0">
                                <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
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
                
                <li>Cotización automática</li>
            </ul>
        </div>
        <div class="col-md-5 text-center">
            <img src="{{ asset('img/freya desing logo 2.png') }}" alt="Empresa" class="img-fluid" style="max-height: 220px;">
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