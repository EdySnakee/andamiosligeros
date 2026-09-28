@include('app_redes.modulos.ordenes_embarque.modal.modal_ordenes_emb')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h4 class="m-1 font-weight-bold text-primary p-1">Órdenes de Embarque</h4>

                    <div class="d-flex align-items-center justify-content-between ">

                        <!-- Filtros -->
                        <form id="filtrosOrdenes" class="d-flex align-items-center">
                            <div class="form-group mr-2">
                                <label for="fecha_f" class="">Fecha embarque</label>
                                <input type="date" name="fecha_f" id="fecha_f" class="form-control">
                            </div>
                            <div class="form-group mr-2">
                                <label for="sucursal_destino" class="">Suc. Destino</label>
                                <select name="sucursal_destino" id="sucursal_destino" class="form-control">
                                    <option value="">Todos</option>
                                    @foreach ($sucursales as $sucursal)
                                        <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mr-2">
                                <label for="sucursal_origen" class="">Suc. Origen</label>
                                <select name="sucursal_origen" id="sucursal_origen" class="form-control">
                                    <option value="">Todos</option>
                                    @foreach ($sucursales as $sucursal)
                                        <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mr-2">
                                <label for="estado" class="">Status</label>
                                <select name="estado" id="estado" class="form-control">
                                    <option value="">Todos</option>
                                    <option value="pendiente">Pendiente</option>
                                    <option value="autorizada">Autorizada</option>
                                    <option value="transito">Tránsito</option>
                                    <option value="recibido">Recibido</option>
                                    <option value="completada">Completada</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-warning ml-3 mt-2 rounded-pill px-2 py-1 font-weight-bold">
                                <i class="fas fa-filter mr-2"></i>Filtrar</button>
                        </form>

                        <!-- Nueva Orden -->
                        <button onclick="openModal()"
                            class="btn btn-primary ml-3 rounded-pill px-4 py-2 font-weight-bold">
                            <i class="fas fa-plus-circle mr-2"></i> Nueva Orden
                        </button>

                    </div>
                </div>

                <div class="card-body">
                    <!-- Contenedor con scroll y altura fija para tarjetas -->
                    <div class="row" id="tarjetas_ordenes_embarque" style="max-height: 650px; overflow-y: auto;">
                        @include('app_redes.modulos.ordenes_embarque.view.tarjetas')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
