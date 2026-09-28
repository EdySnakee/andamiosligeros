@include('app_redes.modulos.caja_chica.modal.modal_caja_chica')

<div class="container-fluid">
    <div class="row">
        <!-- Resumen Caja Chica -->
        <div class="col-xl-8 col-md-12">
            <div class="card border-left-primary shadow h-100">
                <div class="card-body">
                    <!-- Título del módulo -->
                    <div class="row d-flex justify-content-between align-items-center px-3">
                        <h1 class="h3 mb-0 text-gray-800">{{ \Auth::User()->name }}</h1>
                        <i class="fas fa-wallet fa-2x text-primary"></i>
                    </div>

                    <!-- Resumen de Caja Chica -->
                    <div class="row d-flex justify-content-between mt-3">
                        <div class="col-md-4 col-sm-12 mb-3">
                            <div class="text-md font-weight-bold text-primary text-uppercase mb-1">Saldo Actual</div>
                            <div id="saldo" class="h3 mb-0 font-weight-bold text-gray-800">${{ $saldo }}<span
                                    class="font-weight-normal">mxn</span></div>
                        </div>

                        <div class="col-md-4 col-sm-12 mb-3">
                            <div class="text-md font-weight-bold text-success text-uppercase mb-1">Ingresos</div>
                            <div id="ingresos" class="h3 mb-0 font-weight-bold text-gray-800">${{ $ingresos }}
                                <span class="font-weight-normal">mxn</span>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12 mb-3">
                            <div class="text-md font-weight-bold text-danger text-uppercase mb-1">Gastos</div>
                            <div id="gastos" class="h3 mb-0 font-weight-bold text-gray-800">${{ $gastos }}
                                <span class="font-weight-normal">mxn</span>
                            </div>
                        </div>
                    </div>

                    <!-- Botones para agregar ingresos o gastos -->
                    <div class="text-center mt-4">
                        <button class="btn btn-success btn-lg rounded mr-3" data-toggle="modal"
                            data-target="#modalMovimiento" data-tipo="ingreso">
                            <i class="fas fa-plus"></i> Ingreso
                        </button>
                        <button class="btn btn-danger btn-lg rounded ml-3" data-toggle="modal"
                            data-target="#modalMovimiento" data-tipo="gasto">
                            Gasto <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detalles de Movimientos Recientes -->
        <div class="col-xl-4 col-md-12">
            <div class="card border-left-info shadow h-100">
                <div class="card-body">
                    <h5 class="text-info font-weight-bold">Movimientos Recientes</h5>
                    <ul id="movRecientes" class="list-group">
                        @foreach ($movRecientes as $movimiento)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ \Illuminate\Support\Str::limit($movimiento->descripcion, 35, '...') }}
                                <span
                                    class="badge badge-pill {{ $movimiento->tipo_movimiento === 'ingreso' ? 'badge-success' : 'badge-danger' }}">
                                    {{ $movimiento->tipo_movimiento === 'ingreso' ? '+' : '-' }}${{ number_format($movimiento->monto, 2) }}
                                    MXN
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- TABLA SECTION -->
<div class="container-fluid">
    <div class="col-lg-12 m-2">
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between">
                <div>
                    <h5 class="m-0 font-weight-bold text-primary">Historial</h5>
                </div>
                @if (\Auth::User()->id == 2 || \Auth::User()->id == 14 || \Auth::User()->id == 29)
                    <!-- Select para elegir usuario -->
                    <div class="">
                        <label for="usuarioSelect">Seleccionar Usuario</label>
                        <select id="usuarioSelect" class="form-control" onchange="actualizarCajaChica()">
                            <option value="" disabled selected>Selecciona Caja chica</option>
                            @foreach ($usuarios as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Inputs para fechas de filtro -->
                    <div class="row">
                        <div class="col-md-6">
                            <label for="fechaInicio">Fecha Inicio:</label>
                            <input type="date" id="fechaInicio" class="form-control" value="{{ date('Y-m-01') }}"
                                onchange="filtrarPorFechas()">
                        </div>
                        <div class="col-md-6">
                            <label for="fechaFin">Fecha Fin:</label>
                            <input type="date" id="fechaFin" class="form-control" value="{{ date('Y-m-t') }}"
                                onchange="filtrarPorFechas()">
                        </div>
                    </div>
                @endif
                <!-- Última actualización -->
                <div class="fecha-actualizacion text-muted">Última actualización:
                    <b>{{ \Carbon\Carbon::now()->format('d/m/Y') }}</b>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered caja-chica-table" width="100%" cellspacing="0"
                        style="text-align:center;">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Concepto</th>
                                <th>Monto</th>
                                <th>Tipo</th>
                                @if (\Auth::User()->id == 2)
                                    <th>Acción</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody id="tabla_caja_chica" class="scrollable-tbody">
                            @foreach ($historial as $movimiento)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($movimiento->fecha)->format('d/M/Y h:i A') }}</td>
                                    <td style="text-transform: uppercase;">{{ $movimiento->descripcion }}</td>
                                    <td>
                                        <span class="font-weight-bold ">
                                            ${{ number_format($movimiento->monto, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span style="text-transform: uppercase;"
                                            class="{{ $movimiento->tipo_movimiento === 'ingreso' ? 'text-success' : 'text-danger' }}">
                                            {{ ucfirst($movimiento->tipo_movimiento) }}
                                        </span>
                                    </td>
                                    @if (\Auth::User()->id == 2)
                                        <td>
                                            <button title="Editar" class="btn rounded-circle btn-sm editar-movimiento"
                                                data-toggle="modal" data-target="#modalMovimiento"
                                                data-id="{{ $movimiento->id }}" data-fecha="{{ $movimiento->fecha }}"
                                                data-descripcion="{{ $movimiento->descripcion }}"
                                                data-monto="{{ $movimiento->monto }}"
                                                data-comprobante="{{ $movimiento->comprobante }}"
                                                data-tipo="{{ $movimiento->tipo_movimiento }}"
                                                data-id_usuario = "{{ $movimiento->user_id }}"
                                                >
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="6" class="text-center">
                                    {!! $historial->links() !!}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
