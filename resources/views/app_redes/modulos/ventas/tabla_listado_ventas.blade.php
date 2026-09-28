<?php
use App\SeguimientoTrabajo;
use App\SeguimientoBitacora;
?>
@if (!$listado_ventas->isEmpty())
    @foreach ($listado_ventas as $result_vta)
        <?php
        $datosSeguimientoTrabajo = SeguimientoTrabajo::where('id_cotizacion', $result_vta->id_cotizacion)->first();
        ?>
        <tr
            @if ($result_vta->giro_empresa == 'ra') style="background: #d4b2d387; color: black;"
  @elseif($result_vta->giro_empresa == 'al')
  style="background: #7ea7ff6e; color: black;"
  @elseif($result_vta->giro_empresa == 'sg')
  style="background: #7ec25c80; color: black;"
  @elseif($result_vta->giro_empresa == 'rp')
  style="background: #ddddddad; color: black;" @endif>

            {{-- QR (oculto visualmente, lógica intacta) --}}
            {{-- <td style="text-align: center;">
                @if ($result_vta->qr_status == 1)
                    <a href="{{ url('storage/qrs_ventas') }}/{{ $result_vta->id_venta }}.png" target="_blank"
                        style="border: 1px #cacaca solid; width: 35px; height: 35px; position: relative; display: flex; align-items: center; justify-content: center; margin: 0 auto; border-radius: 5px; background: #e0dede; box-shadow: 0px 0px 3px #cacaca;">
                        <img style="width:25px; height:25px"
                            src="{{ url('storage/qrs_ventas') }}/{{ $result_vta->id_venta }}.png" alt="">
                    </a>
                @elseif($result_vta->qr_status == 0)
                    <div
                        style="border: 1px #cacaca solid; width: 35px; height: 35px; position: relative; display: flex; align-items: center; justify-content: center; margin: 0 auto; border-radius: 5px; background: #e0dede; box-shadow: 0px 0px 3px #cacaca;">
                        <img style="width:25px; height:25px" src="{{ url('script/img/unnamed.png') }}"
                            data-toggle="tooltip" data-placement="top" alt="QR no disponible" title="QR no disponible">
                    </div>
                @endif
            </td> --}}

            <td>{{ $result_vta->cod_venta }}</td>
            <td style="text-align:left;">{{ $result_vta->nombrecl }}</td>
            <td>{{ $result_vta->fecha_venta_formato }}</td>
            {{-- Columna Impuesto (IVA) - sólo lectura --}}
            <td><?php echo "$" . number_format($result_vta->iva, 2, '.', ','); ?></td>
            <td>
                @if ($result_vta->porcentaje_descuento != 0)
                    Si
                @else
                    No
                @endif
            </td>
            <td><?php echo "$" . number_format($result_vta->total, 2, '.', ','); ?></td>
            <td><?php echo "$" . number_format($result_vta->envio, 2, '.', ','); ?></td>
            <td>
                @if ($result_vta->status == 3)
                    <span class="status bg-gradient-warning shadow">
                        <small>Pendiente</small>
                    </span>
                @elseif($result_vta->status == 2)
                    @if (!empty($datosSeguimientoTrabajo))
                        <?php
                        $datosSeguimientoBitacora = SeguimientoBitacora::where('id_seguimiento', $datosSeguimientoTrabajo->id_seguimiento)->get();
                        ?>
                        <span class="status bg-gradient-success shadow">
                            <small>
                                <span style="background:white;color: #0c0c0c;padding: 0px 4px;border-radius: 50%;"><b><?php echo count($datosSeguimientoBitacora); ?></b></span>
                                Iniciado
                            </small>
                        </span>
                    @endif
                @elseif($result_vta->status == 5)
                    <span class="status shadow" style="background: #1a3a5c !important; color: #fff !important;">
                        <small style="color:#fff;">Enviado</small>
                    </span>
                @elseif($result_vta->status == 4)
                    <span class="status bg-gradient-info shadow">
                        <small>Terminado</small>
                    </span>
                @endif
            </td>

            {{-- Envío Paquetería --}}
            <td>
                @if (!empty($result_vta->envio_paqueteria) && $result_vta->envio_paqueteria != 0)
                    <?php echo "$" . number_format($result_vta->envio_paqueteria, 2, '.', ','); ?>
                @else
                    <span style="color:#aaa;">-</span>
                @endif
            </td>

            {{-- Paquetería --}}
            <td>
                @if (!empty($result_vta->paqueteria))
                    {{ $result_vta->paqueteria }}
                @else
                    <span style="color:#aaa;">-</span>
                @endif
            </td>

            {{-- Fecha Envío Paquetería (dd/mm/yy) --}}
            <td>
                @if (!empty($result_vta->fecha_envio_paqueteria))
                    {{ \Carbon\Carbon::parse($result_vta->fecha_envio_paqueteria)->format('d/m/y') }}
                @else
                    <span style="color:#aaa;">-</span>
                @endif
            </td>

            {{-- Origen --}}
            <td>
                @if (!empty($result_vta->origen))
                    {{ $result_vta->origen }}
                @else
                    <span style="color:#aaa;">-</span>
                @endif
            </td>

            {{-- Destino --}}
            <td>
                @if (!empty($result_vta->destino))
                    {{ $result_vta->destino }}
                @else
                    <span style="color:#aaa;">-</span>
                @endif
            </td>

            <td>
                {{ !empty($result_vta->name) ? $result_vta->name : $result_vta->id_usuario_genera }}
            </td>
            <td>
                @if ($result_vta->giro_empresa == 'ra')
                    <a target="_blank"
                        href="{{ url('ventas/redes-anticaidas/') }}/{{ $result_vta->ruta_encrypt }}">../{{ $result_vta->cod_venta }}</a>
                @elseif($result_vta->giro_empresa == 'rp')
                    <a target="_blank"
                        href="{{ url('ventas/redes-perimetrales/') }}/{{ $result_vta->ruta_encrypt }}">../{{ $result_vta->cod_venta }}</a>
                @elseif($result_vta->giro_empresa == 'sg')
                    <a target="_blank"
                        href="{{ url('ventas/score-gol/') }}/{{ $result_vta->ruta_encrypt }}">../{{ $result_vta->cod_venta }}</a>
                @elseif($result_vta->giro_empresa == 'al')
                    <a target="_blank"
                        href="{{ url('ventas/andamios-ligeros/') }}/{{ $result_vta->ruta_encrypt }}">../{{ $result_vta->cod_venta }}</a>
                @endif
            </td>
            <td>
                <div class="btn-group">
                    <a href="#" class="btn btn-facebook dropdown-toggle" data-toggle="dropdown"
                        aria-expanded="false">Acción <span class="caret"></span></a>
                    <ul class="dropdown-menu" id="prospecto-menu">

                        @if ($result_vta->status == 3)
                            <li>
                                <a class="btn col-md-12 btn-dropdown-fix"
                                    style="color:#333 !important;"
                                    href="{{ url('sb-admin/seguimineto') }}/{{ $result_vta->id_cotizacion }}"> Iniciar
                                    seguimiento</a>
                            </li>
                        @elseif($result_vta->status == 2)
                            <li>
                                <a class="btn col-md-12 btn-dropdown-fix"
                                    style="color:#333 !important;"
                                    href="{{ url('sb-admin/seguimineto') }}/{{ $result_vta->id_cotizacion }}"> Ver
                                    seguimiento</a>
                            </li>
                            {{-- Finalizar Proyecto ahora solo disponible desde status 5 (Enviado) --}}
                        @elseif($result_vta->status == 5)
                            <li>
                                <a class="btn col-md-12 btn-dropdown-fix"
                                    style="color:#333 !important;"
                                    href="{{ url('sb-admin/seguimineto') }}/{{ $result_vta->id_cotizacion }}"> Ver
                                    seguimiento</a>
                            </li>
                            <li>
                                <a class="btn btn-success col-md-12 btn-dropdown-fix"
                                    data-id-vta="{{ $result_vta->id_venta }}"
                                    data-cod-venta="{{ $result_vta->cod_venta }}" id="open_finaliza_venta"
                                    href="#"> Finalizar Proyecto</a>
                            </li>
                        @elseif($result_vta->status == 4)
                            <li>
                                <a class="btn col-md-12 btn-dropdown-fix"
                                    style="color:#333 !important;"
                                    href="{{ url('sb-admin/seguimineto') }}/{{ $result_vta->id_cotizacion }}"> Ver
                                    seguimiento</a>
                            </li>
                        @endif

                        {{-- Costo de envío normal --}}
                        @if ($result_vta->envio == 0)
                            <li>
                                <a id="open_add_envio" class="btn btn-success col-md-12 btn-dropdown-fix"
                                    data-id-vent="{{ $result_vta->id_venta }}"> Agregar envío</a>
                            </li>
                        @else
                            <li>
                                <a id="open_add_envio" class="btn btn-warning col-md-12 btn-dropdown-fix"
                                 style="color:#333 !important;"
                                    data-id-vent="{{ $result_vta->id_venta }}"> Editar envío</a>
                            </li>
                        @endif

                        {{-- Envío Paquetería y Logística - Solo si Seguimiento de Venta ha iniciado (Status != 3 o tiene Bitácora) --}}
                        @if ($result_vta->status != 3 || !empty($datosSeguimientoTrabajo))
                            {{-- Envío Paquetería --}}
                            @if (empty($result_vta->envio_paqueteria) || $result_vta->envio_paqueteria == 0)
                                <li>
                                    <a id="open_add_envio_paqueteria" class="btn btn-success col-md-12 btn-dropdown-fix"
                                        style="color:#fff !important;"
                                        data-id-vent="{{ $result_vta->id_venta }}"> Agregar envío paquetería</a>
                                </li>
                            @else
                                <li>
                                    <a id="open_add_envio_paqueteria" class="btn btn-warning col-md-12 btn-dropdown-fix"
                                        style="color:#333 !important;"
                                        data-id-vent="{{ $result_vta->id_venta }}"> Editar envío paquetería</a>
                                </li>
                            @endif
    
                            {{-- Paquetería --}}
                            @if (empty($result_vta->paqueteria))
                                <li>
                                    <a id="open_add_paqueteria" class="btn btn-success col-md-12 btn-dropdown-fix"
                                        style="color:#fff !important;"
                                        data-id-vent="{{ $result_vta->id_venta }}"
                                        data-paqueteria="{{ $result_vta->paqueteria }}"> Agregar paquetería</a>
                                </li>
                            @else
                                <li>
                                    <a id="open_add_paqueteria" class="btn btn-warning col-md-12 btn-dropdown-fix"
                                        style="color:#333 !important;"
                                        data-id-vent="{{ $result_vta->id_venta }}"
                                        data-paqueteria="{{ $result_vta->paqueteria }}"> Editar paquetería</a>
                                </li>
                            @endif
    
                            {{-- Origen --}}
                            @if (empty($result_vta->origen))
                                <li>
                                    <a id="open_add_origen" class="btn btn-success col-md-12 btn-dropdown-fix"
                                        style="color:#fff !important;"
                                        data-id-vent="{{ $result_vta->id_venta }}"
                                        data-valor="{{ $result_vta->origen }}"> Agregar origen</a>
                                </li>
                            @else
                                <li>
                                    <a id="open_add_origen" class="btn btn-warning col-md-12 btn-dropdown-fix"
                                        style="color:#333 !important;"
                                        data-id-vent="{{ $result_vta->id_venta }}"
                                        data-valor="{{ $result_vta->origen }}"> Editar origen</a>
                                </li>
                            @endif
    
                            {{-- Destino --}}
                            @if (empty($result_vta->destino))
                                <li>
                                    <a id="open_add_destino" class="btn btn-success col-md-12 btn-dropdown-fix"
                                        style="color:#fff !important;"
                                        data-id-vent="{{ $result_vta->id_venta }}"
                                        data-valor="{{ $result_vta->destino }}"> Agregar destino</a>
                                </li>
                            @else
                                <li>
                                    <a id="open_add_destino" class="btn btn-warning col-md-12 btn-dropdown-fix"
                                        style="color:#333 !important;"
                                        data-id-vent="{{ $result_vta->id_venta }}"
                                        data-valor="{{ $result_vta->destino }}"> Editar destino</a>
                                </li>
                            @endif
                        @endif

                        @if ($result_vta->status == 2 or $result_vta->status == 3 or $result_vta->status == 4 or $result_vta->status == 5)
                            <li>
                                @if ($result_vta->giro_empresa == 'ra')
                                    <a class="btn btn-info col-md-12 btn-dropdown-fix" target="_blank"
                                        href="{{ url('pdfv/redes-anticaidas/') }}/{{ $result_vta->ruta_encrypt }}">
                                        Descargar PDF</a>
                                @elseif($result_vta->giro_empresa == 'rp')
                                    <a class="btn btn-info col-md-12 btn-dropdown-fix" target="_blank"
                                        href="{{ url('pdfv/redes-perimetrales/') }}/{{ $result_vta->ruta_encrypt }}">
                                        Descargar PDF</a>
                                @elseif($result_vta->giro_empresa == 'sg')
                                    <a class="btn btn-info col-md-12 btn-dropdown-fix" target="_blank"
                                        href="{{ url('pdfv/score-gol/') }}/{{ $result_vta->ruta_encrypt }}"> Descargar
                                        PDF</a>
                                @elseif($result_vta->giro_empresa == 'al')
                                    <a class="btn btn-info col-md-12 btn-dropdown-fix" target="_blank"
                                        href="{{ url('pdfv/andamios-ligeros/') }}/{{ $result_vta->ruta_encrypt }}">
                                        Descargar PDF</a>
                                @endif
                            </li>
                        @else
                            <li>
                                <input type="submit" name="confirm_activa_cliente" id="confirm_activa_cliente"
                                    data-id-coti="{{ $result_vta->id_cotizacion }}" value="Activar"
                                    class="btn btn-success col-md-12 btn-dropdown-fix">
                            </li>
                            <li class="divider">
                                <hr>
                            </li>
                            <li>
                                <input type="submit" name="confirm_elimina_cliente" id="confirm_elimina_cliente"
                                    data-id-coti="{{ $result_vta->id_cotizacion }}" value="Eliminar"
                                    class="btn btn-danger col-md-12 btn-dropdown-fix">
                            </li>
                        @endif
                    </ul>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="16" class="text-center">
            <h2>Lo sentimos pero no existen ventas</h2>
        </td>
    </tr>
@endif
<tr>
    <td colspan="3">
        Total de ventas: <span id="hidden-ventas-total" style="display:inline;">{{ $listado_ventas->total() }}</span>
    </td>
    <td colspan="13" class="text-right">{!! $listado_ventas->links() !!}</td>
</tr>
