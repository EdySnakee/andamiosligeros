<div class="container-fluid">
    <!-- Page Heading -->
    @if ($accion == 'agregar')
    <h1 class="h3 mb-2 text-gray-800" id="accion" data-accion="agregar">Cotizador</h1>
    @elseif($accion == 'editar')
    <h1 class="h3 mb-2 text-gray-800" id="accion" data-accion="editar">Editar cotización
        {{ $info_cotizacion->cod_cotizacion }}
    </h1>
    @endif

    <!-- DataTales Example -->
    <div class="row">
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4 no-padding">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Parametros de cotización</h6>
                </div>
                <div class="card-body">
                    {{--
            <div class="form-group row">
              <label for="tipo_cotizacion" class="col-sm-12 col-form-label">Elige que vas a cotizar 
                @if ($accion == 'agregar')
                  <small class="pull-right"><a href="" id="refresh_coti" data-accion-cliente ="agregar"><i class="fas fa-sync-alt"></i> Cancelar</a></small>
                @elseif($accion == "editar")
                @endif
              </label>
              <div class="col-sm-12">
                @if ($accion == 'agregar')
                  <select class="form-control js-example-basic-single" id="tipo_cotizacion" placeholder="Giro" >
                    @if (!$giroEmpresas->isEmpty())
                      <option disabled selected>Selecciona un Giro</option>
                      @foreach ($giroEmpresas as $item_giro)
                        <option value="{{$item_giro->cod_giro}}">{{$item_giro->nombre_empresa}}</option>
                    @endforeach
                    @else
                    <option disabled selected>Sin empresas</option>
                    @endif
                    </select>
                    @elseif($accion == "editar")
                    <select class="form-control js-example-basic-single" id="tipo_cotizacion" placeholder="Giro" disabled>
                        @if (isset($giroEmpresas) and !$giroEmpresas->isEmpty())
                        @foreach ($giroEmpresas as $item_giro)
                        @if ($info_cotizacion->giro_empresa == $item_giro->cod_giro)
                        <option value="{{$item_giro->cod_giro}}" selected>{{$item_giro->nombre_empresa}}</option>
                        @else
                        <option value="{{$item_giro->cod_giro}}">{{$item_giro->nombre_empresa}}</option>
                        @endif
                        @endforeach
                        @endif
                    </select>
                    @endif
                </div>
            </div>
            --}}
            <div class="form-group mb-4">
                <label class="text-primary" for="sucursal">Sucursal</label>
                <select style="text-transform: uppercase;" id="suc_origen" class="form-control" required>
                    <option value="" disabled selected>Selecciona una sucursal</option>
                    @foreach ($sucursales as $sucursal)
                    <option value="{{ $sucursal->id }}" data-nombre="{{ $sucursal->nombre }}">
                        {{ $sucursal->nombre }}
                    </option>
                    @endforeach
                </select>
                <label class="form-check-label mr-4" for="guardarSucursal">
                    Mantener sucursal
                </label>
                <input class="form-check-input" type="checkbox" id="guardarSucursal">
            </div>
            <div class="form-group row">
                <label for="cliente" class="col-sm-12 col-form-label">Seleccione un cliente
                    @if ($accion == 'agregar')
                    <small class="pull-right"><a href="#" id="open_add_cliente"
                            data-accion-cliente="agregar"><i class="fas fa-user-plus"></i> Agregar
                            cliente</a></small>
                    @endif
                </label>

                <div class="col-md-12">
                    <select class="form-control busca_cliente" id="search_cliente"></select>

                </div>
                {{--
              <div class="col-sm-12">
                @if ($accion == 'agregar')
                <select class="form-control busca_cliente" id="cliente" placeholder="Cliente">
                @elseif($accion == "editar")
                <select class="form-control busca_cliente" id="cliente" placeholder="Cliente" disabled>
                @endif
                @include('app_redes.modulos.extras.options_clientes')
                </select>
              </div>
              --}}
            </div>
            <div class="form-group row">
                <div class="col-md-12 mt-2">
                    <label for="tipo_cotizacion">Tipo de cotización</label>
                    <div class="row">
                        @if ($accion == 'agregar')
                        <div class="col-md-4"><label><input type="radio" class="tipo_cotizacion"
                                    name="tipo_cotizacion" value="Venta" checked> Venta</label></div>
                        <div class="col-md-4"><label><input type="radio" class="tipo_cotizacion"
                                    name="tipo_cotizacion" value="Renta"> Renta</label></div>
                        @elseif($accion == 'editar')
                        <div class="col-md-4"><label><input type="radio" class="tipo_cotizacion"
                                    name="tipo_cotizacion" value="Venta"
                                    {{ (!empty($info_cotizacion->tipo_cotizacion) and $info_cotizacion->tipo_cotizacion == 'Venta') ? 'checked' : '' }}>
                                Venta</label></div>
                        <div class="col-md-4"><label><input type="radio" class="tipo_cotizacion"
                                    name="tipo_cotizacion" value="Renta"
                                    {{ (!empty($info_cotizacion->tipo_cotizacion) and $info_cotizacion->tipo_cotizacion == 'Renta') ? 'checked' : '' }}>
                                Renta</label></div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <label for="tipo_producto" class="col-sm-12 col-form-label">Selecciona un producto</label>
                <div class="col-sm-12">
                    @if ($accion == 'agregar')
                    <select class="form-control js-example-basic-single" id="tipo_producto"
                        placeholder="producto" disabled>
                        @if (!$productos_giro->isEmpty())
                        <option disabled selected>Selecciona un producto</option>
                        @foreach ($productos_giro as $result_productos)
                        <option value="{{ $result_productos->id_producto }}">
                            {{ $result_productos->nombre_p }}
                        </option>
                        @endforeach
                        @else
                        <option value="SC">Sin productos</option>
                        @endif
                    </select>
                    @elseif($accion == 'editar')
                    <select class="form-control js-example-basic-single" id="tipo_producto"
                        placeholder="producto">
                        @if (!$productos_giro->isEmpty())
                        <option disabled selected>Selecciona un producto</option>
                        @foreach ($productos_giro as $result_productos)
                        <option value="{{ $result_productos->id_producto }}">
                            {{ $result_productos->nombre_p }}
                        </option>
                        @endforeach
                        @else
                        <option value="SC">Sin productos</option>
                        @endif
                    </select>
                    @endif
                </div>
            </div>

            <div id="info_detalle_producto" class="row">
            </div>
            <div class="row" id="container_calculadora_tarimas" style="display: none; margin-top: 15px;">
                <div class="col-md-12">
                    <div class="card shadow-sm border-left-primary">
                        <div class="card-header py-2 d-flex flex-row align-items-center justify-content-between bg-gray-100">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-calculator"></i> Calculadora: Tarimas y Uniones
                            </h6>
                            <button type="button" class="close" id="btn_cerrar_calc" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label font-weight-bold">Forma del Área:</label>
                                <div class="col-sm-9">
                                    <select id="calc_forma" class="form-control">
                                        <option value="rectangulo">Rectangular / Cuadrada</option>
                                        <option value="compuesta">T o L (Suma de 2 secciones)</option>
                                        <option value="manual">Solo Área (Manual)</option>
                                    </select>
                                </div>
                            </div>

                            <div id="inputs_geometria">
                                <div class="grupo-input shape-rectangulo row">
                                    <div class="col-md-6">
                                        <label>Largo (metros)</label>
                                        <input type="number" step="0.01" class="form-control calc-input" id="calc_largo_1" placeholder="0.00">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Ancho (metros)</label>
                                        <input type="number" step="0.01" class="form-control calc-input" id="calc_ancho_1" placeholder="0.00">
                                    </div>
                                </div>

                                <div class="grupo-input shape-compuesta row" style="display:none;">
                                    <div class="col-md-12"><h6 class="text-secondary border-bottom">Sección 1</h6></div>
                                    <div class="col-md-6">
                                        <label>Largo A (m)</label>
                                        <input type="number" step="0.01" class="form-control calc-input" id="calc_largo_a">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Ancho A (m)</label>
                                        <input type="number" step="0.01" class="form-control calc-input" id="calc_ancho_a">
                                    </div>
                                    <div class="col-md-12 mt-3"><h6 class="text-secondary border-bottom">Sección 2 (a sumar)</h6></div>
                                    <div class="col-md-6">
                                        <label>Largo B (m)</label>
                                        <input type="number" step="0.01" class="form-control calc-input" id="calc_largo_b">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Ancho B (m)</label>
                                        <input type="number" step="0.01" class="form-control calc-input" id="calc_ancho_b">
                                    </div>
                                </div>

                                <div class="grupo-input shape-manual row" style="display:none;">
                                    <div class="col-md-12">
                                        <div class="alert alert-warning py-2" style="font-size: 0.9em;">
                                            <i class="fas fa-exclamation-triangle"></i> En modo manual no se pueden calcular las coronas automáticamente.
                                        </div>
                                        <label>Área Total (m²)</label>
                                        <input type="number" step="0.01" class="form-control calc-input" id="calc_area_manual">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-md-6 border-right">
                                    <h5 class="text-success font-weight-bold">Tarimas: <span id="res_tarimas_final">0</span> Piezas</h5>
                                    <small class="text-muted">Área: <span id="res_area_total">0.00</span> m²</small>
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-success btn-block" id="btn_usar_cantidad">
                                            <i class="fas fa-check-circle"></i> Usar Cantidad
                                        </button>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h5 class="text-warning font-weight-bold" style="color: #fd7e14 !important;">Coronas: <span id="res_coronas_final">0</span> Piezas</h5>
                                    <small class="text-muted visibility-hidden">Añade directo a la cotización</small>
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-warning btn-block text-white" id="btn_usar_coronas" style="background-color: #fd7e14; border-color: #fd7e14;">
                                            <i class="fas fa-plus-circle"></i> Agregar Coronas
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row" style="margin-top: 1em;">
                <div class="col-sm-12">
                    <button type="submit" id="add_concepto" class="btn btn-primary float-right"
                        disabled>Agregar servicio</button>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-12">
                        <p>Tipo de descuento:</p>
                        <ul class="opc-desc">
                            <li><label><input type="radio" class="t_descuento" name="t_descuento"
                                        value="Porcentual"
                                        {{ (!empty($info_cotizacion->t_descuento) and $info_cotizacion->t_descuento == 'Porcentual') ? 'checked' : '' }}>
                                    Porcentual</label></li>
                            <li><label><input type="radio" class="t_descuento" name="t_descuento"
                                        value="Fijo"
                                        {{ (!empty($info_cotizacion->t_descuento) and $info_cotizacion->t_descuento == 'Fijo') ? 'checked' : '' }}>
                                    Fijo</label></li>
                        </ul>
                    </div>
                </div>

                <div class="row mb-10">
                    <div class="col-sm-6">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><span id="simbolo_desc">%</span></div>
                            </div>
                            @if ($accion == 'editar')
                            @if ($info_cotizacion->t_descuento == 'Porcentual')
                            <input type="number" class="form-control" id="descuento"
                                placeholder="Descuento"
                                value="{{ (!empty($info_cotizacion->descuento) and $info_cotizacion->descuento != 0) ? $info_cotizacion->descuento : '' }}"
                                {{ $accion == 'agregar' ? 'disabled' : '' }}>
                            @elseif($info_cotizacion->t_descuento == 'Fijo')
                            <input type="number" class="form-control" id="descuento"
                                placeholder="Descuento"
                                value="{{ (!empty($info_cotizacion->descuento_aplicado) and $info_cotizacion->descuento_aplicado != 0) ? $info_cotizacion->descuento_aplicado : '' }}"
                                {{ $accion == 'agregar' ? 'disabled' : '' }}>
                            @else
                            <input type="number" class="form-control" id="descuento"
                                placeholder="Descuento" value=""
                                {{ $accion == 'agregar' ? 'disabled' : '' }}>
                            @endif
                            @else
                            <input type="number" class="form-control" id="descuento"
                                placeholder="Descuento" value=""
                                {{ $accion == 'agregar' ? 'disabled' : '' }}>
                            @endif


                        </div>
                    </div>
                    <div class="col-sm-6">
                        <button class="btn btn-info float-right" id="add_descuento"
                            {{ $accion == 'agregar' ? 'disabled' : '' }}>Aplicar descuento</button>
                    </div>
                </div>

                <div class="row mb-10">
                    <div class="col-sm-8">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-truck"></i></div>
                            </div>
                            <input type="number" class="form-control" id="precio_envio"
                                placeholder="Costo envío"
                                value="{{ (!empty($info_cotizacion->envio) and $info_cotizacion->envio != 0) ? $info_cotizacion->envio : '' }}">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <button class="btn btn-info float-right" id="add_envio">Agregar envío</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="body-info-cliente mt-20 ">
                            <label class="checkbox-toggle">
                                @if ($accion == 'agregar')
                                <input type="checkbox" name="iva" checked id="activa_iva"
                                    value="iva">
                                <i></i>
                                Incluir IVA
                                @elseif($accion == 'editar')
                                @if ($info_cotizacion->iva != 0)
                                <input type="checkbox" name="iva" checked id="activa_iva"
                                    value="iva">
                                <i></i>
                                Incluir IVA
                                @else
                                <input type="checkbox" name="iva" id="activa_iva"
                                    value="iva">
                                <i></i>
                                Incluir IVA
                                @endif
                                @endif
                            </label>

                        </div>

                    </div>
                    {{--

                <div class="col-md-12">
                  <label class="checkbox-toggle">
                    @if ($accion == 'agregar')
                      <input type="checkbox" name="iva" checked id="activa_envio">
                      <i></i>
                      Incluir Envío 
                    @elseif($accion == "editar")
                      @if ($info_cotizacion->envio != 0)
                        <input type="checkbox" name="envio" checked id="activa_envio">
                        <i></i>
                        Incluir Envío 
                      @else
                        <input type="checkbox" name="envio" id="activa_envio">
                        <i></i>
                        Incluir Envío 
                      @endif
                    @endif
                  </label><br>
                </div>
                     --}}

                </div>
            </div>
        </div>
    </div>

    {{-- CONDICIONES DE COTIZACIONES --}}
    <div class="card shadow mb-4 no-padding">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Condiciones de cotización</h6>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div id="datos_condicion">
                    @if (!empty($condiciones_cotizacion))
                    {{-- <p> {{ $condiciones_cotizacion }} </p> --}}
                    <?php print_r(!empty($condiciones_cotizacion) ? $condiciones_cotizacion : ''); ?>
                    @else
                    {{-- {{ !empty($datos_condicion) ? $datos_condicion : '' }} --}}
                    <?php print_r(!empty($datos_condicion) ? $datos_condicion : ''); ?>
                    @endif
                </div>
                <button class="btn btn-primary rounded" id="open_edit_condiciones"
                    data-accion-condicion="agregar"><i class="fas fa-edit"></i>
                </button>
            </div>
        </div>
    </div>
    {{-- FIN CONDICIONES --}}

</div>

{{-- Vista previa de cotización --}}
<div class="col-xl-8 col-lg-7">
    <div class="card shadow mb-4  no-padding">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Vista previa de cotización</h6>
        </div>
        <div class="card-body">
            @include('app_redes.modulos.cotizador.crea_cotizacion.formato_cotizacion.formato_andamisligeros')
        </div>
    </div>
</div>
</div>

</div>