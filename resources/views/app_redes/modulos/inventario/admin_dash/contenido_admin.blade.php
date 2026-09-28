<div class="container-fluid">
    <!-- Content Row -->
    <div class="row">
        <!-- Content Row -->
        <div class="container-fluid">
            <div class="col-lg-12 m-2">
                <div class="card shadow mb-4">

                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h4 class="m-0 font-weight-bold text-primary">
                            Inventario
                            @if (\Auth::User()->tipo_usuario == 'admin')
                                <span style="font-size: calc(1vw + 16px);" id="nombre-sucursal"> Matriz </span>
                            @else
                                <span style="font-size: calc(1vw + 16px);" id="nombre-sucursal"> {{$nombre_sucursal}}</span>
                            @endif
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <!-- Sucursal Select -->
                            @if (\Auth::User()->tipo_usuario == 'admin')
                                <div class="col-md-4 col-sm-3">
                                    <label class="tfh-label" for="change-sucursal">Sucursal</label>
                                    <select id="change-sucursal" class="form-control" onchange="cambiarSucursal()"
                                        required>
                                        <option value="" disabled>Selecciona una sucursal</option>
                                        @foreach ($sucursales as $sucursal)
                                            <option value="{{ $sucursal->id }}"
                                                data-nombre="{{ strtoupper($sucursal->nombre) }}"
                                                @if ($sucursal->id == 4) selected @endif>
                                                {{ strtoupper($sucursal->nombre) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Por favor selecciona una sucursal válida.
                                    </div>
                                </div>
                            @endif

                            @if (\Auth::user()->tipo_usuario == 'g1')
                                <!-- Input id sucursal para gerencia -->
                                <input hidden id="change-sucursal" type="id"
                                    value="{{ \Auth::user()->sucursal_id }}">
                            @endif
                            <!-- Categoria Select -->
                            <div class="col-md-3 col-sm-3">
                                <label class="tfh-label" for="change-category">Categoría</label>
                                <select id="change-category" class="form-control" onchange="filtroCategoria()" required>
                                    <option value="" disabled selected>Selecciona una categoría</option>
                                    <option value="andamio">MODELOS ANDAMIOS</option>
                                    <option value="accesorio">ACCESORIOS</option>
                                </select>
                                <div class="invalid-feedback">
                                    Por favor selecciona una categoría válida.
                                </div>
                            </div>

                            <!-- Cantidad -->
                            <div class="col-md-4 col-sm-3 text-right">
                                @include('app_redes.modulos.inventario.admin_dash.totales_inven')
                            </div>
                        </div>
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered inventory-table" width="100%" cellspacing="0"
                                style="text-align:center;">
                                <thead>
                                    <tr>
                                        <th>Modelo</th>
                                        <th>Descripción</th>
                                        <th>Costo</th>
                                        <th>Stock</th>
                                        <th>Total</th>
                                        <th>Disponibilidad</th>
                                    </tr>
                                </thead>
                                <tbody id="tabla_inventario">
                                    @include('app_redes.modulos.inventario.admin_dash.tabla_admin')
                                </tbody>
                            </table>

                        </div>
                        {{-- Entradas y salidas --}}
                        <div class="row mt-4">
                            @include('app_redes.modulos.inventario.admin_dash.movimientos')
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
