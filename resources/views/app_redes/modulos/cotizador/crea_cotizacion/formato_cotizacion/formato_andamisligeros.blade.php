@php
	use App\Utilidades;
	$fecha = Utilidades::fecha();
@endphp

<!-- HOJA DE VISTA PREVIA DE COTIZACIÓN (MODO CAPTURA POR DEFECTO) -->
<div class="coti-preview-sheet modo-captura-activa" id="coti_captura_area">
    <!-- 1. ENCABEZADO -->
    <div class="encabezado mb-2">
        <h2 class="blue-title mb-2">
            @if($accion == "agregar")
                <b>COTIZACIÓN</b>
            @elseif($accion == "editar")
                <b>COTIZACIÓN {{ $info_cotizacion->cod_cotizacion }}</b>
            @endif
        </h2>
        <div class="row" style="font-size: 15px; line-height: 1.5; margin-top: 4px;">
            <div class="col-md-7 col-sm-7 col-xs-12">
                <p class="mb-1"><b>FECHA:</b> <span id="fecha_formato">{{ $fecha }}</span></p>
                <ul id="info_cliente" class="info-cliente p-0 m-0" style="list-style: none; margin-top: 3px;">
                    @include('app_redes.modulos.cotizador.crea_cotizacion.formato_cotizacion.fieldset_info_cliente')
                </ul>
            </div>
            <div class="col-md-5 col-sm-5 col-xs-12">
                <p class="mb-1"><b>SUCURSAL:</b> <span id="sucursal_preview_txt" style="font-weight: 700; text-transform: uppercase; color: #0d2b68;">MÉRIDA</span></p>
                <p class="mb-1"><b>VENDEDOR:</b> <span style="font-weight: 600;">{{ Auth::check() ? Auth::user()->name : 'ASESOR' }}</span></p>
            </div>
        </div>
    </div>

    <!-- 2. CINTA DE SEGURIDAD SUPERIOR (DELGADA) -->
    <img src="{{ url('cotizaciones/img/Header-Cinta-de-Seguridad.png') }}" class="img-responsive w-100 coti-cinta-seguridad" alt="Cinta de seguridad" style="width: 100%; height: 8px; object-fit: cover; display: block; margin: 6px 0 8px 0; border-radius: 2px;">

    <!-- 3. BANNER ANDAMIOS LIGEROS -->
    <div class="banner-preview-wrapper text-center my-2">
        <img src="{{ url('cotizaciones/img/Banner-Andamios-Ligeros.png') }}" alt="Banner Andamios Ligeros" class="img-responsive w-100 cotizacion-banner" style="max-height: 180px; width: 100%; object-fit: contain;">
    </div>

    <!-- 4. TABLA DE PRODUCTOS -->
    <div class="table-responsive my-2">
        <table class="table table-coti text-center mb-0" id="tabla_productos" style="width: 100%;">
            <thead>
                <tr>
                    <th style="width: 12%;">CANTIDAD</th>
                    <th style="width: 38%; text-align: left;">PRODUCTO</th>
                    <th style="width: 18%;">DESCRIPCIÓN</th>
                    <th style="width: 16%;">PRECIO UNITARIO</th>
                    <th style="width: 16%;">TOTAL</th>
                    <th style="width: 5%;" class="col-accion-th no-captura">ACCIÓN</th>
                </tr>
            </thead>
            <tbody id="detalle_cotizacion" class="text-center">
                @if($accion == "agregar")
                    <tr id="sin_conceptos_row">
                        <td colspan="6" class="text-center text-muted py-3" style="background: #fafafa;">
                            <span style="font-size: 12px; color: #888;">Selecciona un producto y presiona "Agregar servicio" para comenzar</span>
                        </td>
                    </tr>
                    <tr id="fila_totales_hidden" style="display: none !important;">
                        <td colspan="6">
                            <input type="hidden" id="subtotal_sin_descuento" value="0">
                            <span id="subtotal_global" data-subtotal-global="0"></span>
                            <span id="nuevo_descuento" data-nuevo-descuento="0"></span>
                            <span id="envio" data-costo-envio="0"></span>
                            <input type="hidden" id="iva" value="0">
                            <input type="hidden" id="v_iva" value="0.0">
                            <span id="total" data-total="0"></span>
                        </td>
                    </tr>
                @elseif($accion == "editar")
                    @include('app_redes.modulos.cotizador.crea_cotizacion.formato_cotizacion.agrega_items')
                @endif
            </tbody>
        </table>
    </div>

    <!-- 5. CINTA DE SEGURIDAD INFERIOR (DELGADA) -->
    <img src="{{ url('cotizaciones/img/Header-Cinta-de-Seguridad.png') }}" class="img-responsive w-100 coti-cinta-seguridad" alt="Cinta de seguridad" style="width: 100%; height: 8px; object-fit: cover; display: block; margin: 10px 0 14px 0; border-radius: 2px;">

    <!-- 6. SECCIÓN INFERIOR: LOGOS DE PAGO + BANCO + CAJA AMARILLA DE TOTALES (FLEXIBLE Y SIN DESBORDES) -->
    <div class="coti-footer-row" style="margin-top: 8px;">
        <!-- Bloque de pagos y bancos -->
        <div class="coti-pagos-wrap">
            <img src="{{ url('cotizaciones/img/logo-bbva.png') }}" alt="BBVA" class="coti-bbva">
            
            <div class="coti-banco-info">
                <p class="coti-banco-tit">REDES ANTICAÍDAS</p>
                <p class="coti-banco-txt"><strong>CUENTA:</strong> <span>012 059 1289</span></p>
                <p class="coti-banco-txt"><strong>CLABE:</strong> <span>012 91000120591289 2</span></p>
            </div>

            <img src="{{ url('cotizaciones/img/mercadopago-logo.png') }}" alt="Mercado Pago" class="coti-mp">

            <img src="{{ url('cotizaciones/img/QR-Andamios.png') }}" alt="QR Andamios Ligeros" class="coti-qr">
        </div>

        <!-- Recuadro amarillo de totales con ancho fijo protegido -->
        <div class="tabla-total-container">
            <div class="tabla-total">
                <table>
                    <tr id="caja_row_subtotal">
                        <td style="white-space: nowrap; text-align: left; padding-right: 8px;">SUBTOTAL</td>
                        <td style="white-space: nowrap; text-align: right;" id="caja_txt_subtotal">$0.00</td>
                        <td class="no-captura" style="width: 18px;"></td>
                    </tr>
                    <tr id="caja_row_descuento" style="display: none;">
                        <td style="white-space: nowrap; text-align: left; padding-right: 8px; color: #7a1200 !important;">DESCUENTO</td>
                        <td style="white-space: nowrap; text-align: right; color: #7a1200 !important;" id="caja_txt_descuento">-$0.00</td>
                        <td class="no-captura" style="width: 18px; text-align: right; padding-left: 4px;">
                            <a href="#" class="del_descuento" id="caja_btn_del_descuento" style="font-size: 12px; font-weight: bold; color: #7a1200 !important; text-decoration: none;" title="Quitar descuento"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    <tr id="caja_row_envio">
                        <td style="white-space: nowrap; text-align: left; padding-right: 8px;">ENVÍO</td>
                        <td style="white-space: nowrap; text-align: right;" id="caja_txt_envio">$0.00</td>
                        <td class="no-captura" style="width: 18px; text-align: right; padding-left: 4px;">
                            <a href="#" class="del_envio" id="caja_btn_del_envio" style="display: none; font-size: 12px; font-weight: bold; color: #8a1f11 !important; text-decoration: none;" title="Quitar envío"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    <tr id="caja_row_iva">
                        <td style="white-space: nowrap; text-align: left; padding-right: 8px;">IVA</td>
                        <td style="white-space: nowrap; text-align: right;" id="caja_txt_iva">$0.00</td>
                        <td class="no-captura" style="width: 18px;"></td>
                    </tr>
                    <tr id="caja_row_total">
                        <td style="white-space: nowrap; text-align: left; padding-right: 12px;">TOTAL</td>
                        <td style="white-space: nowrap; text-align: right;" id="caja_txt_total">$0.00</td>
                        <td class="no-captura" style="width: 18px;"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- 7. BARRA DE ACCIÓN Y GUARDADO -->
<div class="row btn-contenedor mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
    <div class="col-md-6 col-sm-6 mb-2 mb-md-0">
        <button type="button" class="btn btn-outline-secondary btn-sm" id="btn_toggle_captura" title="Habilitar botones para eliminar o modificar productos">
            <i class="fas fa-edit mr-1"></i> Modificar productos
        </button>
    </div>
    <div class="col-md-6 col-sm-6 text-md-right text-left">
        @if($accion == "agregar")
            <button type="submit" id="open_confirm_post_cotizacion" class="btn btn-success btn-lg px-4 font-weight-bold shadow-sm">Guardar Cotización</button>
        @elseif($accion == "editar")
            <input type="hidden" value="{{(!empty($info_cotizacion->id_cotizacion))?$info_cotizacion->id_cotizacion:''}}" name="id_cotizacion" id="id_cotizacion">
            <button type="submit" id="edit_cotizacion" class="btn btn-primary btn-lg px-4 font-weight-bold shadow-sm">Guardar Cambios</button>
        @endif
    </div>
</div>
