@extends('layouts.app')

@section('title', 'Crear Nueva Orden')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Crear Nueva Orden</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('client.ordens.store') }}" method="POST" enctype="multipart/form-data" id="ordenForm">
                        @csrf

                        <div class="row">   
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="material_id" class="form-label">Material</label>
                                    <select class="form-select" id="material_id" name="material_id" required 
                                            onchange="calcularPrecio()" oninput="calcularPrecio()">
                                        <option value="">Seleccionar material...</option>
                                        @foreach($materiales as $material)
                                            <option value="{{ $material->id }}" data-precio="{{ $material->precio_por_kg }}">
                                                {{ $material->nombre }} - Bs{{ number_format($material->precio_por_kg, 2) }} / m
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="cantidad" class="form-label">Cantidad *</label>
                                    <input type="number" class="form-control" id="cantidad" name="cantidad" 
                                            min="1" step="1" required placeholder="Ej: 10"
                                            oninput="calcularPrecio()">
                                </div>

                                <div class="mb-3">
                                    <label for="documento_diseno" class="form-label">Archivo de Diseño *</label>
                                    <input type="file" class="form-control" id="documento_diseno" 
                                            name="documento_diseno" accept=".pdf,.jpg,.jpeg,.png,.gif,.svg,.dxf,.dwg,.ai" 
                                            required onchange="previewFile(this)">
                                    <div class="form-text">Formatos aceptados: PDF, JPG, PNG, GIF, SVG, DXF, DWG, AI</div>
                                </div>
                                <div class="mb-3">
                                    <label for="ancho" class="form-label">Ancho del diseño (mm) *</label>
                                    <input type="number" class="form-control" id="ancho" name="ancho" min="1" required oninput="calcularPrecio()">
                                </div>
                                <div class="mb-3">
                                    <label for="alto" class="form-label">Alto del diseño (mm) *</label>
                                    <input type="number" class="form-control" id="alto" name="alto" min="1" required oninput="calcularPrecio()">
                                </div>
                                <div class="mb-3">
                                    
                                    <input type="hidden" id="consumibles" name="consumibles" value="0">
                                    
                                </div>
                                <div class="card mt-4">
                                    <div class="card-header bg-success text-white">
                                        <h6 class="card-title mb-0">
                                            <i class="fas fa-calculator"></i> Cotización Estimada
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <p class="mb-1"><strong>Precio por m:</strong></p>
                                                <p class="mb-1"><strong>Cantidad:</strong></p>
                                                <hr>
                                                <p class="mb-0"><strong>TOTAL ESTIMADO:</strong></p>
                                            </div>
                                            <div class="col-6 text-end">
                                                <p class="mb-1" id="precioBase">Bs0.00</p>
                                                <p class="mb-1" id="precioCantidad">0 unidades</p>
                                                <hr>
                                                <p class="mb-0 fs-5 fw-bold text-success" id="precioTotal">Bs0.00</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-info text-white">
                                        <h6 class="card-title mb-0">Vista Previa</h6>
                                    </div>
                                    <div class="card-body text-center">
                                        <div id="vistaPreviaContainer" style="display: none;">
                                            
                                            <img id="vistaPreviaImagen" src="" 
                                                class="img-fluid rounded mb-2" 
                                                style="max-height: 200px; display: none;"
                                                alt="Vista previa">
                                            
                                            
                                            <iframe id="vistaPreviaPDF" src="" 
                                                    width="100%" height="200" 
                                                    style="display: none; border: 1px solid #ddd;"
                                                    frameborder="0"></iframe>

                                            <div id="vistaPreviaOtros" style="display: none;">
                                                <i class="fas fa-file fa-3x text-secondary mb-2"></i>
                                                <p class="mb-1" id="nombreArchivo"></p>
                                                <small class="text-muted" id="tipoArchivo"></small>
                                            </div>
                                        </div>

                                        <div id="sinVistaPrevia" class="text-muted">
                                            <i class="fas fa-upload fa-3x mb-2"></i>
                                            <p>Selecciona un archivo para ver la vista previa</p>
                                        </div>
                                    </div>
                                </div>

                                
                                <div id="infoArchivo" class="mt-3" style="display: none;">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6>Información del archivo:</h6>
                                            <p class="mb-1"><strong>Nombre:</strong> <span id="infoNombre"></span></p>
                                            <p class="mb-1"><strong>Tipo:</strong> <span id="infoTipo"></span></p>
                                            <p class="mb-0"><strong>Tamaño:</strong> <span id="infoTamaño"></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="precio_total" id="precio_total">

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Enviar Orden - <span id="precioBoton">Bs0.00</span>
                            </button>
                            <a href="{{ route('client.dashboard') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
#vistaPreviaContainer {
    min-height: 250px;
    display: flex;
    align-items: center;
    justify-content: center;
}

#sinVistaPrevia {
    min-height: 250px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #6c757d;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

#precioTotal {
    font-size: 1.2rem;
}
</style>

<script>
// Función SIMPLIFICADA para calcular precio

