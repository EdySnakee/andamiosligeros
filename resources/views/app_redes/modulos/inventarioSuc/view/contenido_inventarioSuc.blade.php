{{-- CARD SECCTION --}}
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-8 col-md-12 mb-4">
            <div class="card border-left-primary shadow h-100">
                <div class="card-body">
                    <div class="row d-flex justify-content-between align-items-top px-3">
                        <h1 class="h3 mb-0 text-gray-800">{{ \Auth::User()->name }}</h1>
                        <i class="fas fa-map-marker-alt fa-2x text-sky-300"></i>
                    </div>
                    <div class="row d-flex justify-content-between mt-3">
                        <div class="col">
                            <div class="text-md font-weight-bold text-primary text-uppercase mb-1">ANDAMIOS</div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $cantidad_andamios }}<span
                                    class="ml-1 font-weight-normal">pz</span></div>
                        </div>
                        <div class="col">
                            <div class="text-md font-weight-bold text-primary text-uppercase mb-1">ACCESORIOS</div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $cantidad_accesorios }}<span
                                    class="ml-1 font-weight-normal">pz</span></div>
                        </div>
                        <div class="col">
                            <div class="text-md font-weight-bold text-primary text-uppercase mb-1">COSTO</div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totales_sucursal, 2, '.', ',') }}
                                <span class="font-weight-normal">mxn</span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="fecha-actualizacion">Última actualización: <b>{{ $fecha_actual }}</b></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- TABLA SECCTION -->
<div class="container-fluid">
    <div class="col-lg-12 m-2">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row align-items-center">
                    <!-- Título -->
                    <div class="col-md-4 col-sm-12">
                        <h4 class="m-0 font-weight-bold text-primary">Inventario</h4>
                    </div>

                    <!-- Select Categoría -->
                    <div class="col-md-4 col-sm-12">
                        <label class="mb-1" for="change-category">Categoría</label>
                        <select id="change-category" class="form-control" onchange="filtroCategoria()" required>
                            <option value="" disabled selected>Selecciona una categoría</option>
                            <option value="andamio">MODELOS ANDAMIOS</option>
                            <option value="accesorio">ACCESORIOS</option>
                        </select>
                        <div class="invalid-feedback">
                            Por favor selecciona una categoría válida.
                        </div>
                    </div>

                    <!-- Botón a la derecha -->
                    <div class="col-md-4 col-sm-12 text-md-right mt-3 mt-md-0">
                        @if (\Auth::User()->id !== 26)
                        {{-- Botón de ENTRADA (Nuevo) --}}
                        <button id="open_modal_entrada"
                            class="btn btn-md btn-success shadow rounded-pill px-4 py-2 font-weight-bold transition-all mr-2">
                            <i class="fas fa-arrow-down mr-2"></i> ENTRADA
                        </button>

                        {{-- Botón de SALIDA (Existente) --}}
                        <button id="open_modal_salida"
                            class="btn btn-md btn-danger shadow rounded-pill px-4 py-2 font-weight-bold transition-all">
                            <i class="fas fa-arrow-up mr-2"></i> SALIDA
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive mt-3">
                    <table class="table table-bordered inventory-table" width="100%" cellspacing="0"
                        style="text-align:center;">
                        <thead>
                            <tr>
                                <th>Modelo</th>
                                <th>Descripción</th>
                                <th>Categoria</th>
                                <th>Stock</th>
                                <th>Disponibilidad</th>
                            </tr>
                        </thead>
                        <tbody id="tabla_inventario">
                            @if (!$inventario_sucursal->isEmpty())
                            @foreach ($inventario_sucursal as $item)
                            <tr class="accordion-toggle info-inventario">

                                @if ($item->tipo_producto === 'andamio')
                                <td>
                                    {{ $item->nombre_modelo }}
                                </td>
                                <td>
                                    {{ $item->desc_modelo }}
                                </td>
                                @elseif ($item->tipo_producto === 'accesorio')
                                <td>
                                    {{ $item->nombre_accesorio }}
                                </td>
                                <td>
                                    {{ $item->desc_accesorio }}
                                </td>
                                @endif

                                <td>
                                    {{ $item->tipo_producto }}
                                </td>
                                <td>
                                    {{ $item->cantidad }}
                                </td>
                                <td>
                                    <div class="progress-wrapper">
                                        <div class="progress-label">
                                            {{ $item->cantidad > 0 ? 'Disponible' : 'Agotado' }}
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar {{ $item->cantidad <= 5 ? 'low-stock' : '5' }} {{ $item->cantidad <= 1 ? 'no-stock' : '' }}"
                                                role="progressbar"
                                                style="width: {{ min(($item->cantidad / 45) * 100, 100) }}%;"
                                                aria-valuenow="{{ $item->cantidad }}" aria-valuemin="0"
                                                aria-valuemax="500">
                                                {{ $item->cantidad }} pz
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="10" class="text-center">
                                    <h2>No hay productos en inventario para esta sucursal</h2>
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td colspan="10">
                                    Total de productos en inventario: {!! $inventario_sucursal->count() !!}
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>