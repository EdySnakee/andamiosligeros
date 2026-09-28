@extends('layouts.app_redes')

@section('css')
<style>
    .tracking-card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }
    .tracking-header {
        background: #0948AF;
        color: white;
        padding: 20px;
    }
    .tracking-body {
        padding: 30px;
    }
    .input-tracking {
        height: 50px;
        font-size: 1.2rem;
        border-radius: 8px 0 0 8px !important;
        border: 2px solid #e0e0e0;
    }
    .btn-tracking {
        height: 50px;
        padding: 0 30px;
        border-radius: 0 8px 8px 0 !important;
        background: #fac800;
        color: #1d1919;
        font-weight: bold;
        border: none;
        transition: all 0.3s;
    }
    .btn-tracking:hover {
        background: #e6b800;
        transform: translateY(-1px);
    }
    .iframe-container {
        position: relative;
        width: 100%;
        height: 800px;
        background: #f8f9fa;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        margin-top: 20px;
        display: none;
    }
    .iframe-container iframe {
        width: 100%;
        height: 100%;
        border: none;
        border-radius: 8px;
    }
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #6c757d;
    }
    .empty-state i {
        font-size: 4rem;
        margin-bottom: 20px;
        color: #dee2e6;
    }
</style>
@stop

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-truck-loading mr-2" style="color:#0948AF"></i> Rastreo de Guías
        </h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12">
            <div class="card tracking-card mb-4">
                <div class="tracking-header">
                    <h5 class="mb-0"><i class="fas fa-search mr-2"></i> Consultar Estatus de Envío</h5>
                    <p class="mb-0 small opacity-75">Introduce tu número de rastreo de Paquetexpress para consultar el estado actual.</p>
                </div>
                <div class="tracking-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="input-group mb-3">
                                <input type="text" id="tracking_number" class="form-control input-tracking" placeholder="Ej: 7831237012221" aria-label="Número de rastreo">
                                <div class="input-group-append">
                                    <button class="btn btn-tracking" type="button" id="btn-rastrear">
                                        <i class="fas fa-search-location mr-2"></i> RASTREAR
                                    </button>
                                </div>
                            </div>
                            <div class="text-center">
                                <p class="text-muted small">Sólo válido para guías de <strong>Paquetexpress</strong>.</p>
                            </div>
                        </div>
                    </div>

                    <div id="result-section" class="mt-4">
                        <div id="empty-state" class="empty-state">
                            <i class="fas fa-box-open"></i>
                            <h4>Esperando número de guía</h4>
                            <p>Ingresa un número de rastreo arriba para comenzar la búsqueda.</p>
                        </div>

                        <div id="iframe-loader" class="text-center py-5 d-none">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Cargando...</span>
                            </div>
                            <p class="mt-2 text-muted">Solicitando información a Paquetexpress...</p>
                        </div>

                        <div id="iframe-container" class="iframe-container">
                            <div class="d-flex justify-content-between align-items-center mb-3 px-2">
                                <span class="badge badge-info shadow-sm" style="font-size: 0.9rem; padding: 8px 15px;">
                                    <i class="fas fa-info-circle mr-1"></i> Reporte generado por Paquetexpress
                                </span>
                                <a id="external-link" href="#" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-external-link-alt mr-1"></i> Abrir en pestaña nueva
                                </a>
                            </div>
                            <iframe id="tracking-iframe" src="" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    $(document).ready(function() {
        $('#btn-rastrear').on('click', function() {
            var trackingNo = $('#tracking_number').val().trim();
            
            if (trackingNo === '') {
                swal({
                    icon: 'warning',
                    title: 'Campo vacío',
                    text: 'Por favor, ingresa un número de rastreo.',
                    confirmButtonColor: '#0948AF'
                });
                return;
            }

            // Ocultar estados previos
            $('#empty-state').addClass('d-none');
            $('#iframe-container').hide();
            $('#iframe-loader').removeClass('d-none');

            // Construir URL
            var url = 'https://wb.paquetexpress.com.mx:8082/wsReportPaquetexpress/GenCartaPorte?trackingNoGen=' + trackingNo;

            // Actualizar iframe y link externo
            $('#tracking-iframe').attr('src', url);
            $('#external-link').attr('href', url);

            // Mostrar iframe después de un breve delay
            // Nota: Algunos navegadores bloquean el evento load si es un PDF o similar.
            // Usamos un pequeño timeout preventivo.
            
            $('#tracking-iframe').on('load', function() {
                $('#iframe-loader').addClass('d-none');
                $('#iframe-container').fadeIn();
            });

            // Fallback si no dispara el load event
            setTimeout(function() {
                if ($('#iframe-container').is(':hidden')) {
                    $('#iframe-loader').addClass('d-none');
                    $('#iframe-container').fadeIn();
                }
            }, 3000);
        });

        // Permitir Enter en el input
        $('#tracking_number').on('keypress', function(e) {
            if (e.which == 13) {
                $('#btn-rastrear').click();
            }
        });

        // Autocompletar con el número del ejemplo si el usuario lo desea clicando el placeholder
        $('#tracking_number').on('click', function() {
            if($(this).val() == '') {
                // Opcional: no hacer nada o sugerir el del ejemplo
            }
        });
    });
</script>
@stop