function calcularPrecio() {
    // Constantes
    const COSTO_POR_MINUTO = 4.30; // Cambia este valor si tu costo por minuto es diferente
    const TIEMPO_POSICIONAMIENTO_POR_COPIA = 4; // minutos
    const COSTO_CONSUMIBLES_POR_M2 = 5.00; 

    // Material
    const materialSelect = document.getElementById('material_id');
    let costoMaterial = 0;
    if (materialSelect.value) {
        const selectedOption = materialSelect.options[materialSelect.selectedIndex];
        costoMaterial = parseFloat(selectedOption.getAttribute('data-precio')) || 0;
    }

    // Cantidad
    const cantidad = parseInt(document.getElementById('cantidad').value) || 0;

    // Dimensiones
    const ancho = parseFloat(document.getElementById('ancho').value) || 0;
    const alto = parseFloat(document.getElementById('alto').value) || 0;

    // Área total (m²)
    const areaTotal = ((ancho * alto) / 1e6) * cantidad; // mm² a m²

    // Consumibles 
    const consumibles = areaTotal * COSTO_CONSUMIBLES_POR_M2;

    // Longitud total (mm) = perímetro estimado de la pieza × cantidad
    const longitudTotal = 2 * (ancho + alto) * cantidad;

    // Tiempo de corte (minutos)
    const tiempoCorte = (longitudTotal / 30) + (TIEMPO_POSICIONAMIENTO_POR_COPIA * cantidad);

    // Costo total
    const costo = (tiempoCorte * COSTO_POR_MINUTO) + (areaTotal * costoMaterial) + consumibles;

    // Actualizar la interfaz
    document.getElementById('precioBase').textContent = `Bs${costoMaterial.toFixed(2)}`;
    document.getElementById('precioCantidad').textContent = `${cantidad} unidades`;
    document.getElementById('precioTotal').textContent = `Bs${costo.toFixed(2)}`;
    document.getElementById('precioBoton').textContent = `Bs${costo.toFixed(2)}`;
    document.getElementById('precio_total').value = costo.toFixed(2);

    // Actualiza el campo oculto de consumibles
    document.getElementById('consumibles').value = consumibles.toFixed(2);
}

// Función de vista previa (sin cambios)
function previewFile(input) {
    const file = input.files[0];
    const vistaPreviaContainer = document.getElementById('vistaPreviaContainer');
    const sinVistaPrevia = document.getElementById('sinVistaPrevia');
    const infoArchivo = document.getElementById('infoArchivo');
    
    // Elementos de vista previa
    const vistaPreviaImagen = document.getElementById('vistaPreviaImagen');
    const vistaPreviaPDF = document.getElementById('vistaPreviaPDF');
    const vistaPreviaOtros = document.getElementById('vistaPreviaOtros');
    
    // Elementos de información
    const infoNombre = document.getElementById('infoNombre');
    const infoTipo = document.getElementById('infoTipo');
    const infoTamaño = document.getElementById('infoTamaño');
    const nombreArchivo = document.getElementById('nombreArchivo');
    const tipoArchivo = document.getElementById('tipoArchivo');

    if (file) {
        sinVistaPrevia.style.display = 'none';
        vistaPreviaContainer.style.display = 'block';
        infoArchivo.style.display = 'block';

        infoNombre.textContent = file.name;
        nombreArchivo.textContent = file.name;
        
        const extension = file.name.split('.').pop().toLowerCase();
        infoTipo.textContent = extension.toUpperCase();
        tipoArchivo.textContent = `Tipo: .${extension}`;
        
        const tamaño = file.size;
        infoTamaño.textContent = formatoTamaño(tamaño);

        vistaPreviaImagen.style.display = 'none';
        vistaPreviaPDF.style.display = 'none';
        vistaPreviaOtros.style.display = 'none';

        const reader = new FileReader();

        reader.onload = function(event) {
            if (file.type.includes('image/')) {
                vistaPreviaImagen.src = event.target.result;
                vistaPreviaImagen.style.display = 'block';
                vistaPreviaImagen.alt = `Vista previa de ${file.name}`;
                
            } else if (file.type === 'application/pdf') {
                vistaPreviaPDF.src = URL.createObjectURL(file);
                vistaPreviaPDF.style.display = 'block';
                
            } else {
                vistaPreviaOtros.style.display = 'block';
                const icon = vistaPreviaOtros.querySelector('i');
                icon.className = getIconForExtension(extension);
            }
        };

        if (file.type.includes('image/')) {
            reader.readAsDataURL(file);
        } else {
            if (file.type === 'application/pdf') {
                vistaPreviaPDF.src = URL.createObjectURL(file);
                vistaPreviaPDF.style.display = 'block';
            } else {
                vistaPreviaOtros.style.display = 'block';
                const icon = vistaPreviaOtros.querySelector('i');
                icon.className = getIconForExtension(extension);
            }
        }

    } else {
        vistaPreviaContainer.style.display = 'none';
        infoArchivo.style.display = 'none';
        sinVistaPrevia.style.display = 'flex';
    }
}

function formatoTamaño(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

function getIconForExtension(extension) {
    const iconMap = {
        'pdf': 'fas fa-file-pdf text-danger',
        'doc': 'fas fa-file-word text-primary',
        'docx': 'fas fa-file-word text-primary',
        'xls': 'fas fa-file-excel text-success',
        'xlsx': 'fas fa-file-excel text-success',
        'zip': 'fas fa-file-archive text-warning',
        'rar': 'fas fa-file-archive text-warning',
        'svg': 'fas fa-file-image text-info',
        'dxf': 'fas fa-file-code text-warning',
        'dwg': 'fas fa-file-code text-warning',
        'ai': 'fas fa-file-code text-warning'
    };
    
    return iconMap[extension] || 'fas fa-file text-secondary';
}

// Inicializar al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    calcularPrecio();
    const fileInput = document.getElementById('documento_diseno');
    if (fileInput.files.length > 0) {
        previewFile(fileInput);
    }
});
['material_id', 'cantidad', 'ancho', 'alto'].forEach(function(id) {
    document.getElementById(id).addEventListener('input', calcularPrecio);
    document.getElementById(id).addEventListener('change', calcularPrecio);
});

// Forzar el cálculo antes de enviar el formulario
document.getElementById('ordenForm').addEventListener('submit', function(e) {
    calcularPrecio(); // Asegura que el precio esté actualizado
});

</script>

@endsection