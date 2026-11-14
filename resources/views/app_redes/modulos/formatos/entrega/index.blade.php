@extends('layouts.app_redes')

@section('css')
  @include('app_redes.modulos.formatos.partials.estilos_hoja')
@stop

@section('content')
<div class="container-fluid mb-5">

  @include('app_redes.modulos.formatos.partials.buscador_cotizacion', ['tipoFormato' => 'entrega'])

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif

  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="fas fa-exclamation-triangle mr-1"></i> {{ session('error') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif

  @if($formatoEdit)
    <div class="alert alert-info border-left-info shadow-sm d-flex flex-wrap justify-content-between align-items-center mb-3 no-print">
      <div>
        <i class="fas fa-edit mr-2"></i>
        <strong>Modo Edición:</strong> Estás editando el Formato de Entrega <strong>{{ $formatoEdit->folio_entrega }}</strong>.
      </div>
      <div class="mt-2 mt-md-0">
        <a href="{{ route('app_formatos_entrega_pdf', $formatoEdit->id) }}" target="_blank" class="btn btn-sm btn-outline-danger mr-1">
          <i class="fas fa-file-pdf mr-1"></i> Descargar PDF actual
        </a>
        <a href="{{ $cotizacion ? route('app_formatos_entrega', $cotizacion->id_cotizacion) : route('app_formatos_entrega') }}" class="btn btn-sm btn-secondary">
          <i class="fas fa-plus mr-1"></i> Nuevo formato
        </a>
      </div>
    </div>
  @endif

  <!-- NAVEGACIÓN EN PESTAÑAS -->
  <ul class="nav nav-pills nav-pills-andamios mb-3 bg-white p-2 rounded shadow-sm border no-print" id="pills-tab-entrega" role="tablist">
    <li class="nav-item">
      <a class="nav-link active font-weight-bold" id="tab-formato-link" data-toggle="pill" href="#tab-formato" role="tab" aria-controls="tab-formato" aria-selected="true">
        <i class="fas {{ $formatoEdit ? 'fa-edit' : 'fa-file-invoice' }} mr-1"></i>
        {{ $formatoEdit ? 'Editar Formato de Entrega' : 'Generar Formato de Entrega' }}
        @if($formatoEdit)
          <span class="badge badge-light border ml-1">{{ $formatoEdit->folio_entrega }}</span>
        @elseif($cotizacion)
          <span class="badge badge-light border ml-1">Entrega #{{ $numeroSiguienteEntrega }}</span>
        @endif
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link font-weight-bold" id="tab-historial-link" data-toggle="pill" href="#tab-historial" role="tab" aria-controls="tab-historial" aria-selected="false">
        <i class="fas fa-history mr-1"></i>
        {{ $cotizacion ? 'Historial de esta Cotización' : 'Historial de Formatos' }}
        <span class="badge badge-primary ml-1">{{ $reportesAnteriores->count() }}</span>
      </a>
    </li>
    @if($cotizacion)
    <li class="nav-item">
      <a class="nav-link font-weight-bold" id="tab-balance-link" data-toggle="pill" href="#tab-balance" role="tab" aria-controls="tab-balance" aria-selected="false">
        <i class="fas fa-boxes mr-1"></i>
        Balance de Cotización
        <span class="badge badge-success ml-1">{{ count($balanceProductos) }} prod.</span>
      </a>
    </li>
    @endif
  </ul>

  <div class="tab-content" id="pills-tabContent-entrega">

    <!-- PESTAÑA 1: FORMULARIO INTERACTIVO -->
    <div class="tab-pane fade show active" id="tab-formato" role="tabpanel" aria-labelledby="tab-formato-link">

      @if(!$formatoEdit && $cotizacion && count($productosPendientes) === 0 && count($balanceProductos) > 0)
      <div class="alert alert-success border-left-success shadow-sm mb-3 no-print" role="alert">
        <div class="d-flex align-items-center">
          <i class="fas fa-check-double fa-2x mr-3 text-success"></i>
          <div>
            <h6 class="alert-heading font-weight-bold mb-1">¡Todos los productos cotizados han sido entregados al 100%!</h6>
            <p class="mb-0 small">
              No quedan partidas pendientes en esta cotización. Si necesitas entregar productos adicionales o accesorios, puedes agregarlos con el botón <strong>"Añadir producto"</strong>, o consultar/editar formatos previos en la pestaña <strong>"Historial"</strong>.
            </p>
          </div>
        </div>
      </div>
      @endif

      <div class="card shadow mb-4 border-0">
        <div class="card-body bg-light py-4">
          <form id="form-generar-entrega"
                method="POST"
                action="{{ $formatoEdit ? route('app_formatos_entrega_actualizar', $formatoEdit->id) : route('app_formatos_entrega_guardar') }}">
            {{ csrf_field() }}
            <input type="hidden" name="id_cotizacion" value="{{ $cotizacion ? $cotizacion->id_cotizacion : '' }}">

            <!-- HOJA FÍSICA INTERACTIVA -->
            <div class="hoja-formato" id="seccion-impresion">

              <!-- ENCABEZADO CORPORATIVO -->
              <div class="formato-header">
                <div class="titulos">
                  <h2>FORMATO DE ENTREGA</h2>
                  <p>ANDAMIOS LIGEROS &nbsp;|&nbsp; CONTROL DE ENTREGA DE PRODUCTO</p>
                </div>
                <div class="logo-bloque">
                  @if(!empty($logoBase64))
                    <img src="{{ $logoBase64 }}" class="logo-andamios" alt="Andamios Ligeros">
                  @else
                    <img src="{{ url('/cotizaciones/img/andamios.png') }}" class="logo-andamios" alt="Andamios Ligeros">
                  @endif
                  <div class="logo-eslogan">50% mas ligero, misma resistencia.</div>
                  @if(!empty($cintaBase64))
                    <img src="{{ $cintaBase64 }}" class="cinta-header-bloque" alt="">
                  @endif
                </div>
              </div>

              <!-- TABLA DATOS GENERALES -->
              <table class="formato-tabla mt-3">
                <tbody>
                  <tr>
                    <td class="etiqueta">FOLIO DE ENTREGA</td>
                    <td class="valor">
                      <input type="text" name="folio_entrega" class="input-formato font-weight-bold" value="{{ $folioEntregaDefault }}" placeholder="Ej. 15190" required>
                    </td>
                    <td class="etiqueta">FECHA DE ENTREGA</td>
                    <td class="valor">
                      <div class="d-flex align-items-center">
                        <input type="text" name="fecha_formato" id="input-fecha-entrega" class="input-formato input-fecha-picker" value="{{ $fechaDefault }}" placeholder="dd/mm/aaaa" autocomplete="off">
                        <button type="button" class="btn btn-link btn-sm text-primary p-0 ml-1 no-print btn-abrir-calendario" data-target="#input-fecha-entrega" title="Seleccionar fecha en calendario">
                          <i class="fas fa-calendar-alt"></i>
                        </button>
                        <button type="button" class="btn btn-link btn-sm text-muted p-0 ml-1 no-print btn-limpiar-fecha-picker" data-target="#input-fecha-entrega" title="Dejar fecha en blanco para llenar a mano">
                          <i class="fas fa-eraser"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="etiqueta">CLIENTE / EMPRESA</td>
                    <td class="valor">
                      <div class="contenedor-autocompletado">
                        <input type="text" name="cliente" class="input-formato input-busqueda-cliente font-weight-bold" value="{{ $clienteDefault }}" placeholder="Buscar o escribir cliente / empresa..." autocomplete="off">
                        <div class="dropdown-coincidencias shadow" style="display: none;"></div>
                      </div>
                    </td>
                    <td class="etiqueta">TELÉFONO</td>
                    <td class="valor">
                      <div class="contenedor-autocompletado">
                        <input type="text" name="telefono" class="input-formato input-busqueda-telefono" value="{{ $telefonoDefault }}" placeholder="Teléfono de contacto" autocomplete="off">
                        <div class="dropdown-coincidencias shadow" style="display: none;"></div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="etiqueta">COTIZACIÓN / PEDIDO</td>
                    <td class="valor">
                      <div class="contenedor-autocompletado">
                        <input type="text" name="folio_cotizacion" class="input-formato input-busqueda-cotizacion-campo" value="{{ $cotizacionPedidoDefault }}" placeholder="Buscar folio (Ej. CAL00015190) o escribir..." autocomplete="off">
                        <div class="dropdown-coincidencias shadow" style="display: none;"></div>
                      </div>
                    </td>
                    <td class="etiqueta">VENDEDOR</td>
                    <td class="valor">
                      <div class="contenedor-autocompletado">
                        <input type="text" name="vendedor" class="input-formato input-busqueda-vendedor" value="{{ $vendedorDefault }}" placeholder="Seleccionar o escribir vendedor..." autocomplete="off">
                        <div class="dropdown-coincidencias shadow" style="display: none;"></div>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>

              <!-- SECCIÓN: DETALLE DE PRODUCTOS ENTREGADOS -->
              <div class="d-flex flex-wrap justify-content-between align-items-center mt-4 mb-2">
                <div class="formato-seccion-titulo my-0">DETALLE DE PRODUCTOS ENTREGADOS</div>
                <div class="no-print d-flex align-items-center mt-2 mt-sm-0">
                  @if($cotizacion && count($balanceProductos) > 0)
                  <div class="dropdown d-inline-block mr-2">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropAgregarProd" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-list-ul mr-1"></i> Añadir de cotización
                    </button>
                    <div class="dropdown-menu dropdown-menu-right shadow-sm" aria-labelledby="dropAgregarProd" style="max-height: 280px; overflow-y: auto;">
                      @foreach($balanceProductos as $bp)
                        <a class="dropdown-item btn-reincorporar-prod" href="#"
                           data-id-det="{{ $bp['id_det_cotizacion'] }}"
                           data-nombre="{{ $bp['nombre_producto'] }}"
                           data-restante="{{ $bp['cantidad_max_form'] }}"
                           data-cotizado="{{ $bp['cantidad_cotizada'] }}"
                           data-unidad="{{ $bp['unidad'] }}">
                          {{ $bp['nombre_producto'] }}
                          <small class="text-muted">(Disp: {{ \App\Http\Controllers\Traits\FormatosHelperTrait::formatearCantidad($bp['cantidad_max_form']) }} {{ $bp['unidad'] }})</small>
                        </a>
                      @endforeach
                    </div>
                  </div>
                  @endif
                  <button type="button" class="btn btn-sm btn-outline-primary" id="btn-agregar-prod-manual">
                    <i class="fas fa-plus-circle mr-1"></i> Añadir producto
                  </button>
                </div>
              </div>

              <table class="tabla-productos" id="tabla-productos-entrega">
                <thead>
                  <tr>
                    <th style="width: 10%; text-align: center;">N.°</th>
                    <th style="width: 67%; text-align: center;">PRODUCTO / DESCRIPCIÓN</th>
                    <th style="width: 17%; text-align: center;">CANTIDAD</th>
                    <th style="width: 6%; text-align: center;" class="no-print"></th>
                  </tr>
                </thead>
                <tbody id="tbody-productos-entrega">
                  @php $contadorRow = 0; @endphp
                  @forelse($filasFormulario as $fila)
                    @php
                      $contadorRow++;
                      $esCotizado = !empty($fila['id_det_cotizacion']);
                    @endphp
                    <tr class="fila-producto {{ $esCotizado ? '' : 'fila-producto-manual' }}" id="{{ $esCotizado ? 'fila-prod-' . $fila['id_det_cotizacion'] : 'fila-prod-manual-' . $contadorRow }}">
                      <td class="text-center col-numero-fila font-weight-bold">{{ $contadorRow }}</td>
                      <td>
                        <input type="hidden" name="productos[{{ $contadorRow }}][id_det_cotizacion]" value="{{ $fila['id_det_cotizacion'] ?: '' }}">
                        <input type="hidden" name="productos[{{ $contadorRow }}][id_producto]" class="input-id-producto" value="{{ $fila['id_producto'] ?: '' }}">
                        <input type="hidden" name="productos[{{ $contadorRow }}][unidad]" value="{{ $fila['unidad'] ?: 'pzas' }}">
                        @if($esCotizado)
                          <input type="text" name="productos[{{ $contadorRow }}][nombre_producto]" class="input-formato font-weight-bold" value="{{ $fila['nombre_producto'] }}" required>
                        @else
                          <div class="contenedor-autocompletado">
                            <input type="text" name="productos[{{ $contadorRow }}][nombre_producto]" class="input-formato input-formato-manual input-busqueda-producto font-weight-bold" value="{{ $fila['nombre_producto'] }}" placeholder="Buscar en catálogo o escribir producto..." autocomplete="off" required>
                            <div class="dropdown-coincidencias shadow" style="display: none;"></div>
                          </div>
                        @endif
                      </td>
                      <td class="text-center">
                        <input type="number"
                               name="productos[{{ $contadorRow }}][cantidad]"
                               class="form-control form-control-sm input-cantidad-prod text-center"
                               value="{{ $fila['cantidad'] == intval($fila['cantidad']) ? intval($fila['cantidad']) : $fila['cantidad'] }}"
                               min="0.01"
                               @if($esCotizado && $fila['max_disponible'] !== null) max="{{ $fila['max_disponible'] }}" data-max="{{ $fila['max_disponible'] }}" @endif
                               step="any"
                               data-nombre="{{ $fila['nombre_producto'] }}"
                               data-unidad="{{ $fila['unidad'] ?: 'pzas' }}"
                               required
                               oninput="validarMaximoEntrega(this)">
                        @if($esCotizado && $fila['max_disponible'] !== null)
                          <div class="small text-muted no-print text-center" style="font-size: 10px;">
                            Máx: <strong>{{ \App\Http\Controllers\Traits\FormatosHelperTrait::formatearCantidad($fila['max_disponible']) }} {{ $fila['unidad'] ?: 'pzas' }}</strong>
                          </div>
                        @endif
                      </td>
                      <td class="text-center no-print">
                        <button type="button" class="btn btn-outline-danger btn-sm p-1 btn-quitar-fila" title="Quitar partida" onclick="quitarFilaEntrega(this)">
                          <i class="fas fa-times"></i>
                        </button>
                      </td>
                    </tr>
                  @empty
                    @if(!$cotizacion)
                      @php $contadorRow = 1; @endphp
                      <tr class="fila-producto fila-producto-manual" id="fila-prod-manual-1">
                        <td class="text-center col-numero-fila font-weight-bold">1</td>
                        <td>
                          <input type="hidden" name="productos[1][id_det_cotizacion]" value="">
                          <input type="hidden" name="productos[1][id_producto]" class="input-id-producto" value="">
                          <input type="hidden" name="productos[1][unidad]" value="pzas">
                          <div class="contenedor-autocompletado">
                            <input type="text" name="productos[1][nombre_producto]" class="input-formato input-formato-manual input-busqueda-producto font-weight-bold" placeholder="Buscar en catálogo o escribir producto..." autocomplete="off" required>
                            <div class="dropdown-coincidencias shadow" style="display: none;"></div>
                          </div>
                        </td>
                        <td class="text-center">
                          <input type="number" name="productos[1][cantidad]" class="form-control form-control-sm input-cantidad-prod text-center" value="1" min="0.01" step="any" data-nombre="este producto" data-unidad="pzas" required oninput="validarMaximoEntrega(this)">
                        </td>
                        <td class="text-center no-print">
                          <button type="button" class="btn btn-outline-danger btn-sm p-1 btn-quitar-fila" title="Quitar partida" onclick="quitarFilaEntrega(this)">
                            <i class="fas fa-times"></i>
                          </button>
                        </td>
                      </tr>
                    @else
                      <tr id="fila-sin-productos">
                        <td colspan="4" class="text-center py-3 text-muted">
                          <em>No hay productos pendientes en este formato. Usa <strong>"Añadir producto"</strong> o <strong>"Añadir de cotización"</strong> arriba para agregar partidas.</em>
                        </td>
                      </tr>
                    @endif
                  @endforelse
                </tbody>
              </table>

              <!-- SECCIÓN: OBSERVACIONES / INCIDENCIAS -->
              <div class="formato-seccion-titulo">OBSERVACIONES / INCIDENCIAS</div>
              <div class="lineas-observaciones">
                <textarea name="observaciones" class="textarea-observaciones" rows="2" placeholder="Escribe aquí cualquier observación, incidencia o detalle relevante sobre la entrega...">{{ $observacionesDefault }}</textarea>
              </div>

              <!-- LEYENDA LEGAL -->
              <div class="texto-legal">
                RECIBÍ los productos descritos en este formato y dejo constancia de la revisión realizada al momento de la entrega. Las observaciones, faltantes o daños visibles se anotan en el apartado correspondiente.
              </div>

              <!-- FIRMA ÚNICA CENTRADA -->
              <div class="firmas-container">
                <div class="firma-bloque">
                  <div class="firma-linea"></div>
                  <div class="firma-titulo">RECIBIÓ</div>
                </div>
              </div>

              <!-- FOOTER CORPORATIVO -->
              <div class="formato-footer-legal">
                ANDAMIOS LIGEROS &bull; Formato interno de control de entrega &bull; Conservar copia firmada
              </div>

            </div>
            <!-- FIN HOJA FÍSICA -->

            <!-- BOTONERA DE ACCIONES -->
            <div class="mt-4 text-center no-print">
              <button type="submit" id="btn-guardar-entrega" class="btn btn-success btn-lg px-4 shadow">
                <i class="fas fa-save mr-2"></i> {{ $formatoEdit ? 'Actualizar Formato' : 'Guardar Formato de Entrega' }}
              </button>
              <button type="button" id="btn-guardar-y-pdf" class="btn btn-danger btn-lg px-4 ml-2 shadow">
                <i class="fas fa-file-pdf mr-2"></i> Guardar y Descargar PDF
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>

    <!-- PESTAÑA 2: HISTORIAL DE FORMATOS -->
    <div class="tab-pane fade" id="tab-historial" role="tabpanel" aria-labelledby="tab-historial-link">
      <div class="card shadow mb-4 border-0">
        <div class="card-header py-3 bg-white d-flex flex-wrap justify-content-between align-items-center">
          <h6 class="m-0 font-weight-bold text-dark">
            <i class="fas fa-history mr-1 text-primary"></i>
            {{ $cotizacion ? 'Formatos de Entrega para ' . $cotizacion->cod_cotizacion : 'Últimos Formatos de Entrega Registrados' }}
          </h6>
          <div class="d-flex align-items-center mt-2 mt-md-0">
            <input type="text" id="filtro-historial-entrega" class="form-control form-control-sm mr-2" placeholder="Filtrar por folio, cliente o cotización..." style="width: 240px;">
            <span class="badge badge-azul px-2 py-1">Total: {{ $reportesAnteriores->count() }}</span>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover mb-0 text-center" id="tabla-historial-entrega" style="font-size: 0.85rem;">
              <thead class="thead-light">
                <tr>
                  <th>Folio Entrega</th>
                  <th>Fecha</th>
                  <th class="text-left">Cliente / Empresa</th>
                  <th>Cotización / Pedido</th>
                  <th>Vendedor</th>
                  <th class="text-left">Productos Entregados</th>
                  <th style="width: 240px;">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @forelse($reportesAnteriores as $rep)
                <tr class="fila-historial-item">
                  <td><span class="badge badge-azul px-2 py-1">{{ $rep->folio_entrega }}</span></td>
                  <td style="white-space: nowrap;">{{ $rep->fecha_formato ?: ($rep->fecha ? date('d/m/Y', strtotime($rep->fecha)) : 'Sin fecha') }}</td>
                  <td class="text-left font-weight-bold">{{ $rep->cliente ?: 'N/D' }}</td>
                  <td>
                    @if($rep->id_cotizacion)
                      <a href="{{ route('app_formatos_entrega', $rep->id_cotizacion) }}" class="font-weight-bold text-primary" title="Abrir entregas de esta cotización">
                        {{ $rep->folio_cotizacion ?: ('#' . $rep->id_cotizacion) }}
                      </a>
                    @else
                      {{ $rep->folio_cotizacion ?: '—' }}
                    @endif
                  </td>
                  <td>{{ $rep->vendedor ?: '—' }}</td>
                  <td class="text-left">
                    <ul class="list-unstyled mb-0 pl-1 small">
                      @foreach($rep->detalles as $d)
                        <li>
                          <i class="fas fa-check text-success mr-1"></i>
                          <strong>{{ \App\Http\Controllers\Traits\FormatosHelperTrait::formatearCantidad($d->cantidad) }}</strong>
                          {{ $d->nombre_producto }}
                        </li>
                      @endforeach
                    </ul>
                  </td>
                  <td>
                    <div class="btn-group" role="group">
                      <a href="{{ route('app_formatos_entrega_pdf', $rep->id) }}" target="_blank" class="btn btn-sm btn-outline-danger" title="Descargar PDF">
                        <i class="fas fa-file-pdf mr-1"></i> Descargar
                      </a>
                      <a href="{{ ($rep->id_cotizacion ? route('app_formatos_entrega', $rep->id_cotizacion) : route('app_formatos_entrega')) . '?editar=' . $rep->id }}" class="btn btn-sm btn-outline-warning text-dark" title="Editar formato">
                        <i class="fas fa-edit"></i>
                      </a>
                      <button type="button" class="btn btn-sm btn-outline-secondary btn-eliminar-reporte" data-id="{{ $rep->id }}" data-folio="{{ $rep->folio_entrega }}" title="Eliminar formato">
                        <i class="fas fa-trash"></i>
                      </button>
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="7" class="text-center py-4 text-muted">
                    <i class="fas fa-inbox fa-3x mb-2 d-block text-gray-300"></i>
                    Aún no se ha generado ningún formato de entrega.
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- PESTAÑA 3: BALANCE DE COTIZACIÓN -->
    @if($cotizacion)
    <div class="tab-pane fade" id="tab-balance" role="tabpanel" aria-labelledby="tab-balance-link">
      <div class="card shadow mb-4 border-0">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
          <h6 class="m-0 font-weight-bold text-dark">
            <i class="fas fa-boxes mr-1 text-success"></i> Desglose de Productos: Cotizado vs Entregado vs Restante
          </h6>
          <span class="badge badge-light border">{{ count($balanceProductos) }} partidas</span>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover table-striped mb-0 text-center" style="font-size: 0.85rem;">
              <thead class="thead-light">
                <tr>
                  <th class="text-left">Producto</th>
                  <th style="width: 160px;">Cotizado</th>
                  <th style="width: 160px;">Ya Entregado</th>
                  <th style="width: 160px;">Faltante / Pendiente</th>
                  <th style="width: 150px;">Estatus</th>
                </tr>
              </thead>
              <tbody>
                @forelse($balanceProductos as $bp)
                <tr>
                  <td class="text-left font-weight-bold text-dark">{{ $bp['nombre_producto'] }}</td>
                  <td><span class="badge badge-light border px-2 py-1 font-weight-bold">{{ \App\Http\Controllers\Traits\FormatosHelperTrait::formatearCantidad($bp['cantidad_cotizada']) }} {{ $bp['unidad'] }}</span></td>
                  <td><span class="badge badge-info px-2 py-1">{{ \App\Http\Controllers\Traits\FormatosHelperTrait::formatearCantidad($bp['cantidad_entregada']) }} {{ $bp['unidad'] }}</span></td>
                  <td>
                    @if($bp['cantidad_restante'] > 0.001)
                      <span class="badge badge-danger px-2 py-1 font-weight-bold">{{ \App\Http\Controllers\Traits\FormatosHelperTrait::formatearCantidad($bp['cantidad_restante']) }} {{ $bp['unidad'] }}</span>
                    @else
                      <span class="badge badge-success px-2 py-1"><i class="fas fa-check"></i> 0 {{ $bp['unidad'] }}</span>
                    @endif
                  </td>
                  <td>
                    @if($bp['completo'])
                      <span class="badge badge-success px-2 py-1"><i class="fas fa-check-circle"></i> Surtido 100%</span>
                    @elseif($bp['cantidad_entregada'] > 0)
                      <span class="badge badge-warning text-dark px-2 py-1"><i class="fas fa-adjust"></i> Parcial</span>
                    @else
                      <span class="badge badge-secondary px-2 py-1"><i class="fas fa-hourglass-start"></i> No entregado</span>
                    @endif
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="5" class="text-center py-3 text-muted">No hay productos en esta cotización.</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    @endif

  </div>
</div>
@stop

@section('js')
@include('app_redes.modulos.formatos.partials.autocompletado_js', ['rutaBaseFormato' => url('sb-admin/formatos/entrega')])
<script>
  var contadorRows = {{ $contadorRow }};
  var modoEdicion = {{ $formatoEdit ? 'true' : 'false' }};
  var accionPostGuardado = 'normal'; // 'normal' | 'ver' | 'pdf'

  // Callback para selección de producto desde el catálogo
  window.onSelectProductoFormato = function(tr, prod) {
    tr.find('.input-busqueda-producto').val(prod.nombre);
    tr.find('.input-id-producto').val(prod.id);
    tr.find('input[name$="[unidad]"]').val(prod.unidad || 'pzas');
    tr.find('.input-cantidad-prod').attr('data-nombre', prod.nombre).attr('data-unidad', prod.unidad || 'pzas');
    tr.find('.input-cantidad-prod').focus().select();
  };

  function renumerarFilasEntrega() {
    var num = 1;
    $('#tbody-productos-entrega tr.fila-producto').each(function() {
      $(this).find('.col-numero-fila').text(num);
      num++;
    });
  }

  function validarMaximoEntrega(input) {
    var val = parseFloat(input.value);
    var maxAttr = input.getAttribute('data-max');
    if (maxAttr !== null && maxAttr !== '') {
      var max = parseFloat(maxAttr);
      var prodNombre = input.getAttribute('data-nombre') || 'este producto';
      var unidad = input.getAttribute('data-unidad') || 'pzas';
      if (!isNaN(max) && val > (max + 0.001)) {
        swal({
          title: "Cantidad no permitida",
          text: "No puedes enviar más cantidad de lo cotizado disponible (" + max + " " + unidad + " máximos para " + prodNombre + ").",
          icon: "warning",
          button: "Entendido",
        });
        input.value = max;
        return;
      }
    }
    if (val <= 0 && input.value !== "") {
      input.value = 1;
    }
  }

  function quitarFilaEntrega(btn) {
    $(btn).closest('tr').remove();
    renumerarFilasEntrega();

    if ($('#tbody-productos-entrega tr.fila-producto').length === 0) {
      if ($('#fila-sin-productos').length === 0) {
        $('#tbody-productos-entrega').append(
          '<tr id="fila-sin-productos"><td colspan="4" class="text-center py-3 text-muted"><em>No hay productos en este formato. Usa "Añadir producto" arriba para agregar partidas.</em></td></tr>'
        );
      }
    }
  }

  // Botón limpiar fecha para impresión en blanco
  $('#btn-limpiar-fecha').on('click', function() {
    $('#input-fecha-entrega').val('').focus();
  });

  // Reincorporar partida de cotización
  $(document).on('click', '.btn-reincorporar-prod', function(e) {
    e.preventDefault();
    var idDet = $(this).attr('data-id-det');
    var nombre = $(this).attr('data-nombre');
    var restante = parseFloat($(this).attr('data-restante'));
    var unidad = $(this).attr('data-unidad') || 'pzas';

    if ($('#fila-prod-' + idDet).length > 0) {
      swal({
        title: "Producto ya en lista",
        text: "Esta partida ya se encuentra agregada. Puedes modificar su cantidad directamente en la tabla.",
        icon: "info"
      });
      return;
    }

    if (restante <= 0.001) {
      swal({
        title: "Saldo agotado",
        text: "Ya no hay cantidad restante disponible en la cotización para \"" + nombre + "\".",
        icon: "warning"
      });
      return;
    }

    $('#fila-sin-productos').remove();
    contadorRows++;
    var numActual = $('#tbody-productos-entrega tr.fila-producto').length + 1;
    var cantFmt = (restante == parseInt(restante, 10)) ? parseInt(restante, 10) : restante;

    var htmlRow = `
      <tr class="fila-producto" id="fila-prod-${idDet}">
        <td class="text-center col-numero-fila font-weight-bold">${numActual}</td>
        <td>
          <input type="hidden" name="productos[${contadorRows}][id_det_cotizacion]" value="${idDet}">
          <input type="hidden" name="productos[${contadorRows}][id_producto]" class="input-id-producto" value="">
          <input type="hidden" name="productos[${contadorRows}][unidad]" value="${escapeHtmlFormato(unidad)}">
          <input type="text" name="productos[${contadorRows}][nombre_producto]" class="input-formato font-weight-bold" value="${escapeHtmlFormato(nombre)}" required>
        </td>
        <td class="text-center">
          <input type="number"
                 name="productos[${contadorRows}][cantidad]"
                 class="form-control form-control-sm input-cantidad-prod text-center"
                 value="${cantFmt}"
                 min="0.01"
                 max="${restante}"
                 step="any"
                 data-max="${restante}"
                 data-nombre="${escapeHtmlFormato(nombre)}"
                 data-unidad="${escapeHtmlFormato(unidad)}"
                 required
                 oninput="validarMaximoEntrega(this)">
          <div class="small text-muted no-print text-center" style="font-size: 10px;">
            Máx: <strong>${cantFmt} ${escapeHtmlFormato(unidad)}</strong>
          </div>
        </td>
        <td class="text-center no-print">
          <button type="button" class="btn btn-outline-danger btn-sm p-1 btn-quitar-fila" title="Quitar partida" onclick="quitarFilaEntrega(this)">
            <i class="fas fa-times"></i>
          </button>
        </td>
      </tr>
    `;

    $('#tbody-productos-entrega').append(htmlRow);
    renumerarFilasEntrega();
  });

  // Añadir producto adicional / catálogo
  $('#btn-agregar-prod-manual').on('click', function(e) {
    e.preventDefault();
    $('#fila-sin-productos').remove();
    contadorRows++;
    var numActual = $('#tbody-productos-entrega tr.fila-producto').length + 1;

    var htmlRow = `
      <tr class="fila-producto fila-producto-manual" id="fila-prod-manual-${contadorRows}">
        <td class="text-center col-numero-fila font-weight-bold">${numActual}</td>
        <td>
          <input type="hidden" name="productos[${contadorRows}][id_det_cotizacion]" value="">
          <input type="hidden" name="productos[${contadorRows}][id_producto]" class="input-id-producto" value="">
          <input type="hidden" name="productos[${contadorRows}][unidad]" value="pzas">
          <div class="contenedor-autocompletado">
            <input type="text"
                   name="productos[${contadorRows}][nombre_producto]"
                   class="input-formato input-formato-manual input-busqueda-producto font-weight-bold"
                   placeholder="Buscar en catálogo o escribir producto..."
                   autocomplete="off"
                   required>
            <div class="dropdown-coincidencias shadow" style="display: none;"></div>
          </div>
        </td>
        <td class="text-center">
          <input type="number"
                 name="productos[${contadorRows}][cantidad]"
                 class="form-control form-control-sm input-cantidad-prod text-center"
                 value="1"
                 min="0.01"
                 step="any"
                 data-nombre="este producto"
                 data-unidad="pzas"
                 required
                 oninput="validarMaximoEntrega(this)">
        </td>
        <td class="text-center no-print">
          <button type="button" class="btn btn-outline-danger btn-sm p-1 btn-quitar-fila" title="Quitar partida" onclick="quitarFilaEntrega(this)">
            <i class="fas fa-times"></i>
          </button>
        </td>
      </tr>
    `;

    $('#tbody-productos-entrega').append(htmlRow);
    renumerarFilasEntrega();
    var nuevoInput = $('#fila-prod-manual-' + contadorRows).find('.input-busqueda-producto');
    nuevoInput.focus();
  });

  // Filtro en vivo en tabla de historial
  $('#filtro-historial-entrega').on('input', function() {
    var q = $(this).val().toLowerCase().trim();
    $('#tabla-historial-entrega tbody tr.fila-historial-item').each(function() {
      var txt = $(this).text().toLowerCase();
      $(this).toggle(txt.indexOf(q) !== -1);
    });
  });

  // Botones de guardado
  $('#btn-guardar-y-pdf').on('click', function() {
    accionPostGuardado = 'pdf';
    $('#form-generar-entrega').submit();
  });

  $('#form-generar-entrega').on('submit', function(e) {
    e.preventDefault();

    if ($('#tbody-productos-entrega tr.fila-producto').length === 0) {
      accionPostGuardado = 'normal';
      swal({
        title: "Atención",
        text: "Debes incluir al menos un producto en este formato.",
        icon: "warning",
      });
      return false;
    }

    var nombreInvalido = false;
    $('#tbody-productos-entrega tr.fila-producto').each(function() {
      var valNombre = $(this).find('input[name$="[nombre_producto]"]').val();
      if (!valNombre || $.trim(valNombre) === '') {
        nombreInvalido = true;
        return false;
      }
    });

    if (nombreInvalido) {
      accionPostGuardado = 'normal';
      swal({
        title: "Nombre requerido",
        text: "Por favor indica el nombre o descripción de todos los productos.",
        icon: "warning"
      });
      return false;
    }

    var valido = true;
    $('.input-cantidad-prod').each(function() {
      var val = parseFloat($(this).val());
      var maxAttr = $(this).attr('data-max');
      if (isNaN(val) || val <= 0) {
        valido = false;
        swal({
          title: "Cantidad inválida",
          text: "Las cantidades deben ser mayores a 0.",
          icon: "warning"
        });
        return false;
      }
      if (maxAttr !== undefined && maxAttr !== '') {
        var max = parseFloat(maxAttr);
        if (!isNaN(max) && val > (max + 0.001)) {
          valido = false;
          swal({
            title: "Cantidad excedida",
            text: "No puedes registrar más cantidad de la cotizada disponible.",
            icon: "error"
          });
          return false;
        }
      }
    });

    if (!valido) {
      accionPostGuardado = 'normal';
      return false;
    }

    var btnSubmit = $('#btn-guardar-entrega');
    var btnPdf = $('#btn-guardar-y-pdf');
    var textoOriginal = btnSubmit.html();

    btnSubmit.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Guardando...');
    btnPdf.prop('disabled', true);

    $.ajax({
      url: $(this).attr('action'),
      type: 'POST',
      data: $(this).serialize(),
      dataType: 'json',
      success: function(response) {
        if (response.success) {
          if (accionPostGuardado === 'pdf') {
            window.open(response.url_pdf, '_blank');
            window.location.href = response.url_editar;
            return;
          }

          swal({
            title: modoEdicion ? "¡Formato Actualizado!" : "¡Formato Generado!",
            text: response.message,
            icon: "success",
            buttons: {
              pdf: { text: "Descargar PDF", value: "pdf" },
              seguir: { text: "Seguir aquí", value: "seguir" }
            }
          }).then(function(value) {
            if (value === "pdf") {
              window.open(response.url_pdf, '_blank');
              window.location.href = response.url_editar;
            } else {
              window.location.href = response.url_editar;
            }
          });
        } else {
          accionPostGuardado = 'normal';
          swal({ title: "Error", text: response.message || "Ocurrió un error al guardar.", icon: "error" });
          btnSubmit.prop('disabled', false).html(textoOriginal);
          btnPdf.prop('disabled', false);
        }
      },
      error: function(xhr) {
        accionPostGuardado = 'normal';
        var msg = "Ocurrió un error inesperado al procesar la solicitud.";
        if (xhr.responseJSON && xhr.responseJSON.message) {
          msg = xhr.responseJSON.message;
        }
        swal({ title: "Error al guardar", text: msg, icon: "error" });
        btnSubmit.prop('disabled', false).html(textoOriginal);
        btnPdf.prop('disabled', false);
      }
    });
  });

  // Eliminar un formato del historial
  $(document).on('click', '.btn-eliminar-reporte', function(e) {
    e.preventDefault();
    var idReporte = $(this).attr('data-id');
    var folio = $(this).attr('data-folio');

    swal({
      title: "¿Eliminar formato de entrega?",
      text: "Se eliminará el registro " + folio + " permanentemente.",
      icon: "warning",
      buttons: ["Cancelar", "Sí, eliminar"],
      dangerMode: true,
    }).then(function(willDelete) {
      if (willDelete) {
        $.ajax({
          url: "{{ url('sb-admin/formatos/entrega') }}/" + idReporte + "/eliminar",
          type: 'DELETE',
          data: { _token: "{{ csrf_token() }}" },
          dataType: 'json',
          success: function(resp) {
            if (resp.success) {
              swal({ title: "Eliminado", text: resp.message, icon: "success" }).then(function() {
                window.location.href = "{{ $cotizacion ? route('app_formatos_entrega', $cotizacion->id_cotizacion) : route('app_formatos_entrega') }}";
              });
            } else {
              swal("Error", resp.message || "No se pudo eliminar el formato.", "error");
            }
          },
          error: function() {
            swal("Error", "No se pudo procesar la solicitud de eliminación.", "error");
          }
        });
      }
    });
  });
</script>
@stop

