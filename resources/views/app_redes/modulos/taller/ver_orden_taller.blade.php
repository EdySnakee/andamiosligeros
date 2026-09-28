@extends('layouts.app_redes')

@section('css')
<style>
    /* =============================================
       ORDEN DE TALLER — Hoja de Producción
       Color principal: #0948AF solo como acento
    ============================================= */

    .orden-wrapper {
        max-width: 860px;
        margin: 0 auto;
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 28px 32px;
        font-family: 'Segoe UI', Arial, sans-serif;
        font-size: 0.9rem;
        color: #212529;
    }

    /* ---- ENCABEZADO ---- */
    .orden-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding-bottom: 16px;
        margin-bottom: 20px;
        border-bottom: 2px solid #0948AF;
    }

    .orden-header .titulo h1 {
        font-size: 1.4rem;
        font-weight: 700;
        color: #0948AF;
        margin: 0 0 2px 0;
    }

    .orden-header .titulo small {
        color: #6c757d;
        font-size: 0.78rem;
    }

    .orden-header .cod-venta {
        text-align: right;
    }

    .orden-header .cod-venta .num {
        font-size: 1.4rem;
        font-weight: 700;
        color: #212529;
        letter-spacing: 1px;
        display: block;
    }

    .orden-header .cod-venta small {
        color: #6c757d;
        font-size: 0.78rem;
    }

    /* ---- SECCIÓN INFO (cliente, venta) ---- */
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 22px;
    }

    .info-box {
        background: #f8f9fa;
        border-radius: 6px;
        padding: 12px 16px;
        border-top: 3px solid #0948AF;
    }

    .info-box .box-title {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #0948AF;
        margin-bottom: 8px;
    }

    .info-line {
        display: flex;
        gap: 6px;
        margin-bottom: 3px;
        font-size: 0.84rem;
    }

    .info-line .lbl {
        color: #6c757d;
        min-width: 110px;
        font-weight: 500;
    }

    .info-line .val {
        font-weight: 600;
        color: #212529;
    }

    /* ---- SECCIÓN PRODUCTOS (tabla de producción) ---- */
    .seccion-titulo {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #1e5dc2d9;
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 6px;
        margin-bottom: 10px;
    }

    .tabla-produccion {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.875rem;
        margin-bottom: 20px;
    }

    .tabla-produccion thead th {
        background: #1977d4;
        color: #fff;
        padding: 9px 12px;
        font-size: 0.76rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .tabla-produccion thead th.center {
        text-align: center;
    }

    .tabla-produccion tbody tr {
        border-bottom: 1px solid #dee2e6;
    }

    .tabla-produccion tbody tr:nth-child(even) {
        background: #f8f9fa;
    }

    .tabla-produccion tbody td {
        padding: 10px 12px;
        vertical-align: middle;
    }

    .tabla-produccion tbody td.center {
        text-align: center;
    }

    .prod-nombre {
        font-weight: 600;
        color: #212529;
    }

    .prod-desc {
        color: #6c757d;
        font-size: 0.8rem;
        margin-top: 2px;
    }

    .badge-dim {
        background: #e8f0fb;
        color: #1061e462;
        font-size: 0.78rem;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 4px;
        display: inline-block;
    }

    .cant-grande {
        font-size: 1.4rem;
        font-weight: 700;
        color: #0948AF;
        line-height: 1;
    }

    .cant-unidad {
        font-size: 0.7rem;
        color: #6c757d;
        display: block;
    }

    /* ---- OBSERVACIONES ---- */
    .obs-box {
        border: 1px dashed #adb5bd;
        border-radius: 6px;
        padding: 14px 16px;
        min-height: 70px;
        margin-top: 4px;
    }

    .obs-box p {
        margin: 0;
        color: #495057;
        font-size: 0.87rem;
    }

    /* ---- PIE ---- */
    .orden-pie {
        margin-top: 24px;
        padding-top: 12px;
        border-top: 1px solid #dee2e6;
        display: flex;
        justify-content: space-between;
        font-size: 0.75rem;
        color: #adb5bd;
    }

    /* ---- SISTEMA DE NOTAS (CHAT) ---- */
    .notes-container {
        margin-top: 10px;
    }

    .note-item {
        background: #fdfdfd;
        border: 1px solid #edf2f7;
        border-radius: 8px;
        padding: 10px 14px;
        margin-bottom: 8px;
        position: relative;
    }

    .note-header {
        display: flex;
        justify-content: space-between;
        font-size: 0.72rem;
        margin-bottom: 4px;
    }

    .note-user {
        font-weight: 700;
        color: #0948AF;
    }

    .note-date {
        color: #a0aec0;
    }

    .note-text {
        font-size: 0.85rem;
        color: #2d3748;
        white-space: pre-wrap;
    }

    .empty-notes {
        text-align: center;
        padding: 20px;
        color: #a0aec0;
        font-style: italic;
        font-size: 0.85rem;
    }

    .all-notes-link {
        display: block;
        text-align: center;
        font-size: 0.78rem;
        color: #0948AF;
        text-decoration: underline;
        margin-top: 5px;
        cursor: pointer;
    }

    .add-note-box {
        margin-top: 15px;
        background: #f8fafc;
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }

    /* ---- IMPRESIÓN ---- */
    @media print {
        body * {
            visibility: hidden;
        }

        #zona-impresion,
        #zona-impresion * {
            visibility: visible;
        }

        #zona-impresion {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }

        .no-print {
            display: none !important;
        }

        .orden-wrapper {
            border: none;
            padding: 0;
        }
    }
