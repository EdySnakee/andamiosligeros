@extends('layouts.app_redes')

@section('css')
  @include('app_redes.modulos.formatos.partials.estilos_hoja')
  <style>
    .celda-moneda {
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .celda-moneda .simbolo-moneda {
      color: #495057;
      font-weight: 700;
      margin-right: 3px;
      font-size: 12px;
    }
    .input-moneda {
      text-align: right;
      max-width: 110px;
    }
    .checkbox-pago-label {
      display: inline-flex;
      align-items: center;
      margin-right: 12px;
      margin-bottom: 2px;
      font-size: 12px;
      cursor: pointer;
      font-weight: 500;
    }
    .checkbox-pago-label input {
      margin-right: 5px;
    }
    .condiciones-cambio-lista {
      font-size: 11px;
      color: #333333;
      line-height: 1.45;
      padding-left: 16px;
      margin-top: 4px;
      margin-bottom: 10px;
    }
    .condiciones-cambio-lista li {
      margin-bottom: 2px;
    }
  </style>
@stop

@section('content')
<div class="container-fluid mb-5">

  @include('app_redes.modulos.formatos.partials.buscador_cotizacion', ['tipoFormato' => 'cambio'])

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
        <strong>Modo Edición:</strong> Estás editando el Formato de Cambio <strong>{{ $formatoEdit->folio_cambio }}</strong>.
      </div>
      <div class="mt-2 mt-md-0">
        <a href="{{ route('app_formatos_cambio_pdf', $formatoEdit->id) }}" target="_blank" class="btn btn-sm btn-outline-danger mr-1">
          <i class="fas fa-file-pdf mr-1"></i> Descargar PDF actual
        </a>
        <a href="{{ $cotizacion ? route('app_formatos_cambio', $cotizacion->id_cotizacion) : route('app_formatos_cambio') }}" class="btn btn-sm btn-secondary">
          <i class="fas fa-plus mr-1"></i> Nuevo formato
        </a>
      </div>
    </div>
  @endif

  <!-- NAVEGACIÓN EN PESTAÑAS -->
  <ul class="nav nav-pills nav-pills-andamios mb-3 bg-white p-2 rounded shadow-sm border no-print" id="pills-tab-cambio" role="tablist">
    <li class="nav-item">
      <a class="nav-link active font-weight-bold" id="tab-formato-cambio-link" data-toggle="pill" href="#tab-formato-cambio" role="tab" aria-controls="tab-formato-cambio" aria-selected="true">
        <i class="fas {{ $formatoEdit ? 'fa-edit' : 'fa-exchange-alt' }} mr-1"></i>
        {{ $formatoEdit ? 'Editar Formato de Cambio' : 'Generar Formato de Cambio' }}
        @if($formatoEdit)
          <span class="badge badge-light border ml-1">{{ $formatoEdit->folio_cambio }}</span>
        @endif
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link font-weight-bold" id="tab-historial-cambio-link" data-toggle="pill" href="#tab-historial-cambio" role="tab" aria-controls="tab-historial-cambio" aria-selected="false">
        <i class="fas fa-history mr-1"></i>
        {{ $cotizacion ? 'Historial de esta Cotización' : 'Historial de Cambios' }}
        <span class="badge badge-primary ml-1">{{ $formatosAnteriores->count() }}</span>
      </a>
    </li>
  </ul>

  <div class="tab-content" id="pills-tabContent-cambio">

    <!-- PESTAÑA 1: FORMULARIO INTERACTIVO -->
    <div class="tab-pane fade show active" id="tab-formato-cambio" role="tabpanel" aria-labelledby="tab-formato-cambio-link">
      <div class="card shadow mb-4 border-0">
        <div class="card-body bg-light py-4">
          <form id="form-generar-cambio"
                method="POST"
                action="{{ $formatoEdit ? route('app_formatos_cambio_actualizar', $formatoEdit->id) : route('app_formatos_cambio_guardar') }}">
            {{ csrf_field() }}
            <input type="hidden" name="id_cotizacion" value="{{ $cotizacion ? $cotizacion->id_cotizacion : '' }}">

            <!-- HOJA FÍSICA INTERACTIVA -->
            <div class="hoja-formato" id="seccion-impresion-cambio">

              <!-- ENCABEZADO CORPORATIVO -->
              <div class="formato-header">
                <div class="titulos">
                  <h2>FORMATO DE CAMBIO DE PRODUCTO</h2>
                  <p>ANDAMIOS LIGEROS &nbsp;|&nbsp; DEVOLUCIÓN, SUSTITUCIÓN Y AJUSTE DE DIFERENCIA</p>
                </div>
                <div class="logo-bloque">
                  @if(!empty($logoBase64))
                    <img src="{{ $logoBase64 }}" class="logo-andamios" alt="Andamios Ligeros">
                  @else
                    <img src="{{ url('/cotizaciones/img/andamios.png') }}" class="logo-andamios" alt="Andamios Ligeros">
                  @endif
                  <div class="logo-eslogan">50% mas ligero, misma resistencia.</div>
                </div>
              </div>

              <!-- DATOS GENERALES -->
              <table class="formato-tabla mt-3">
                <tbody>
                  <tr>
                    <td class="etiqueta">FOLIO DE CAMBIO</td>
                    <td class="valor">
                      <input type="text" name="folio_cambio" class="input-formato font-weight-bold" value="{{ $folioCambioDefault }}" placeholder="Ej. CAM-00001" required>
                    </td>
                    <td class="etiqueta">FECHA</td>
                    <td class="valor">
                      <div class="d-flex align-items-center">
                        <input type="text" name="fecha_formato" id="input-fecha-cambio" class="input-formato input-fecha-picker" value="{{ $fechaDefault }}" placeholder="dd/mm/aaaa" autocomplete="off">
                        <button type="button" class="btn btn-link btn-sm text-primary p-0 ml-1 no-print btn-abrir-calendario" data-target="#input-fecha-cambio" title="Seleccionar fecha en calendario">
                          <i class="fas fa-calendar-alt"></i>
                        </button>
                        <button type="button" class="btn btn-link btn-sm text-muted p-0 ml-1 no-print btn-limpiar-fecha-picker" data-target="#input-fecha-cambio" title="Dejar fecha en blanco para llenar a mano">
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
                    <td class="etiqueta">COTIZACIÓN / FACTURA</td>
                    <td class="valor">
                      <div class="contenedor-autocompletado">
                        <input type="text" name="cotizacion_factura" class="input-formato input-busqueda-cotizacion-campo" value="{{ $cotizacionFacturaDefault }}" placeholder="Buscar folio (Ej. CAL00015190) o escribir..." autocomplete="off">
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

              <!-- SECCIÓN 1: PRODUCTO QUE ENTREGA / CAMBIA EL CLIENTE -->
              <div class="d-flex flex-wrap justify-content-between align-items-center mt-3 mb-2">
                <div class="formato-seccion-titulo my-0">1. PRODUCTO QUE ENTREGA / CAMBIA EL CLIENTE</div>
                <div class="no-print d-flex align-items-center mt-1 mt-sm-0">
                  @if($cotizacion && count($productosCotizacion) > 0)
                  <div class="dropdown d-inline-block mr-2">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropProdCotiCambio" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-list-ul mr-1"></i> Añadir de cotización
                    </button>
                    <div class="dropdown-menu dropdown-menu-right shadow-sm" aria-labelledby="dropProdCotiCambio" style="max-height: 260px; overflow-y: auto;">
                      @foreach($productosCotizacion as $pc)
                        <a class="dropdown-item btn-agregar-entregado-coti" href="#"
                           data-id-prod="{{ $pc['id_producto'] }}"
                           data-nombre="{{ $pc['nombre_producto'] }}"
                           data-cantidad="{{ $pc['cantidad'] }}"
                           data-precio="{{ $pc['precio_unit'] }}">
                          {{ $pc['nombre_producto'] }}
                          <small class="text-muted">({{ \App\Http\Controllers\Traits\FormatosHelperTrait::formatearCantidad($pc['cantidad']) }} pzas)</small>
                        </a>
                      @endforeach
                    </div>
                  </div>
                  @endif
                  <button type="button" class="btn btn-sm btn-outline-primary" id="btn-agregar-entregado">
                    <i class="fas fa-plus-circle mr-1"></i> Añadir fila
                  </button>
                </div>
              </div>

              <table class="tabla-productos" id="tabla-entregados">
                <thead>
                  <tr>
                    <th style="width: 7%; text-align: center;">N.°</th>
                    <th style="width: 38%; text-align: center;">PRODUCTO / DESCRIPCIÓN</th>
                    <th style="width: 12%; text-align: center;">CANTIDAD</th>
                    <th style="width: 17%; text-align: center;">VALOR RECONOCIDO</th>
                    <th style="width: 21%; text-align: center;">ESTADO / OBSERVACIONES</th>
                    <th style="width: 5%; text-align: center;" class="no-print"></th>
                  </tr>
                </thead>
                <tbody id="tbody-entregados">
                  @php $contEnt = 0; @endphp
                  @foreach($filasEntregados as $idx => $fEnt)
                    @php $contEnt++; @endphp
                    <tr class="fila-entregado">
                      <td class="text-center col-num-ent font-weight-bold">{{ $contEnt }}</td>
                      <td>
                        <input type="hidden" name="entregados[{{ $contEnt }}][id_producto]" class="input-id-producto" value="{{ $fEnt['id_producto'] ?: '' }}">
                        <div class="contenedor-autocompletado">
                          <input type="text"
                                 name="entregados[{{ $contEnt }}][nombre_producto]"
                                 class="input-formato input-busqueda-producto font-weight-bold"
                                 data-tipo-tabla="entregado"
                                 value="{{ $fEnt['nombre_producto'] }}"
                                 placeholder="Buscar o escribir producto..."
                                 autocomplete="off">
                          <div class="dropdown-coincidencias shadow" style="display: none;"></div>
                        </div>
                      </td>
                      <td class="text-center">
                        <input type="number"
                               name="entregados[{{ $contEnt }}][cantidad]"
                               class="form-control form-control-sm text-center input-cant-ent"
                               value="{{ $fEnt['cantidad'] !== '' ? ($fEnt['cantidad'] == intval($fEnt['cantidad']) ? intval($fEnt['cantidad']) : $fEnt['cantidad']) : '' }}"
                               min="0.01"
                               step="any"
                               placeholder="Cant."
                               oninput="recalcularFilaEntregado(this)">
                      </td>
                      <td>
                        <div class="celda-moneda">
                          <span class="simbolo-moneda">$</span>
                          <input type="number"
                                 name="entregados[{{ $contEnt }}][valor_reconocido]"
                                 class="form-control form-control-sm input-moneda input-valor-reconocido"
                                 value="{{ $fEnt['precio_unitario'] !== '' ? $fEnt['precio_unitario'] : '' }}"
                                 min="0"
                                 step="0.01"
                                 placeholder="0.00"
                                 oninput="recalcularResumenCambio()">
                        </div>
                      </td>
                      <td>
                        <input type="text"
                               name="entregados[{{ $contEnt }}][estado_observaciones]"
                               class="input-formato"
                               value="{{ $fEnt['estado_observaciones'] }}"
                               placeholder="Estado físico / detalle">
                      </td>
                      <td class="text-center no-print">
                        <button type="button" class="btn btn-outline-danger btn-sm p-1" title="Quitar fila" onclick="quitarFilaEntregado(this)">
                          <i class="fas fa-times"></i>
                        </button>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>

              <!-- SECCIÓN 2: PRODUCTO NUEVO / PRODUCTO DE SUSTITUCIÓN -->
              <div class="d-flex flex-wrap justify-content-between align-items-center mt-3 mb-2">
                <div class="formato-seccion-titulo my-0">2. PRODUCTO NUEVO / PRODUCTO DE SUSTITUCIÓN</div>
                <div class="no-print mt-1 mt-sm-0">
                  <button type="button" class="btn btn-sm btn-outline-primary" id="btn-agregar-sustitucion">
                    <i class="fas fa-plus-circle mr-1"></i> Añadir fila
                  </button>
                </div>
              </div>

              <table class="tabla-productos" id="tabla-sustitucion">
                <thead>
                  <tr>
                    <th style="width: 7%; text-align: center;">N.°</th>
                    <th style="width: 40%; text-align: center;">PRODUCTO / DESCRIPCIÓN</th>
                    <th style="width: 12%; text-align: center;">CANTIDAD</th>
                    <th style="width: 18%; text-align: center;">PRECIO UNITARIO</th>
                    <th style="width: 18%; text-align: center;">IMPORTE</th>
                    <th style="width: 5%; text-align: center;" class="no-print"></th>
                  </tr>
                </thead>
                <tbody id="tbody-sustitucion">
                  @php $contSust = 0; @endphp
                  @foreach($filasSustitucion as $idx => $fSust)
                    @php $contSust++; @endphp
                    <tr class="fila-sustitucion">
                      <td class="text-center col-num-sust font-weight-bold">{{ $contSust }}</td>
                      <td>
                        <input type="hidden" name="sustituciones[{{ $contSust }}][id_producto]" class="input-id-producto" value="{{ $fSust['id_producto'] ?: '' }}">
                        <div class="contenedor-autocompletado">
                          <input type="text"
                                 name="sustituciones[{{ $contSust }}][nombre_producto]"
                                 class="input-formato input-busqueda-producto font-weight-bold"
                                 data-tipo-tabla="sustitucion"
                                 value="{{ $fSust['nombre_producto'] }}"
                                 placeholder="Buscar o escribir producto..."
                                 autocomplete="off">
                          <div class="dropdown-coincidencias shadow" style="display: none;"></div>
                        </div>
                      </td>
                      <td class="text-center">
                        <input type="number"
                               name="sustituciones[{{ $contSust }}][cantidad]"
                               class="form-control form-control-sm text-center input-cant-sust"
                               value="{{ $fSust['cantidad'] !== '' ? ($fSust['cantidad'] == intval($fSust['cantidad']) ? intval($fSust['cantidad']) : $fSust['cantidad']) : '' }}"
                               min="0.01"
                               step="any"
                               placeholder="Cant."
                               oninput="recalcularFilaSustitucion(this)">
                      </td>
                      <td>
                        <div class="celda-moneda">
                          <span class="simbolo-moneda">$</span>
                          <input type="number"
                                 name="sustituciones[{{ $contSust }}][precio_unitario]"
                                 class="form-control form-control-sm input-moneda input-precio-sust"
                                 value="{{ $fSust['precio_unitario'] !== '' ? $fSust['precio_unitario'] : '' }}"
                                 min="0"
                                 step="0.01"
                                 placeholder="0.00"
                                 oninput="recalcularFilaSustitucion(this)">
                        </div>
                      </td>
                      <td>
                        <div class="celda-moneda">
                          <span class="simbolo-moneda">$</span>
                          <input type="number"
                                 name="sustituciones[{{ $contSust }}][importe]"
                                 class="form-control form-control-sm input-moneda font-weight-bold input-importe-sust"
                                 value="{{ $fSust['importe'] !== '' ? $fSust['importe'] : '' }}"
                                 min="0"
                                 step="0.01"
                                 placeholder="0.00"
                                 oninput="recalcularResumenCambio()">
                        </div>
                      </td>
                      <td class="text-center no-print">
                        <button type="button" class="btn btn-outline-danger btn-sm p-1" title="Quitar fila" onclick="quitarFilaSustitucion(this)">
                          <i class="fas fa-times"></i>
                        </button>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>

              <!-- CALCULADORA RESUMEN EN TIEMPO REAL (SOLO PANTALLA) -->
              <div class="resumen-cambio-bar my-3 no-print">
                <div class="row text-center align-items-center">
                  <div class="col-md-4 mb-2 mb-md-0">
                    <small class="text-muted text-uppercase font-weight-bold d-block">Total Valor Reconocido</small>
                    <span class="h6 font-weight-bold text-dark" id="lbl-total-reconocido">$ 0.00</span>
                  </div>
                  <div class="col-md-4 mb-2 mb-md-0">
                    <small class="text-muted text-uppercase font-weight-bold d-block">Total Producto Sustitución</small>
                    <span class="h6 font-weight-bold text-primary" id="lbl-total-sustitucion">$ 0.00</span>
                  </div>
                  <div class="col-md-4">
                    <small class="text-muted text-uppercase font-weight-bold d-block" id="lbl-titulo-diferencia">Diferencia a Pagar</small>
                    <span class="h6 font-weight-bold text-danger" id="lbl-diferencia-pagar">$ 0.00</span>
                  </div>
                </div>
              </div>

              <!-- SECCIÓN 3: PAGO DE LA DIFERENCIA Y CONDICIONES -->
              <div class="formato-seccion-titulo">3. PAGO DE LA DIFERENCIA Y CONDICIONES</div>
              <table class="formato-tabla">
                <tbody>
                  <tr>
                    <td class="etiqueta" style="width: 18%;">FORMA DE PAGO</td>
                    <td class="valor" style="width: 38%;">
                      <label class="checkbox-pago-label">
                        <input type="checkbox" name="forma_pago[]" value="Transferencia" {{ in_array('Transferencia', $formasPagoSeleccionadas) ? 'checked' : '' }}> Transferencia
                      </label>
                      <label class="checkbox-pago-label">
                        <input type="checkbox" name="forma_pago[]" value="Link de pago" {{ in_array('Link de pago', $formasPagoSeleccionadas) ? 'checked' : '' }}> Link de pago
                      </label>
                      <label class="checkbox-pago-label">
                        <input type="checkbox" name="forma_pago[]" value="Efectivo" {{ in_array('Efectivo', $formasPagoSeleccionadas) ? 'checked' : '' }}> Efectivo
                      </label>
                    </td>
                    <td class="etiqueta" style="width: 18%;">FECHA DE PAGO</td>
                    <td class="valor" style="width: 26%;">
                      <div class="d-flex align-items-center">
                        <input type="text" name="fecha_pago" id="input-fecha-pago-cambio" class="input-formato input-fecha-picker" value="{{ $fechaPagoDefault }}" placeholder="dd/mm/aaaa" autocomplete="off">
                        <button type="button" class="btn btn-link btn-sm text-primary p-0 ml-1 no-print btn-abrir-calendario" data-target="#input-fecha-pago-cambio" title="Seleccionar fecha de pago">
                          <i class="fas fa-calendar-alt"></i>
                        </button>
                        <button type="button" class="btn btn-link btn-sm text-muted p-0 ml-1 no-print btn-limpiar-fecha-picker" data-target="#input-fecha-pago-cambio" title="Dejar fecha en blanco">
                          <i class="fas fa-eraser"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>

              <div class="formato-seccion-titulo" style="font-size: 11.5px; margin-top: 12px; margin-bottom: 4px;">CONDICIONES DEL CAMBIO</div>
              <ul class="condiciones-cambio-lista">
                <li>El cambio queda sujeto a la revisión y aceptación del producto entregado, así como a la validación de las condiciones comerciales aplicables.</li>
                <li>El valor reconocido y el precio del producto de sustitución se registran en este formato. El cliente cubrirá la diferencia indicada, si corresponde.</li>
                <li>La entrega del producto de sustitución se realizará conforme a lo acordado, una vez validado el pago de la diferencia y la disponibilidad del producto.</li>
              </ul>

              <!-- SECCIÓN 4: OBSERVACIONES (NUMERACIÓN CONSECUTIVA) -->
              <div class="formato-seccion-titulo" style="margin-top: 14px;">4. OBSERVACIONES</div>
              <div class="lineas-observaciones">
                <textarea name="observaciones" class="textarea-observaciones" rows="2" placeholder="Observaciones adicionales sobre el cambio o ajuste comercial...">{{ $observacionesDefault }}</textarea>
              </div>

              <!-- LEYENDA LEGAL -->
              <div class="texto-legal">
                Con la firma de este documento, ambas partes dejan constancia de los productos involucrados en el cambio, el valor reconocido y la diferencia acordada. Este formato no sustituye la factura, nota de crédito ni los comprobantes fiscales que correspondan.
              </div>

              <!-- FIRMAS (3 COLUMNAS) -->
              <div class="firmas-container">
                <div class="firma-bloque-triple">
                  <div class="firma-linea"></div>
                  <div class="firma-titulo">AUTORIZÓ (ANDAMIOS LIGEROS)</div>
                </div>
                <div class="firma-bloque-triple">
                  <div class="firma-linea"></div>
                  <div class="firma-titulo">ENTREGÓ EL PRODUCTO</div>
                </div>
                <div class="firma-bloque-triple">
                  <div class="firma-linea"></div>
                  <div class="firma-titulo">ACEPTÓ EL CAMBIO (CLIENTE)</div>
                </div>
              </div>

              <!-- FOOTER CORPORATIVO -->
              <div class="formato-footer-legal">
                ANDAMIOS LIGEROS &bull; Formato interno de control de cambios y ajustes comerciales
              </div>

            </div>
            <!-- FIN HOJA FÍSICA -->

            <!-- BOTONERA DE ACCIONES -->
            <div class="mt-4 text-center no-print">
              <button type="submit" id="btn-guardar-cambio" class="btn btn-success btn-lg px-4 shadow">
                <i class="fas fa-save mr-2"></i> {{ $formatoEdit ? 'Actualizar Formato' : 'Guardar Formato de Cambio' }}
              </button>
              <button type="button" id="btn-guardar-y-pdf-cambio" class="btn btn-danger btn-lg px-4 ml-2 shadow">
                <i class="fas fa-file-pdf mr-2"></i> Guardar y Descargar PDF
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>

    <!-- PESTAÑA 2: HISTORIAL DE FORMATOS DE CAMBIO -->
    <div class="tab-pane fade" id="tab-historial-cambio" role="tabpanel" aria-labelledby="tab-historial-cambio-link">
      <div class="card shadow mb-4 border-0">
        <div class="card-header py-3 bg-white d-flex flex-wrap justify-content-between align-items-center">
          <h6 class="m-0 font-weight-bold text-dark">
            <i class="fas fa-history mr-1 text-primary"></i>
            {{ $cotizacion ? 'Formatos de Cambio para ' . $cotizacion->cod_cotizacion : 'Últimos Formatos de Cambio Registrados' }}
          </h6>
          <div class="d-flex align-items-center mt-2 mt-md-0">
            <input type="text" id="filtro-historial-cambio" class="form-control form-control-sm mr-2" placeholder="Filtrar por folio, cliente o cotización..." style="width: 240px;">
            <span class="badge badge-azul px-2 py-1">Total: {{ $formatosAnteriores->count() }}</span>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover mb-0 text-center" id="tabla-historial-cambio" style="font-size: 0.85rem;">
              <thead class="thead-light">
                <tr>
                  <th>Folio Cambio</th>
                  <th>Fecha</th>
                  <th class="text-left">Cliente / Empresa</th>
                  <th>Cotización / Factura</th>
                  <th class="text-left">Productos</th>
                  <th>Diferencia</th>
                  <th style="width: 240px;">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @forelse($formatosAnteriores as $fc)
                <tr class="fila-historial-cambio-item">
                  <td><span class="badge badge-azul px-2 py-1">{{ $fc->folio_cambio }}</span></td>
                  <td style="white-space: nowrap;">{{ $fc->fecha_formato ?: ($fc->fecha ? date('d/m/Y', strtotime($fc->fecha)) : 'Sin fecha') }}</td>
                  <td class="text-left font-weight-bold">{{ $fc->cliente ?: 'N/D' }}</td>
                  <td>
                    @if($fc->id_cotizacion)
                      <a href="{{ route('app_formatos_cambio', $fc->id_cotizacion) }}" class="font-weight-bold text-primary">
                        {{ $fc->cotizacion_factura ?: ('#' . $fc->id_cotizacion) }}
                      </a>
                    @else
                      {{ $fc->cotizacion_factura ?: '—' }}
                    @endif
                  </td>
                  <td class="text-left small">
                    @php
                      $ents = $fc->detalles->where('tipo_partida', \App\FormatoCambioDetalle::TIPO_ENTREGADO);
                      $susts = $fc->detalles->where('tipo_partida', \App\FormatoCambioDetalle::TIPO_SUSTITUCION);
                    @endphp
                    @if($ents->count() > 0)
                      <div><strong class="text-secondary">Entrega:</strong>
                        {{ $ents->map(function($d) { return \App\Http\Controllers\Traits\FormatosHelperTrait::formatearCantidad($d->cantidad) . 'x ' . $d->nombre_producto; })->implode(', ') }}
                      </div>
                    @endif
                    @if($susts->count() > 0)
                      <div><strong class="text-primary">Sustituye:</strong>
                        {{ $susts->map(function($d) { return \App\Http\Controllers\Traits\FormatosHelperTrait::formatearCantidad($d->cantidad) . 'x ' . $d->nombre_producto; })->implode(', ') }}
                      </div>
                    @endif
                  </td>
                  <td>
                    @if($fc->diferencia_pagar > 0)
                      <span class="badge badge-danger px-2 py-1">+${{ number_format($fc->diferencia_pagar, 2) }}</span>
                    @elseif($fc->diferencia_pagar < 0)
                      <span class="badge badge-success px-2 py-1">-${{ number_format(abs($fc->diferencia_pagar), 2) }}</span>
                    @else
                      <span class="badge badge-light border px-2 py-1">$0.00</span>
                    @endif
                  </td>
                  <td>
                    <div class="btn-group" role="group">
                      <a href="{{ route('app_formatos_cambio_pdf', $fc->id) }}" target="_blank" class="btn btn-sm btn-outline-danger" title="Descargar PDF">
                        <i class="fas fa-file-pdf mr-1"></i> Descargar
                      </a>
                      <a href="{{ ($fc->id_cotizacion ? route('app_formatos_cambio', $fc->id_cotizacion) : route('app_formatos_cambio')) . '?editar=' . $fc->id }}" class="btn btn-sm btn-outline-warning text-dark" title="Editar formato">
                        <i class="fas fa-edit"></i>
                      </a>
                      <button type="button" class="btn btn-sm btn-outline-secondary btn-eliminar-cambio" data-id="{{ $fc->id }}" data-folio="{{ $fc->folio_cambio }}" title="Eliminar formato">
                        <i class="fas fa-trash"></i>
                      </button>
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="7" class="text-center py-4 text-muted">
                    <i class="fas fa-inbox fa-3x mb-2 d-block text-gray-300"></i>
                    Aún no se ha generado ningún formato de cambio de producto.
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@stop

@section('js')
@include('app_redes.modulos.formatos.partials.autocompletado_js', ['rutaBaseFormato' => url('sb-admin/formatos/cambio-producto')])
<script>
  var contEnt = {{ $contEnt }};
  var contSust = {{ $contSust }};
  var modoEdicionCambio = {{ $formatoEdit ? 'true' : 'false' }};
  var accionPostCambio = 'normal';

  // Callback de selección en autocompletado de catálogo
  window.onSelectProductoFormato = function(tr, prod) {
    var input = tr.find('.input-busqueda-producto');
    var tipo = input.attr('data-tipo-tabla');
    input.val(prod.nombre);
    tr.find('.input-id-producto').val(prod.id);

    if (tipo === 'sustitucion') {
      var cantInput = tr.find('.input-cant-sust');
      var precioInput = tr.find('.input-precio-sust');
      if (!cantInput.val() || parseFloat(cantInput.val()) <= 0) cantInput.val(1);
      if (prod.precio > 0) {
        precioInput.val(prod.precio.toFixed(2));
      }
      recalcularFilaSustitucion(precioInput[0]);
      cantInput.focus().select();
    } else {
      var cantEnt = tr.find('.input-cant-ent');
      if (!cantEnt.val() || parseFloat(cantEnt.val()) <= 0) cantEnt.val(1);
      tr.attr('data-precio-unitario', prod.precio || 0);
      if (prod.precio > 0) {
        var cantVal = parseFloat(cantEnt.val()) || 1;
        tr.find('.input-valor-reconocido').val((cantVal * prod.precio).toFixed(2));
      }
      recalcularResumenCambio();
      cantEnt.focus().select();
    }
  };

  function obtenerPrecioBaseFilaEntregado(tr) {
    var pAttr = parseFloat(tr.attr('data-precio-unitario'));
    if (!isNaN(pAttr) && pAttr > 0) {
      return pAttr;
    }
    var idProd = parseInt(tr.find('.input-id-producto').val(), 10);
    var nomProd = $.trim(tr.find('.input-busqueda-producto').val()).toLowerCase();
    for (var i = 0; i < catalogoProductos.length; i++) {
      var p = catalogoProductos[i];
      if ((idProd > 0 && parseInt(p.id, 10) === idProd) || (nomProd !== '' && String(p.nombre || '').toLowerCase() === nomProd)) {
        var precioCat = parseFloat(p.precio) || 0;
        if (precioCat > 0) {
          tr.attr('data-precio-unitario', precioCat);
          return precioCat;
        }
      }
    }
    return 0;
  }

  function recalcularFilaEntregado(el) {
    var tr = $(el).closest('tr');
    var cant = parseFloat(tr.find('.input-cant-ent').val()) || 0;
    var precioUnit = obtenerPrecioBaseFilaEntregado(tr);
    if (cant > 0 && precioUnit > 0) {
      tr.find('.input-valor-reconocido').val((cant * precioUnit).toFixed(2));
    }
    recalcularResumenCambio();
  }

  function renumerarTablaCambio(selectorFila, selectorCol) {
    var num = 1;
    $(selectorFila).each(function() {
      $(this).find(selectorCol).text(num);
      num++;
    });
  }

  function recalcularFilaSustitucion(el) {
    var tr = $(el).closest('tr');
    var cant = parseFloat(tr.find('.input-cant-sust').val()) || 0;
    var precio = parseFloat(tr.find('.input-precio-sust').val()) || 0;
    if (cant > 0 || precio > 0) {
      var imp = (cant * precio).toFixed(2);
      tr.find('.input-importe-sust').val(imp);
    } else if (tr.find('.input-cant-sust').val() === '' && tr.find('.input-precio-sust').val() === '') {
      tr.find('.input-importe-sust').val('');
    }
    recalcularResumenCambio();
  }

  function recalcularResumenCambio() {
    var totalRec = 0;
    $('.input-valor-reconocido').each(function() {
      totalRec += parseFloat($(this).val()) || 0;
    });

    var totalSust = 0;
    $('.input-importe-sust').each(function() {
      totalSust += parseFloat($(this).val()) || 0;
    });

    var diff = totalSust - totalRec;
    $('#lbl-total-reconocido').text('$ ' + formatMoneyNumber(totalRec));
    $('#lbl-total-sustitucion').text('$ ' + formatMoneyNumber(totalSust));

    var lblDiff = $('#lbl-diferencia-pagar');
    var lblTit = $('#lbl-titulo-diferencia');
    if (diff > 0.009) {
      lblTit.text('Diferencia a Pagar por Cliente');
      lblDiff.removeClass('text-success text-dark').addClass('text-danger').text('$ ' + formatMoneyNumber(diff));
    } else if (diff < -0.009) {
      lblTit.text('Saldo a Favor del Cliente');
      lblDiff.removeClass('text-danger text-dark').addClass('text-success').text('$ ' + formatMoneyNumber(Math.abs(diff)));
    } else {
      lblTit.text('Diferencia Resultante');
      lblDiff.removeClass('text-danger text-success').addClass('text-dark').text('$ 0.00');
    }
  }

  function crearHtmlFilaEntregado(idx, data) {
    data = data || {};
    var cantVal = (data.cantidad !== undefined && data.cantidad !== '') ? data.cantidad : '';
    var precioVal = (data.precio !== undefined && data.precio !== '') ? data.precio : '';
    var precioUnitAttr = (data.precio_unitario !== undefined && data.precio_unitario !== '') ? data.precio_unitario : '';
    return `
      <tr class="fila-entregado" data-precio-unitario="${escapeHtmlFormato(precioUnitAttr)}">
        <td class="text-center col-num-ent font-weight-bold">${idx}</td>
        <td>
          <input type="hidden" name="entregados[${idx}][id_producto]" class="input-id-producto" value="${escapeHtmlFormato(data.id_producto || '')}">
          <div class="contenedor-autocompletado">
            <input type="text"
                   name="entregados[${idx}][nombre_producto]"
                   class="input-formato input-busqueda-producto font-weight-bold"
                   data-tipo-tabla="entregado"
                   value="${escapeHtmlFormato(data.nombre_producto || '')}"
                   placeholder="Buscar o escribir producto..."
                   autocomplete="off">
            <div class="dropdown-coincidencias shadow" style="display: none;"></div>
          </div>
        </td>
        <td class="text-center">
          <input type="number"
                 name="entregados[${idx}][cantidad]"
                 class="form-control form-control-sm text-center input-cant-ent"
                 value="${cantVal}"
                 min="0.01"
                 step="any"
                 placeholder="Cant."
                 oninput="recalcularFilaEntregado(this)">
        </td>
        <td>
          <div class="celda-moneda">
            <span class="simbolo-moneda">$</span>
            <input type="number"
                   name="entregados[${idx}][valor_reconocido]"
                   class="form-control form-control-sm input-moneda input-valor-reconocido"
                   value="${precioVal}"
                   min="0"
                   step="0.01"
                   placeholder="0.00"
                   oninput="recalcularResumenCambio()">
          </div>
        </td>
        <td>
          <input type="text"
                 name="entregados[${idx}][estado_observaciones]"
                 class="input-formato"
                 value="${escapeHtmlFormato(data.estado || '')}"
                 placeholder="Estado físico / detalle">
        </td>
        <td class="text-center no-print">
          <button type="button" class="btn btn-outline-danger btn-sm p-1" title="Quitar fila" onclick="quitarFilaEntregado(this)">
            <i class="fas fa-times"></i>
          </button>
        </td>
      </tr>
    `;
  }

  function crearHtmlFilaSustitucion(idx) {
    return `
      <tr class="fila-sustitucion">
        <td class="text-center col-num-sust font-weight-bold">${idx}</td>
        <td>
          <input type="hidden" name="sustituciones[${idx}][id_producto]" class="input-id-producto" value="">
          <div class="contenedor-autocompletado">
            <input type="text"
                   name="sustituciones[${idx}][nombre_producto]"
                   class="input-formato input-busqueda-producto font-weight-bold"
                   data-tipo-tabla="sustitucion"
                   placeholder="Buscar o escribir producto..."
                   autocomplete="off">
            <div class="dropdown-coincidencias shadow" style="display: none;"></div>
          </div>
        </td>
        <td class="text-center">
          <input type="number"
                 name="sustituciones[${idx}][cantidad]"
                 class="form-control form-control-sm text-center input-cant-sust"
                 min="0.01"
                 step="any"
                 placeholder="Cant."
                 oninput="recalcularFilaSustitucion(this)">
        </td>
        <td>
          <div class="celda-moneda">
            <span class="simbolo-moneda">$</span>
            <input type="number"
                   name="sustituciones[${idx}][precio_unitario]"
                   class="form-control form-control-sm input-moneda input-precio-sust"
                   min="0"
                   step="0.01"
                   placeholder="0.00"
                   oninput="recalcularFilaSustitucion(this)">
          </div>
        </td>
        <td>
          <div class="celda-moneda">
            <span class="simbolo-moneda">$</span>
            <input type="number"
                   name="sustituciones[${idx}][importe]"
                   class="form-control form-control-sm input-moneda font-weight-bold input-importe-sust"
                   min="0"
                   step="0.01"
                   placeholder="0.00"
                   oninput="recalcularResumenCambio()">
          </div>
        </td>
        <td class="text-center no-print">
          <button type="button" class="btn btn-outline-danger btn-sm p-1" title="Quitar fila" onclick="quitarFilaSustitucion(this)">
            <i class="fas fa-times"></i>
          </button>
        </td>
      </tr>
    `;
  }

  function quitarFilaEntregado(btn) {
    $(btn).closest('tr').remove();
    if ($('#tbody-entregados tr.fila-entregado').length === 0) {
      contEnt++;
      $('#tbody-entregados').append(crearHtmlFilaEntregado(contEnt));
    }
    renumerarTablaCambio('#tbody-entregados tr.fila-entregado', '.col-num-ent');
    recalcularResumenCambio();
  }

  function quitarFilaSustitucion(btn) {
    $(btn).closest('tr').remove();
    if ($('#tbody-sustitucion tr.fila-sustitucion').length === 0) {
      contSust++;
      $('#tbody-sustitucion').append(crearHtmlFilaSustitucion(contSust));
    }
    renumerarTablaCambio('#tbody-sustitucion tr.fila-sustitucion', '.col-num-sust');
    recalcularResumenCambio();
  }

  $('#btn-agregar-entregado').on('click', function() {
    contEnt++;
    $('#tbody-entregados').append(crearHtmlFilaEntregado(contEnt));
    renumerarTablaCambio('#tbody-entregados tr.fila-entregado', '.col-num-ent');
    $('#tbody-entregados tr.fila-entregado').last().find('.input-busqueda-producto').focus();
  });

  $(document).on('click', '.btn-agregar-entregado-coti', function(e) {
    e.preventDefault();
    var pUnit = parseFloat($(this).attr('data-precio')) || 0;
    var cantCoti = parseFloat($(this).attr('data-cantidad')) || 1;
    var data = {
      id_producto: $(this).attr('data-id-prod'),
      nombre_producto: $(this).attr('data-nombre'),
      cantidad: $(this).attr('data-cantidad'),
      precio_unitario: pUnit,
      precio: (pUnit * cantCoti).toFixed(2)
    };

    // Si la primera fila está completamente vacía, rellenarla en lugar de dejarla vacía
    var primeraFila = $('#tbody-entregados tr.fila-entregado').first();
    var primeraVacia = ($('#tbody-entregados tr.fila-entregado').length === 1 && $.trim(primeraFila.find('.input-busqueda-producto').val()) === '');

    if (primeraVacia) {
      primeraFila.attr('data-precio-unitario', pUnit);
      primeraFila.find('.input-id-producto').val(data.id_producto);
      primeraFila.find('.input-busqueda-producto').val(data.nombre_producto);
      primeraFila.find('.input-cant-ent').val(data.cantidad);
      primeraFila.find('.input-valor-reconocido').val(data.precio);
    } else {
      contEnt++;
      $('#tbody-entregados').append(crearHtmlFilaEntregado(contEnt, data));
    }
    renumerarTablaCambio('#tbody-entregados tr.fila-entregado', '.col-num-ent');
    recalcularResumenCambio();
  });

  $('#btn-agregar-sustitucion').on('click', function() {
    contSust++;
    $('#tbody-sustitucion').append(crearHtmlFilaSustitucion(contSust));
    renumerarTablaCambio('#tbody-sustitucion tr.fila-sustitucion', '.col-num-sust');
    $('#tbody-sustitucion tr.fila-sustitucion').last().find('.input-busqueda-producto').focus();
  });

  $('#filtro-historial-cambio').on('input', function() {
    var q = $(this).val().toLowerCase().trim();
    $('#tabla-historial-cambio tbody tr.fila-historial-cambio-item').each(function() {
      var txt = $(this).text().toLowerCase();
      $(this).toggle(txt.indexOf(q) !== -1);
    });
  });

  $('#btn-guardar-y-pdf-cambio').on('click', function() {
    accionPostCambio = 'pdf';
    $('#form-generar-cambio').submit();
  });

  $('#form-generar-cambio').on('submit', function(e) {
    e.preventDefault();

    var hayProducto = false;
    $('#tbody-entregados .input-busqueda-producto, #tbody-sustitucion .input-busqueda-producto').each(function() {
      if ($.trim($(this).val()) !== '') {
        hayProducto = true;
        return false;
      }
    });

    if (!hayProducto) {
      accionPostCambio = 'normal';
      swal({
        title: "Atención",
        text: "Debes capturar al menos un producto entregado o un producto de sustitución.",
        icon: "warning"
      });
      return false;
    }

    var btnSubmit = $('#btn-guardar-cambio');
    var btnPdf = $('#btn-guardar-y-pdf-cambio');
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
          if (accionPostCambio === 'pdf') {
            window.open(response.url_pdf, '_blank');
            window.location.href = response.url_editar;
            return;
          }

          swal({
            title: modoEdicionCambio ? "¡Formato Actualizado!" : "¡Formato Generado!",
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
          accionPostCambio = 'normal';
          swal({ title: "Error", text: response.message || "Ocurrió un error al guardar.", icon: "error" });
          btnSubmit.prop('disabled', false).html(textoOriginal);
          btnPdf.prop('disabled', false);
        }
      },
      error: function(xhr) {
        accionPostCambio = 'normal';
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

  // Eliminar un formato de cambio
  $(document).on('click', '.btn-eliminar-cambio', function(e) {
    e.preventDefault();
    var idFormato = $(this).attr('data-id');
    var folio = $(this).attr('data-folio');

    swal({
      title: "¿Eliminar formato de cambio?",
      text: "Se eliminará el registro " + folio + " permanentemente.",
      icon: "warning",
      buttons: ["Cancelar", "Sí, eliminar"],
      dangerMode: true,
    }).then(function(willDelete) {
      if (willDelete) {
        $.ajax({
          url: "{{ url('sb-admin/formatos/cambio-producto') }}/" + idFormato + "/eliminar",
          type: 'DELETE',
          data: { _token: "{{ csrf_token() }}" },
          dataType: 'json',
          success: function(resp) {
            if (resp.success) {
              swal({ title: "Eliminado", text: resp.message, icon: "success" }).then(function() {
                window.location.href = "{{ $cotizacion ? route('app_formatos_cambio', $cotizacion->id_cotizacion) : route('app_formatos_cambio') }}";
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

  // Calcular resumen inicial al cargar (especialmente en modo edición)
  $(document).ready(function() {
    recalcularResumenCambio();
  });
</script>
@stop

