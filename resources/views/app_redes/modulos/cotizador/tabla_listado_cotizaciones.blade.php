<?php
use App\SeguimientoTrabajo;
use App\SeguimientoBitacora;
use App\DetalleCotizaciones;
$objDetCotizacion = new DetalleCotizaciones();
?>
@if (!$listado_cotizaciones->isEmpty())
    @foreach ($listado_cotizaciones as $result_coti)
        <tr class="accordion-toggle info-cotizacion">

            <td style="text-align: center; vertical-align: middle;">
                <button type="button" data-toggle="collapse" data-target="#collapse{{ $result_coti->id_cotizacion }}"
                    class="btn btn-sm btn-outline-primary btn-toggle-det" aria-expanded="false"
                    aria-controls="{{ $result_coti->id_cotizacion }}"
                    style="width: 26px; height: 26px; padding: 0; line-height: 24px; border-radius: 50%; font-size: 0.82rem; font-weight: bold; border-color: #cbd5e1; color: #0948AF;"
                    title="Ver desglose de productos">
                    <i class="fas fa-plus"></i>
                </button>
            </td>
            <td style="vertical-align: middle;">
                <a target="_blank"
                    href="{{ url('cotizaciones/andamios-ligeros') . '/' . $result_coti->ruta_encrypt }}" class="font-weight-bold" style="color: #0948AF;">
                    {{ $result_coti->cod_cotizacion }} <i class="fas fa-external-link-alt ml-1" style="font-size: 0.72rem; opacity: 0.7;"></i>
                </a>
                @if (!empty($result_coti->tipo_cotizacion) && $result_coti->tipo_cotizacion == 'Renta')
                    <span class="badge badge-warning ml-1 font-weight-bold text-dark" style="font-size: 0.68rem; padding: 2px 5px;">Renta</span>
                @endif
            </td>
            <td style="text-align:left; vertical-align: middle;">
                <span class="font-weight-bold text-dark">{{ $result_coti->nombrecl }}</span>
                <a href="#" id="open_edit" id-cliente="{{ $result_coti->idcl }}" class="text-primary ml-1" title="Editar cliente">
                    <i class="fas fa-user-edit" style="font-size: 0.85rem;"></i>
                </a>
            </td>
            <td style="vertical-align: middle;">
                @php
                    $leadSubdomain = 'andamiosligerosmty';
                    if ($result_coti->id_sucursal == 3) {
                        $leadSubdomain = 'andamiosligeroscdmx';
                    } elseif ($result_coti->id_sucursal == 2) {
                        $leadSubdomain = 'andamiosligerosmid';
                    } elseif ($result_coti->id_sucursal == 5) {
                        $leadSubdomain = 'andamiosligerosgdl';
                    }
                @endphp
                @if (!empty($result_coti->lead))
                    <a target="_blank"
                        href="https://{{ $leadSubdomain }}.kommo.com/chats/leads/detail/{{ $result_coti->lead }}" class="font-weight-bold" style="color: #17a2b8;">
                        {{ $result_coti->lead }}
                    </a>
                @else
                    <span class="text-muted">—</span>
                @endif
            </td>
            <td style="vertical-align: middle;">
                @if ($result_coti->id_sucursal == 1)
                    <span class="badge badge-info px-2 py-1 shadow-sm font-weight-bold" style="font-size: 0.75rem;">MTY</span>
                @elseif($result_coti->id_sucursal == 3)
                    <span class="badge badge-success px-2 py-1 shadow-sm font-weight-bold" style="font-size: 0.75rem;">CDMX</span>
                @elseif($result_coti->id_sucursal == 5)
                    <span class="badge badge-warning text-dark px-2 py-1 shadow-sm font-weight-bold" style="font-size: 0.75rem;">GDL</span>
                @elseif($result_coti->id_sucursal == 2)
                    <span class="badge badge-primary px-2 py-1 shadow-sm font-weight-bold" style="font-size: 0.75rem; background-color: #0948AF;">MID</span>
                @else
                    <span class="badge badge-secondary px-2 py-1 shadow-sm font-weight-bold" style="font-size: 0.75rem;">s/suc</span>
                @endif
            </td>
            <td style="vertical-align: middle; white-space: nowrap; font-size: 0.85rem; color: #495057;">
                {{ $result_coti->fecha_formato }}
            </td>
            <td style="vertical-align: middle;">
                <span class="font-weight-bold text-dark" style="font-size: 0.95rem;">$ {{ number_format($result_coti->total, 2, '.', ',') }}</span>
                @if ($result_coti->t_descuento == 'Fijo' && $result_coti->descuento_aplicado != 0)
                    <div class="mt-1">
                        <span class="badge badge-warning text-dark font-weight-bold" style="font-size: 0.7rem; padding: 2px 5px;">-$ {{ number_format($result_coti->descuento_aplicado, 2, '.', ',') }}</span>
                    </div>
                @endif
                @if ($result_coti->t_descuento == 'Porcentual' && $result_coti->descuento != 0)
                    <div class="mt-1">
                        <span class="badge badge-warning text-dark font-weight-bold" style="font-size: 0.7rem; padding: 2px 5px;">-{{ $result_coti->descuento }}%</span>
                    </div>
                @endif
            </td>
            <td style="vertical-align: middle;">
                @if ($result_coti->status == 1)
                    <span class="badge badge-info px-2 py-1 shadow-sm font-weight-bold" style="font-size: 0.78rem;">Activo</span>
                @elseif($result_coti->status == 3)
                    <span class="badge badge-success px-2 py-1 shadow-sm font-weight-bold" style="font-size: 0.78rem;">Aceptada</span>
                @elseif($result_coti->status == 4)
                    <span class="badge badge-warning text-dark px-2 py-1 shadow-sm font-weight-bold" style="font-size: 0.78rem;">Pendiente</span>
                @elseif($result_coti->status == 5)
                    <span class="badge badge-secondary px-2 py-1 shadow-sm font-weight-bold" style="font-size: 0.78rem;">Vencida</span>
                @elseif($result_coti->status == 6)
                    <span class="badge badge-primary px-2 py-1 shadow-sm font-weight-bold" style="font-size: 0.78rem; background-color: #1a3a5c;">Facturado</span>
                @else
                    <span class="badge badge-dark px-2 py-1 shadow-sm font-weight-bold" style="font-size: 0.78rem;">Inactivo</span>
                @endif
            </td>
            <td style="vertical-align: middle;">
                @php
                    $ischecked = ($result_coti->mp_status == 'si') ? 'checked' : '';
                @endphp

                @if ($result_coti->status == 1)
                    <label class="checkbox-toggle">
                        <input type="checkbox" id="activa_mp" class="activado{{ $result_coti->id_cotizacion }}"
                            data-id-coti="{{ $result_coti->id_cotizacion }}" {{ $ischecked }}>
                        <i></i>
                    </label>
                @elseif ($result_coti->status == 2)
                    <label class="checkbox-toggle disabled">
                        <input type="checkbox" id="activa_mp" class="activado{{ $result_coti->id_cotizacion }}"
                            data-id-coti="{{ $result_coti->id_cotizacion }}" {{ $ischecked }} disabled="disabled">
                        <i></i>
                    </label>
                @elseif ($result_coti->status == 3)
                    <label class="checkbox-toggle aceptada">
                        <input type="checkbox" id="activa_mp" class="activado{{ $result_coti->id_cotizacion }}"
                            data-id-coti="{{ $result_coti->id_cotizacion }}" {{ $ischecked }} disabled="disabled">
                        <i></i>
                    </label>
                @else
                    <label class="checkbox-toggle pendiente">
                        <input type="checkbox" id="activa_mp" class="activado{{ $result_coti->id_cotizacion }}"
                            data-id-coti="{{ $result_coti->id_cotizacion }}" {{ $ischecked }} disabled="disabled">
                        <i></i>
                    </label>
                @endif
            </td>
            <td style="vertical-align: middle; font-size: 0.85rem; color: #555;">
                {{ $result_coti->name }}
            </td>
            <td style="display: none">
                <a target="_blank"
                    href="{{ url('cotizaciones/andamios-ligeros') . '/' . $result_coti->ruta_encrypt }}">{{ $result_coti->cod_cotizacion }}<i
                        class="fas fa-share-square"></i></a>
            </td>
            <td style="vertical-align: middle;">
                <div class="btn-group">
                    <a href="#" class="btn btn-primary btn-sm dropdown-toggle font-weight-bold" style="background-color: #0948AF; border-color: #0948AF; border-radius: 6px; padding: 4px 10px; font-size: 0.8rem;" data-toggle="dropdown"
                        aria-expanded="false">Acción <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-menu-right shadow border-0" id="prospecto-menu" style="border-radius: 8px;">
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
            <td colspan="10">
                <div class="collapse" id="collapse{{ $result_coti->id_cotizacion }}">
                    <div class="p-3 my-2 bg-white rounded border shadow-sm">
                        <h6 class="font-weight-bold text-primary mb-2" style="font-size: 0.85rem;">
                            <i class="fas fa-boxes mr-1"></i> Desglose de Productos / Servicios
                        </h6>
                        <table class="table table-sm table-bordered mb-0" id="tabla_productos" width="100%" cellspacing="0">
                            <thead class="bg-light text-secondary font-weight-bold" style="font-size: 0.78rem;">
                                <tr>
                                    <th class="text-center" width="8%">CANTIDAD</th>
                                    <th class="text-left" width="45%">PRODUCTO</th>
                                    <th class="text-right" width="20%">PRECIO UNITARIO</th>
                                    <th class="text-right" width="27%">SUBTOTAL</th>
                                </tr>
                            </thead>
                            <tbody id="detalle_cotizacion" style="font-size: 0.85rem;">
                                @php
                                    $det_coti = $objDetCotizacion
                                        ->where('id_cotizacion', $result_coti->id_cotizacion)
                                        ->get();
                                @endphp
                                @if (!$det_coti->isEmpty())
                                    @foreach ($det_coti as $item_det_serv)
                                        <tr class="fila-det-servicio">
                                            <td class="text-center font-weight-bold">{{ $item_det_serv->cantidad }}</td>
                                            <td class="text-left">{{ $item_det_serv->nombre_producto }}</td>
                                            <td class="text-right">$ {{ number_format($item_det_serv->precio_unit, 2, '.', ',') }}</td>
                                            <td class="text-right font-weight-bold">$ {{ number_format($item_det_serv->total_ind, 2, '.', ',') }}</td>
                                        </tr>
                                    @endforeach
                                @endif

                                @if ($result_coti->descuento_aplicado != 0)
                                    <tr>
                                        <td colspan="3" class="text-right font-weight-bold text-muted">Descuento</td>
                                        <td class="text-right text-danger font-weight-bold">- $ {{ number_format($result_coti->descuento_aplicado, 2, '.', ',') }}</td>
                                    </tr>
                                @endif

                                @if ($result_coti->envio != 0)
                                    <tr>
                                        <td colspan="3" class="text-right font-weight-bold text-muted">Envío</td>
                                        <td class="text-right font-weight-bold">$ {{ number_format($result_coti->envio, 2, '.', ',') }}</td>
                                    </tr>
                                @endif

                                @if ($result_coti->subtotal != 0)
                                    <tr>
                                        <td colspan="3" class="text-right font-weight-bold text-muted">Subtotal</td>
                                        <td class="text-right font-weight-bold">$ {{ number_format($result_coti->subtotal, 2, '.', ',') }}</td>
                                    </tr>
                                @endif

                                @if ($result_coti->iva != 0)
                                    <tr>
                                        <td colspan="3" class="text-right font-weight-bold text-muted">IVA</td>
                                        <td class="text-right font-weight-bold">$ {{ number_format($result_coti->iva, 2, '.', ',') }}</td>
                                    </tr>
                                @endif

                                @if ($result_coti->total != 0)
                                    <tr class="table-primary">
                                        <td colspan="3" class="text-right font-weight-bold" style="color: #0948AF;">TOTAL</td>
                                        <td class="text-right font-weight-bold" style="color: #0948AF; font-size: 0.95rem;">
                                            $ {{ number_format($result_coti->total, 2, '.', ',') }}
                                        </td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="11" class="text-center py-5">
            <div class="text-muted">
                <i class="fas fa-search fa-3x mb-3" style="opacity: 0.3;"></i>
                <h5 class="font-weight-bold">No se encontraron cotizaciones</h5>
                <p class="small mb-0">Intenta ajustando los términos de búsqueda o los filtros aplicados.</p>
            </div>
        </td>
    </tr>
@endif
<tr>
    <td colspan="4" class="text-left py-3 pl-3">
        Total de cotizaciones: <span id="hidden-coti-total" class="font-weight-bold text-dark" style="display:inline;">{{ $listado_cotizaciones->total() }}</span>
    </td>
    <td colspan="7" class="text-right py-3 pr-3">{!! $listado_cotizaciones->links() !!}</td>
</tr>
