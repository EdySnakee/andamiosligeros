<?php
use App\SeguimientoTrabajo;
use App\SeguimientoBitacora;
use App\DetalleCotizaciones;
$objDetCotizacion = new DetalleCotizaciones();
?>
@if (!$listado_cotizaciones->isEmpty())
    @foreach ($listado_cotizaciones as $result_coti)
        <tr class="accordion-toggle info-cotizacion">

            <td style="text-align: center;">
                <button data-toggle="collapse" data-target="#collapse{{ $result_coti->id_cotizacion }}"
                    class="btn btn-secondary btn-sm" aria-expanded="false"
                    aria-controls="{{ $result_coti->id_cotizacion }}">+</button>
            </td>
            <td>
                <a target="_blank"
                    href="{{ url('cotizaciones/andamios-ligeros') . '/' . $result_coti->ruta_encrypt }}">{{ $result_coti->cod_cotizacion }}<i
                        class="fas fa-share-square"></i>{{ (!empty($result_coti->tipo_cotizacion) and $result_coti->tipo_cotizacion == 'Renta') ? '(' . $result_coti->tipo_cotizacion . ')' : '' }}</a>
            </td>
            <td style="text-align:left;">
                {{ $result_coti->nombrecl }} <a href="#" id="open_edit" id-cliente="{{ $result_coti->idcl }}"><i
                        class="fas fa-user-edit"></i></a>
            </td>
            @if ($result_coti->id_sucursal == 3)
                {{-- sucursal CDMX --}}
                <td>
                    <a target="_blank"
                        href="https://andamiosligeroscdmx.kommo.com/chats/leads/detail/{{ $result_coti->lead }}">{{ $result_coti->lead }}</a>
                </td>
            @elseif ($result_coti->id_sucursal == 2)
                {{-- sucursal MID --}}
                <td>
                    <a target="_blank"
                        href="https://andamiosligerosmid.kommo.com/chats/leads/detail/{{ $result_coti->lead }}">{{ $result_coti->lead }}</a>
                </td>
            @elseif ($result_coti->id_sucursal == 5)
                {{-- sucursal GDL --}}
                <td>
                    <a target="_blank"
                        href="https://andamiosligerosgdl.kommo.com/chats/leads/detail/{{ $result_coti->lead }}">{{ $result_coti->lead }}</a>
                </td>
            @else
                {{-- sucursal MTY --}}
                <td>
                    <a target="_blank"
                        href="https://andamiosligerosmty.kommo.com/chats/leads/detail/{{ $result_coti->lead }}">{{ $result_coti->lead }}</a>
                </td>
            @endif
            <td>
                @if ($result_coti->id_sucursal == 1)
                    <span class="status bg-gradient-info text-white shadow">
                        MTY
                    </span>
                @elseif($result_coti->id_sucursal == 3)
                    <span class="status bg-gradient-success text-white shadow">
                        CDMX
                    </span>
                @elseif($result_coti->id_sucursal == 5)
                    <span class="status bg-gradient-warning text-white shadow">
                        GDL
                    </span>
                @elseif($result_coti->id_sucursal == 2)
                    <span class="status bg-gradient-primary text-white shadow">
                        MID
                    </span>
                @else
                    <span class="status bg-danger text-white shadow">
                        s/suc
                    </span>
                @endif
            </td>
            <td>{{ $result_coti->fecha_formato }}</td>
            <td>
                <b class="text-black">$ {{ number_format($result_coti->total, 2, '.', ',') }}</b>

                @if ($result_coti->t_descuento == 'Fijo' and $result_coti->descuento_aplicado != 0)
                    <div class="porcent"> <span>-$ {{ $result_coti->descuento_aplicado }}</span></div>
                @endif
                @if ($result_coti->t_descuento == 'Porcentual' and $result_coti->descuento != 0)
                    <div class="porcent"> <span>-{{ $result_coti->descuento }}% </span></div>
                @endif
            </td>
            <td>
                @if ($result_coti->status == 1)
                    <span class="status bg-gradient-info text-white shadow">
                        Activo
                    </span>
                @elseif($result_coti->status == 3)
                    <span class="status bg-gradient-success text-white shadow">
                        Aceptada
                    </span>
                @elseif($result_coti->status == 5)
                    <span class="status bg-gradient-warning text-white shadow">
                        Vencida
                    </span>
                @elseif($result_coti->status == 6)
                    <span class="status bg-gradient-primary text-white shadow">
                        Facturado
                    </span>
                @else
                    <span class="status bg-secondary text-white shadow">
                        Inactivo
                    </span>
                @endif
            </td>
            <td>
                @php
                    if ($result_coti->mp_status == 'si') {
                        $ischecked = 'checked';
                    } else {
                        $ischecked = '';
                    }
                @endphp

                @if ($result_coti->status == 1)
                    <label class="checkbox-toggle">
                        <input type="checkbox" id="activa_mp" class="activado{{ $result_coti->id_cotizacion }}"
                            data-id-coti="{{ $result_coti->id_cotizacion }}" {{ $ischecked }}>
                        <i></i>
                    </label>
                @endif

                @if ($result_coti->status == 2)
                    <label class="checkbox-toggle disabled">
                        <input type="checkbox" id="activa_mp" class="activado{{ $result_coti->id_cotizacion }}"
                            data-id-coti="{{ $result_coti->id_cotizacion }}" {{ $ischecked }} disabled="disabled">
                        <i></i>
                    </label>
                @endif
                @if ($result_coti->status == 3)
                    <label class="checkbox-toggle aceptada">
                        <input type="checkbox" id="activa_mp" class="activado{{ $result_coti->id_cotizacion }}"
                            data-id-coti="{{ $result_coti->id_cotizacion }}" {{ $ischecked }} disabled="disabled">
                        <i></i>
                    </label>
                @endif
                @if ($result_coti->status == 4 or $result_coti->status == 5 or $result_coti->status == 6)
                    <label class="checkbox-toggle pendiente">
                        <input type="checkbox" id="activa_mp" class="activado{{ $result_coti->id_cotizacion }}"
                            data-id-coti="{{ $result_coti->id_cotizacion }}" {{ $ischecked }} disabled="disabled">
                        <i></i>
                    </label>
                @endif
            </td>
            <td>
                {{ $result_coti->name }}
            </td>
            <td style="display: none">
                <a target="_blank"
                    href="{{ url('cotizaciones/andamios-ligeros') . '/' . $result_coti->ruta_encrypt }}">{{ $result_coti->cod_cotizacion }}<i
                        class="fas fa-share-square"></i></a>
            </td>
            <td>
                <div class="btn-group">
                    <a href="#" class="btn btn-facebook dropdown-toggle" data-toggle="dropdown"
                        aria-expanded="false">Acción <span class="caret"></span></a>
                    <ul class="dropdown-menu" id="prospecto-menu">
                        @if ($result_coti->status == 1)
                            <li><a class="btn btn-primary col-md-12 btn-dropdown-fix"
                                    href="{{ route('app_redes_edita_cotizaciones', $result_coti->id_cotizacion) }}">Editar</a>
                            </li>
                            <li><a id="open_confirm_venta" data-id-coti="{{ $result_coti->id_cotizacion }}"
                                    class="btn btn-success col-md-12 btn-dropdown-fix" href="#">Realizar Venta</a>
                            </li>
                            @if ($result_coti->qr_status == 1)
                            @elseif($result_coti->qr_status == 0)
                                <li><a id="genera_qr" class="btn btn-info col-md-12 btn-dropdown-fix" href="#"
                                        data-id-coti="{{ $result_coti->id_cotizacion }}">Generar QR</a></li>
                            @endif
                        @elseif($result_coti->status == 3)
                            <li>
                                <a class="btn col-md-12 btn-dropdown-fix"
                                    href="{{ url('sb-admin/seguimineto') }}/{{ $result_coti->id_cotizacion }}">
                                    Realizar seguimiento</a>
                            </li>
                        @endif

                        @if ($result_coti->status == 1 or $result_coti->status == 3)
                            <li>
                                @if ($result_coti->giro_empresa == 'ra')
                                    <a class="btn btn-info col-md-12 btn-dropdown-fix" target="_blank"
                                        href="{{ url('pdf/redes-anticaidas/') }}/{{ $result_coti->ruta_encrypt }}">
                                        Descargar PDF</a>
                                @elseif($result_coti->giro_empresa == 'rp')
                                    <a class="btn btn-info col-md-12 btn-dropdown-fix" target="_blank"
                                        href="{{ url('pdf/redes-perimetrales/') }}/{{ $result_coti->ruta_encrypt }}">
                                        Descargar PDF</a>
                                @elseif($result_coti->giro_empresa == 'sg')
                                    <a class="btn btn-info col-md-12 btn-dropdown-fix" target="_blank"
                                        href="{{ url('pdf/score-gol/') }}/{{ $result_coti->ruta_encrypt }}"> Descargar
                                        PDF</a>
                                @elseif($result_coti->giro_empresa == 'al')
                                    <a class="btn btn-info col-md-12 btn-dropdown-fix" target="_blank"
                                        href="{{ url('pdf/andamios-ligeros/') }}/{{ $result_coti->ruta_encrypt }}">
                                        Descargar PDF</a>
                                @endif
                            </li>
                            <li class="divider">
                                <hr>
                            </li>
                            <li>
                                <input type="submit" name="confirm_desactiva_cliente" id="confirm_desactiva_cliente"
                                    data-id-coti="{{ $result_coti->id_cotizacion }}" value="Desactivar"
                                    class="btn btn-warning col-md-12 btn-dropdown-fix">
                            </li>
                        @else
                            <li>
                                <input type="submit" name="confirm_activa_cliente" id="confirm_activa_cliente"
                                    data-id-coti="{{ $result_coti->id_cotizacion }}" value="Activar"
                                    class="btn btn-success col-md-12 btn-dropdown-fix">
                            </li>
                            <li class="divider">
                                <hr>
                            </li>
                            <li>
                                <input type="submit" name="confirm_elimina_cliente" id="confirm_elimina_cliente"
                                    data-id-coti="{{ $result_coti->id_cotizacion }}" value="Eliminar"
                                    class="btn btn-danger col-md-12 btn-dropdown-fix">
                            </li>
                        @endif
                    </ul>
                </div>
            </td>
        </tr>
        <tr class="info-det-coti">
            <td></td>
            <td colspan="9">
                <div class=" collapse" id="collapse{{ $result_coti->id_cotizacion }}">
                    <table class="table table-bordered" id="tabla_productos" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">CANTIDAD</th>
                                <th class="text-center" width="35%">PRODUCTO</th>
                                <th class="text-center" width="20%">PRECIO UNITARIO</th>
                                <th class="text-right" width="20%">SUBTOTAL</th>
                            </tr>
                        </thead>
                        <tbody id="detalle_cotizacion">
                            @php
                                $det_coti = $objDetCotizacion
                                    ->where('id_cotizacion', $result_coti->id_cotizacion)
                                    ->get();
                            @endphp
                            @if (!$det_coti->isEmpty())
                                @foreach ($det_coti as $item_det_serv)
                                    <tr class="fila-det-servicio">
                                        <td class="text-center">{{ $item_det_serv->cantidad }}</td>
                                        <td class="text-center">{{ $item_det_serv->nombre_producto }}</td>
                                        <td class="text-center">$
                                            {{ number_format($item_det_serv->precio_unit, 2, '.', ',') }}</td>
                                        <td class="text-right">$
                                            {{ number_format($item_det_serv->total_ind, 2, '.', ',') }}</td>
                                    </tr>
                                @endforeach
                            @endif

                            @if ($result_coti->descuento_aplicado != 0)
                                <tr>
                                    <td colspan="3" class="text-right">Descuento</td>
                                    <td class="text-right">- $
                                        {{ number_format($result_coti->descuento_aplicado, 2, '.', ',') }}</td>
                                </tr>
                            @endif

                            @if ($result_coti->envio != 0)
                                <tr>
                                    <td colspan="3" class="text-right">Envío</td>
                                    <td class="text-right">$ {{ number_format($result_coti->envio, 2, '.', ',') }}
                                    </td>
                                </tr>
                            @endif

                            @if ($result_coti->subtotal != 0)
                                <tr>
                                    <td colspan="3" class="text-right">
                                        Subtotal
                                    </td>
                                    <td class="text-right">$ {{ number_format($result_coti->subtotal, 2, '.', ',') }}
                                    </td>
                                </tr>
                            @endif

                            @if ($result_coti->iva != 0)
                                <tr>
                                    <td colspan="3" class="text-right">IVA</td>
                                    <td class="text-right">
                                        $ {{ number_format($result_coti->iva, 2, '.', ',') }}
                                    </td>
                                </tr>
                            @endif

                            @if ($result_coti->total != 0)
                                <tr>
                                    <td colspan="3" class="text-right">TOTAL</td>
                                    <td class="text-right">
                                        <h6 class="text-black"><b>$
                                                {{ number_format($result_coti->total, 2, '.', ',') }}</b></h6>
                                    </td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="10" class="text-center">
            <h2>Lo sentimos pero no existen cotizaciones</h2>
        </td>
    </tr>
@endif
<tr>
    <td colspan="3">
        Total de cotizaciones: {!! $listado_cotizaciones->total() !!}
    </td>
    <td colspan="7" class="text-right">{!! $listado_cotizaciones->links() !!}</td>
</tr>