</style>
@stop

@section('content')
<div class="container-fluid">

    {{-- Barra de acciones --}}
    <div class="d-flex justify-content-between align-items-center mb-3 no-print">
        <h1 class="h4 mb-0 text-gray-800">
            <i class="fas fa-clipboard-list mr-2" style="color:#0948AF"></i>
            Orden de Taller
        </h1>
        <div style="display:flex;gap:8px;">
            <button id="btnImprimirOrden" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-print mr-1"></i> Imprimir
            </button>
        </div>
    </div>

    <div id="zona-impresion">
        <div class="orden-wrapper">

            {{-- ===== ENCABEZADO ===== --}}
            <div class="orden-header">
                <div class="titulo">
                    <h1>
                        <i class="fas fa-cube" style="font-size:1.1rem;"></i> ORDEN DE PRODUCCIÓN
                        @if($ordenTaller->impreso == 1)
                            <i class="fas fa-print ml-2" style="font-size: 1rem; color: #28a745;" title="Esta orden ya fue impresa"></i>
                        @endif
                    </h1>
                    <small>Andamios Ligeros &nbsp;·&nbsp; Taller de fabricación</small><br>
                    <small>{{ $fecha_impresion }}</small>
                </div>
                <div class="cod-venta">
                    <span class="num">{{ $cotizacion->cod_venta ?? 'SIN CÓDIGO' }}</span>
                    <small>Cotización: {{ $cotizacion->cod_cotizacion }}</small><br>
                    <small>Fecha de venta: {{ $cotizacion->fecha_venta_formato ?? $cotizacion->fecha_venta }}</small>
                </div>
            </div>

            {{-- ===== INFO CLIENTE / VENTA ===== --}}
            <div class="info-grid">
                <div class="info-box">
                    <div class="box-title"><i class="fas fa-user mr-1"></i> Cliente</div>
                    <div class="info-line">
                        <span class="lbl">Nombre</span>
                        <span class="val">{{ $cliente->nombrecl ?? '—' }}</span>
                    </div>
                    <div class="info-line">
                        <span class="lbl">Teléfono</span>
                        <span class="val">{{ $cliente->telefonocl ?? $cliente->celularcl ?? '—' }}</span>
                    </div>
                    @if(!empty($cliente->emailcl))
                    <div class="info-line">
                        <span class="lbl">Email</span>
                        <span class="val">{{ $cliente->emailcl }}</span>
                    </div>
                    @endif
                    @if(!empty($cliente->direccioncl))
                    <div class="info-line">
                        <span class="lbl">Dirección</span>
                        <span class="val">{{ $cliente->direccioncl }}</span>
                    </div>
                    @endif

                    @if(!empty($venta))
                        @if(!empty($venta->origen))
                        <div class="info-line">
                            <span class="lbl">Origen</span>
                            <span class="val">{{ $venta->origen }}</span>
                        </div>
                        @endif
                        @if(!empty($venta->destino))
                        <div class="info-line">
                            <span class="lbl">Destino</span>
                            <span class="val">{{ $venta->destino }}</span>
                        </div>
                        @endif
                    @endif
                </div>
                <div class="info-box">
                    <div class="box-title"><i class="fas fa-info-circle mr-1"></i> Datos de la orden</div>
                    <div class="info-line">
                        <span class="lbl">Código venta</span>
                        <span class="val">{{ $cotizacion->cod_venta ?? '—' }}</span>
                    </div>
                    <div class="info-line">
                        <span class="lbl">Forma de pago</span>
                        <span class="val">{{ $cotizacion->forma_pago ?? '—' }}</span>
                    </div>
                    <div class="info-line">
                        <span class="lbl">Vendedor</span>
                        <span class="val">{{ $vendedor->name ?? '—' }}</span>
                    </div>
                    <div class="info-line">
                        <span class="lbl">Total piezas</span>
                        <span class="val">{{ $detalle->sum('cantidad') }} unidades</span>
                    </div>
                </div>
            </div>

            @php
                $totalPiezas = 0;
                $totalTerminadas = 0;
                foreach($detalle as $item) {
                    $totalPiezas += $item->cantidad;
                    $totalTerminadas += $item->cantidad_terminada ?? 0;
                }
                $porcentaje = $totalPiezas > 0 ? round(($totalTerminadas / $totalPiezas) * 100) : 0;
            @endphp
            
            <div class="mb-4">
                <div class="d-flex justify-content-between mb-1">
                    <span class="font-weight-bold" style="color: #0948AF;">Progreso de Producción: {{ $porcentaje }}%</span>
                    <span class="text-muted" style="font-size: 0.85rem;">{{ $totalTerminadas }} de {{ $totalPiezas }} piezas</span>
                </div>
                <div class="progress" style="height: 12px; border-radius: 6px;">
                    <div class="progress-bar {{ $porcentaje == 100 ? 'bg-success' : 'bg-warning' }}" role="progressbar" style="width: {{ $porcentaje }}%;" aria-valuenow="{{ $porcentaje }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>

            <form id="formProgresoTaller">
                <input type="hidden" name="id_orden_taller" value="{{ $ordenTaller->id_orden_taller }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

            {{-- ===== LISTA DE PRODUCCIÓN ===== --}}
            <div class="seccion-titulo">
                <i class="fas fa-tools mr-1"></i> Especificación de productos a fabricar
            </div>

            <table class="tabla-produccion">
                <thead>
                    <tr>
                        <th class="center" style="width:5%">#</th>
                        <th style="width:45%">Producto / Descripción</th>
                        <th class="center" style="width:12%">Cantidad</th>
                        <th class="center" style="width:20%">Dimensiones</th>
                        <th class="center" style="width:18%">Tipo de pieza</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($detalle as $index => $item)
                    <tr>
                        <td class="center text-muted">{{ $index + 1 }}</td>
                        <td>
                            <div class="prod-nombre">{{ $item->nombre_producto }}</div>
                            @if(!empty($item->titulo_descripcion))
                            <div class="prod-desc">{{ $item->titulo_descripcion }}</div>
                            @endif
                            @if(!empty($item->clave_prod_serv))
                            <div class="prod-desc">Clave: {{ $item->clave_prod_serv }}</div>
                            @endif
                        </td>
                        <td class="center">
                            <span class="cant-grande">{{ $item->cantidad }}</span>
                            <span class="cant-unidad">
                                {{ $item->tipo_cobro == 'm2' ? 'm²' : ($item->unidad ?? 'pza') }}
                            </span>
                            <div class="mt-2">
                                <label style="font-size: 0.70rem; color: #6c757d; margin-bottom: 2px;">Completado:</label>
                                <input type="number" class="form-control form-control-sm text-center" 
                                       name="cantidades[{{ $item->id_det_cotizacion }}]" 
                                       value="{{ $item->cantidad_terminada ?? 0 }}" 
                                       min="0" max="{{ $item->cantidad }}" 
                                       {{ $ordenTaller->estatus == 3 ? 'readonly' : '' }}
                                       style="width: 70px; margin: 0 auto; font-weight: bold; padding: 2px;">
                            </div>
                        </td>
                        <td class="center">
                            @if($item->tipo_cobro == 'm2' && $item->largo && $item->alto)
                            <span class="badge-dim">{{ $item->largo }}m × {{ $item->alto }}m</span>
                            <br><small class="text-muted">{{ $item->dimensiones }} m² c/u</small>
                            @else
                            <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="center">
                            <span class="badge badge-secondary">{{ strtoupper($item->tipo_cobro) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">Sin productos registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- ===== OBSERVACIONES ===== --}}
            {{-- ===== OBSERVACIONES / NOTAS ===== --}}
             <div class="seccion-titulo mt-4">
                <i class="fas fa-comments mr-1"></i> Notas e instrucciones de Taller
            </div>
            
            <div class="notes-container" id="contenedor-notas">
                @forelse($notas->take(3) as $nota)
                    <div class="note-item">
                        <div class="note-header">
                            <span class="note-user">{{ $nota->user->name }}</span>
                            <span class="note-date">{{ $nota->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="note-text">{{ $nota->nota }}</div>
                    </div>
                @empty
                    @if(empty($ordenTaller->comentarios))
                        <div class="empty-notes">No hay notas registradas.</div>
                    @endif
                @endforelse

                {{-- Mostrar comentario legacy si existe --}}
                @if(!empty($ordenTaller->comentarios))
                    <div class="note-item" style="border-left: 3px solid #cbd5e0;">
                        <div class="note-header">
                            <span class="note-user text-muted">Nota Anterior (Legacy)</span>
                        </div>
                        <div class="note-text">{{ $ordenTaller->comentarios }}</div>
                    </div>
                @endif
            </div>

            @if($notas->count() > 3)
                <span class="all-notes-link no-print" data-toggle="modal" data-target="#modalTodasNotas">
                    <i class="fas fa-history mr-1"></i> Ver todas las notas ({{ $notas->count() }})
                </span>
            @endif

            @if($ordenTaller->estatus != 3)
            <div class="add-note-box no-print">
                <div class="input-group">
                    <textarea id="nueva_nota_taller" class="form-control" rows="1" placeholder="Escribe una nota interna..." style="resize: none;"></textarea>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button" id="btnAgregarNota">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endif

            {{-- ===== TRACKING / GUIA ===== --}}
            <div class="seccion-titulo mt-4">
                <i class="fas fa-truck mr-1"></i> Guía de Seguimiento
            </div>
            <div class="row mt-2">
                <div class="col-md-5">
                    <label class="small font-weight-bold text-muted">Número de Guía:</label>
                    <input type="text" name="numero_guia" class="form-control form-control-sm" value="{{ $ordenTaller->numero_guia }}" placeholder="Ej: 1ZX99..." {{ $ordenTaller->estatus == 3 ? 'readonly' : '' }}>
                </div>
                <div class="col-md-7">
                    <label class="small font-weight-bold text-muted">Enlace de Rastreo:</label>
                    <input type="text" name="enlace_guia" class="form-control form-control-sm" value="{{ $ordenTaller->enlace_guia }}" placeholder="https://www.paquetexpress.com.mx/rastreo-de-envio?rastreo=XXXXXXXXXX" {{ $ordenTaller->estatus == 3 ? 'readonly' : '' }}>
                </div>
            </div>

            @if($ordenTaller->estatus != 3)
            <div class="mt-4 text-right d-flex justify-content-end" style="gap: 10px;">
                <button type="button" class="btn btn-success" id="btnConfirmarEnvio">
                    <i class="fas fa-shipping-fast mr-1"></i> Confirmar envío
                </button>
                <button type="button" class="btn btn-primary" id="btnGuardarProgreso">
                    <i class="fas fa-save mr-1"></i> Guardar Progreso
                </button>
            </div>
            @else
            <div class="mt-4 text-right">
                <div class="alert alert-info d-inline-block py-2 px-3 mb-0" style="font-size: 0.85rem;">
                    <i class="fas fa-check-circle mr-1"></i> Esta orden ya fue enviada y no puede ser modificada.
                </div>
            </div>
            @endif
            
            </form>

            {{-- ===== PIE ===== --}}
            <div class="orden-pie">
                <span>Andamios Ligeros &nbsp;·&nbsp; Sistema interno</span>
                <span>Generado: {{ $fecha_impresion }}</span>
            </div>

        </div>{{-- /orden-wrapper --}}
    </div>{{-- /zona-impresion --}}

    {{-- MODAL PARA VER TODAS LAS NOTAS --}}
    <div class="modal fade no-print" id="modalTodasNotas" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title font-weight-bold" style="color:#0948AF; font-size: 1rem;">
                        <i class="fas fa-history mr-2"></i> Historial de Notas
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-3" style="max-height: 450px; overflow-y: auto; background: #fdfdfd;">
                    <div id="lista-todas-notas">
                        @foreach($notas as $nota)
                        <div class="note-item">
                            <div class="note-header">
                                <span class="note-user">{{ $nota->user->name }}</span>
                                <span class="note-date">{{ $nota->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="note-text">{{ $nota->nota }}</div>
                        </div>
                        @endforeach
                        
                        @if(!empty($ordenTaller->comentarios))
                            <div class="note-item" style="border-left: 3px solid #cbd5e0;">
                                <div class="note-header">
                                    <span class="note-user text-muted">Nota Anterior (Legacy)</span>
                                </div>
                                <div class="note-text">{{ $ordenTaller->comentarios }}</div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

</div>
@stop

@section('js')
<script>
    $(document).ready(function() {
        $('#btnGuardarProgreso').click(function() {
            var btn = $(this);
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Guardando...');
            
            $.ajax({
                url: '{{ route("app_actualizar_progreso_taller") }}',
                type: 'POST',
                data: $('#formProgresoTaller').serialize(),
                success: function(response) {
                    if(response.success) {
                        swal({
                            title: "¡Éxito!",
                            text: "Progreso guardado correctamente.",
                            type: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });
                        setTimeout(function(){
                            location.reload();
                        }, 1500);
                    } else {
                        swal('Error', 'Ocurrió un error: ' + response.message, 'error');
                        btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Guardar Progreso');
                    }
                },
                error: function() {
                    swal('Error', 'Error en el servidor. Intente de nuevo.', 'error');
                    btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Guardar Progreso');
                }
            });
        });

        $('#btnConfirmarEnvio').click(function() {
            swal({
                title: "¿Estás seguro?",
                text: "Una vez confirmada como enviada, la orden ya no podrá ser modificada.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#28a745",
                confirmButtonText: "Sí, confirmar envío",
                cancelButtonText: "Cancelar"
            }).then((isConfirm) => {
                if (isConfirm) {
                    var btn = $('#btnConfirmarEnvio');
                    btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Procesando...');

                    $.ajax({
                        url: '{{ route("app_confirmar_envio_taller") }}',
                        type: 'POST',
                        data: {
                            id_orden_taller: '{{ $ordenTaller->id_orden_taller }}',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if(response.success) {
                                swal("¡Enviado!", "La orden ha sido marcada como enviada.", "success");
                                setTimeout(function(){
                                    location.reload();
                                }, 1500);
                            } else {
                                swal('Error', response.message, 'error');
                                btn.prop('disabled', false).html('<i class="fas fa-shipping-fast mr-1"></i> Confirmar envío');
                            }
                        },
                        error: function() {
                            swal('Error', 'No se pudo procesar la solicitud.', 'error');
                            btn.prop('disabled', false).html('<i class="fas fa-shipping-fast mr-1"></i> Confirmar envío');
                        }
                    });
                }
            });
        });

        $('#btnImprimirOrden').click(function() {
            // Marcar como impreso en el servidor
            $.ajax({
                url: '{{ route("app_marcar_impreso_taller") }}',
                type: 'POST',
                data: {
                    id_orden_taller: '{{ $ordenTaller->id_orden_taller }}',
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Independientemente del éxito, imprimimos
                    window.print();
                },
                error: function() {
                    window.print();
                }
            });
        });

        // AGREGAR NOTA (CHAT)
        $('#btnAgregarNota').click(function() {
            var nota = $('#nueva_nota_taller').val().trim();
            if (nota === '') return;

            var btn = $(this);
            btn.prop('disabled', true);

            $.ajax({
                url: '{{ route("app_agregar_nota_taller") }}',
                type: 'POST',
                data: {
                    id_orden_taller: '{{ $ordenTaller->id_orden_taller }}',
                    nota: nota,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        $('#nueva_nota_taller').val('');
                        // Eliminar mensaje de "no hay notas" si existe
                        $('.empty-notes').remove();

                        var html = `
                            <div class="note-item" style="border-left: 3px solid #28a745; animation: fadeIn 0.5s;">
                                <div class="note-header">
                                    <span class="note-user">${response.nota.usuario}</span>
                                    <span class="note-date">${response.nota.fecha}</span>
                                </div>
                                <div class="note-text">${response.nota.texto}</div>
                            </div>
                        `;
                        
                        // Añadir al inicio del contenedor
                        $('#contenedor-notas').prepend(html);
                        // También al modal
                        $('#lista-todas-notas').prepend(html);

                        swal({
                            title: "Nota guardada",
                            type: "success",
                            timer: 1000,
                            showConfirmButton: false
                        });
                    } else {
                        swal('Error', response.message, 'error');
                    }
                    btn.prop('disabled', false);
                },
                error: function() {
                    swal('Error', 'No se pudo guardar la nota', 'error');
                    btn.prop('disabled', false);
                }
            });
        });
    });
</script>
<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@stop