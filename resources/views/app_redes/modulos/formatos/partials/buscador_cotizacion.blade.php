@php
  $esEntrega = ($tipoFormato === 'entrega');
  $rutaBase = $esEntrega ? url('sb-admin/formatos/entrega') : url('sb-admin/formatos/cambio-producto');
  $rutaAlterno = $esEntrega
      ? ($cotizacion ? route('app_formatos_cambio', $cotizacion->id_cotizacion) : route('app_formatos_cambio'))
      : ($cotizacion ? route('app_formatos_entrega', $cotizacion->id_cotizacion) : route('app_formatos_entrega'));
  $textoAlterno = $esEntrega ? 'Ir a Formato de Cambio' : 'Ir a Formato de Entrega';
@endphp

<div class="card shadow-sm mb-3 border-0 card-formato no-print">
  <div class="card-body py-2 px-3">
    <div class="row align-items-center">

      <!-- Identidad del módulo / Cotización vinculada -->
      <div class="col-lg-5 col-md-12 mb-2 mb-lg-0">
        <div class="d-flex align-items-center">
          <div class="mr-3 px-3 py-2 rounded text-white shadow-sm" style="background-color: #1a4189;">
            <i class="fas {{ $esEntrega ? 'fa-truck' : 'fa-exchange-alt' }} fa-lg"></i>
          </div>
          <div>
            @if($cotizacion)
              <div class="d-flex align-items-center flex-wrap">
                <h5 class="mb-0 font-weight-bold text-dark mr-2">
                  {{ $esEntrega ? 'Formato de Entrega' : 'Cambio de Producto' }} &bull; {{ $cotizacion->cod_cotizacion }}
                </h5>
                @if(!empty($estatusInfo))
                  <span class="badge {{ $estatusInfo['badge'] }} px-2 py-1 small">{{ $estatusInfo['texto'] }}</span>
                @endif
              </div>
              <div class="text-muted small">
                Cliente: <strong>{{ $cliente ? $cliente->nombrecl : 'No asignado' }}</strong>
                @if(!empty($telefonoDefault))
                  &bull; Tel: {{ $telefonoDefault }}
                @endif
              </div>
            @else
              <div class="d-flex align-items-center flex-wrap">
                <h5 class="mb-0 font-weight-bold text-dark mr-2">
                  {{ $esEntrega ? 'Formato de Entrega' : 'Formato de Cambio de Producto' }}
                </h5>
                <span class="badge badge-light border text-muted px-2 py-1 small">Modo Libre</span>
              </div>
              <div class="text-muted small">
                Puedes llenar los campos manualmente o vincular una cotización / venta existente.
              </div>
            @endif
          </div>
        </div>
      </div>

      <!-- Buscador rápido o Barra de progreso -->
      <div class="col-lg-4 col-md-7 mb-2 mb-lg-0">
        @if($esEntrega && $cotizacion)
          <div class="d-flex align-items-center justify-content-between mb-1">
            <span class="text-xs font-weight-bold text-uppercase text-muted">Avance de entrega</span>
            <span class="text-xs font-weight-bold" style="color: #1a4189;">{{ $porcentajeEntregado }}%</span>
          </div>
          <div class="progress" style="height: 7px; border-radius: 4px;">
            <div class="progress-bar progress-bar-azul" role="progressbar" style="width: {{ $porcentajeEntregado }}%;" aria-valuenow="{{ $porcentajeEntregado }}" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          <small class="text-muted text-xs d-block mt-1">
            {{ $resumenItemsEntregados }} &bull; <strong>{{ $reportesAnteriores->count() }}</strong> entrega(s)
          </small>
        @else
          <div class="contenedor-autocompletado">
            <div class="input-group input-group-sm">
              <div class="input-group-prepend">
                <span class="input-group-text bg-white border-right-0 text-primary">
                  <i class="fas fa-search"></i>
                </span>
              </div>
              <input type="text"
                     id="input-buscar-cotizacion-formato"
                     class="form-control border-left-0"
                     placeholder="Vincular cotización / venta (folio CAL, VAL, ID o cliente)..."
                     autocomplete="off">
            </div>
            <div id="dropdown-cotizaciones-formato" class="dropdown-coincidencias shadow" style="display: none;"></div>
          </div>
        @endif
      </div>

      <!-- Botones de acción superiores -->
      <div class="col-lg-3 col-md-5 text-lg-right text-left">
        @if($cotizacion)
          <a href="{{ $rutaBase }}" class="btn btn-outline-secondary btn-sm shadow-sm" title="Desvincular cotización y crear formato libre">
            <i class="fas fa-unlink fa-sm mr-1"></i> Libre
          </a>
          <a href="{{ url('sb-admin/edita-cotizacion/' . $cotizacion->id_cotizacion) }}" class="btn btn-outline-info btn-sm shadow-sm ml-1" target="_blank" title="Abrir cotización">
            <i class="fas fa-external-link-alt fa-sm mr-1"></i> Cotización
          </a>
        @else
          <a href="{{ url('sb-admin/ventas') }}" class="btn btn-secondary btn-sm shadow-sm" title="Ir al listado de ventas">
            <i class="fas fa-dollar-sign fa-sm mr-1"></i> Ventas
          </a>
        @endif
        <a href="{{ $rutaAlterno }}" class="btn btn-outline-primary btn-sm shadow-sm ml-1" title="{{ $textoAlterno }}">
          <i class="fas {{ $esEntrega ? 'fa-exchange-alt' : 'fa-truck' }} fa-sm"></i>
        </a>
      </div>

    </div>

    @if($esEntrega && $cotizacion)
    <div class="row mt-2 pt-2 border-top">
      <div class="col-md-7 col-lg-5">
        <div class="contenedor-autocompletado">
          <div class="input-group input-group-sm">
            <div class="input-group-prepend">
              <span class="input-group-text bg-light text-muted">
                <i class="fas fa-exchange-alt mr-1"></i> Cambiar cotización:
              </span>
            </div>
            <input type="text"
                   id="input-buscar-cotizacion-formato"
                   class="form-control"
                   placeholder="Buscar otro folio CAL, VAL, ID o cliente..."
                   autocomplete="off">
          </div>
          <div id="dropdown-cotizaciones-formato" class="dropdown-coincidencias shadow" style="display: none;"></div>
        </div>
      </div>
    </div>
    @endif
  </div>
</div>

