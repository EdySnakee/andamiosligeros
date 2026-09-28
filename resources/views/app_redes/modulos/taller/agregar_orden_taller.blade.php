@extends('layouts.app_redes')

@section('css')
@stop

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-cube mr-2 text-warning"></i> Nueva Orden de Taller
        </h1>
        <a href="{{ url('sb-admin/ordenes-taller') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Volver al listado
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-warning">
                Selecciona una venta aceptada para generar su Orden de Taller
            </h6>
        </div>
        <div class="card-body">
            <p class="text-muted small mb-3">
                Solo se muestran las cotizaciones <strong>aceptadas (status = 3)</strong> convertidas en venta.
            </p>
            <div class="table-responsive">
                <table class="table table-hover table-bordered" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Código Venta</th>
                            <th>Cliente</th>
                            <th>Fecha Venta</th>
                            <th>Total</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cotizaciones_aceptadas as $cot)
                        <tr>
                            <td>{{ $cot->id_cotizacion }}</td>
                            <td>
                                <span class="badge badge-success">{{ $cot->cod_venta ?? '—' }}</span>
                            </td>
                            <td>{{ $cot->nombrecl }}</td>
                            <td>{{ $cot->fecha_venta_formato ?? $cot->fecha_venta }}</td>
                            <td class="text-right">${{ number_format($cot->total, 2, '.', ',') }}</td>
                            <td class="text-center">
                                <a href="{{ url('sb-admin/orden-taller/'.$cot->id_cotizacion) }}"
                                    class="btn btn-sm btn-warning">
                                    <i class="fas fa-clipboard-list mr-1"></i> Ver Orden
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                No hay ventas aceptadas disponibles.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@stop

@section('js')
@stop