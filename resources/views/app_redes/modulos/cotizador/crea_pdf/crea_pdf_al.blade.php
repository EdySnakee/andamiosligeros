<?php
use App\Productos;
use App\DetalleProducto;
$info_det_producto = DetalleProducto::where('id_producto', $idsproducts_unicos[0])->first();

// Configuración de Colores
$color_azul = "#1a4189";
$color_amarillo = "#f2bc1c";

// --- FUNCIONES HELPER OPTIMIZADAS (COMPATIBILIDAD WEBP / BASE64 PARA DOMPDF) ---
if (!function_exists('obtenerImagenBase64')) {
    function obtenerImagenBase64($ruta_relativa_public) {
        return \App\Utilidades::obtenerImagenBase64($ruta_relativa_public);
    }
}

if (!function_exists('obtenerBannerCotizacionBase64')) {
    function obtenerBannerCotizacionBase64($ruta_relativa_public, $maxHeightPt = 320, $pageWidthPt = 540) {
        return \App\Utilidades::obtenerBannerCotizacionBase64($ruta_relativa_public, $maxHeightPt, $pageWidthPt);
    }
}

// Cálculo dinámico de altura máxima permitida para el banner en la página 1:
// Se permite que sea más alto del estándar siempre y cuando no desborde la página del PDF.
$num_productos = !$DetalleCotizaciones->isEmpty() ? count($DetalleCotizaciones) : 0;
$espacio_tabla = 25 + ($num_productos * 24);
$max_banner_height = max(115, 462 - $espacio_tabla);

// === PRE-CARGA DE IMÁGENES OPTIMIZADAS ===
$logo_path    = obtenerImagenBase64('cotizaciones/img/version-pdf/andamios.jpg');
$banner_path  = obtenerBannerCotizacionBase64('cotizaciones/img/version-pdf/Banner-Andamios-Ligeros.jpg', $max_banner_height); 
$cinta_header = obtenerImagenBase64('cotizaciones/img/version-pdf/Header-Cinta-de-Seguridad.jpg');
$cinta_footer = obtenerImagenBase64('cotizaciones/img/version-pdf/COTIZACION-Cinta-Seguridad-Hecho-En-Mexico.jpg');
$logo_bbva    = obtenerImagenBase64('cotizaciones/img/version-pdf/logo-bbva.jpg');
$logo_mp      = obtenerImagenBase64('cotizaciones/img/version-pdf/mercadopago-logo.jpg');

// QR Dinámico
$qr_andamios  = obtenerImagenBase64('storage/qrs_cotizaciones/' . $cotizacionesRedes->id_cotizacion . '.png');

// Banner Dinámico
$banner_producto = "";
if (!empty($info_det_producto->banner)) {
    $banner_producto = obtenerBannerCotizacionBase64('storage/productos/banners/' . $info_det_producto->banner, $max_banner_height);
}
if (!$banner_producto) {
    $banner_producto = $banner_path;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Cotización {{ $cotizacionesRedes->cod_cotizacion }}</title>
    <style>
        /* Estilos Generales */
        body { font-family: sans-serif; margin: 0; padding: 0; font-size: 11px; color: #333; }
        
        /* Tablas Estructurales */
        table { width: 100%; border-collapse: collapse; border-spacing: 0; }
        td { vertical-align: top; padding: 2px; }
        
        /* Utilidades de Ancho */
        .w-100 { width: 100%; }
        .w-60 { width: 60%; }
        .w-50 { width: 50%; }
        .w-40 { width: 40%; }
        .w-25 { width: 25%; }
        
        /* Alineación */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .text-justify { text-align: justify; }

        /* Títulos */
        .blue-title { 
            color: {{ $color_azul }}; 
            border-bottom: 2px solid {{ $color_amarillo }}; 
            font-size: 18px; 
            margin-bottom: 5px; 
            display: block; 
            font-weight: bold; 
            text-transform: uppercase;
        }
        
        .header-info p { margin: 2px 0; font-size: 10px; }

        /* Tabla de Productos */
        .table-coti { margin-top: 5px; }
        .table-coti thead th { 
            background-color: #f8f9fa; /* Fondo gris claro encabezado */
            color: {{ $color_azul }}; 
            font-weight: bold; 
            padding: 6px; 
            text-align: center; 
            font-size: 10px;
            text-transform: uppercase;
        }
        /* Línea azul debajo del header de la tabla de productos (estilo web) */
        .table-coti thead tr {
             border-bottom: 2px solid #aecfea; 
        }

        .table-coti tbody td { 
            border-bottom: 1px solid #eee; 
            padding: 8px; 
            text-align: center; 
            font-size: 10px;
            vertical-align: middle;
        }

        /* Tabla de Totales (Estilo Web: Fondo Amarillo Completo) */
        .tabla-total-container {
            background-color: #ffbb01; 
            border-radius: 0 0 10px 10px; 
            padding: 10px;
            color: #000;
        }
        .tabla-total table td { 
            padding: 4px 0; 
            font-size: 11px;
            border: none !important; /* Quitar bordes internos */
        }
        .total-row td {
            font-weight: bold;
            font-size: 14px;
            padding-top: 8px;
        }

        /* Sección Inferior (Condiciones + Pagos) */
        .bottom-section {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: auto;
        }

        .condiciones-text { font-size: 9px; line-height: 1.2; color: #555; margin-top: 5px; }
        
        .section-header { 
            border-bottom: 2px solid {{ $color_amarillo }}; 
            display: inline-block; 
            font-weight: bold; 
            margin-bottom: 5px; 
            font-size: 12px; 
            color: {{ $color_azul }};
        }

        /* Cintas: Altura fija para evitar estiramiento */
        .cinta-img {
            width: 100%;
            height: 5px; /* Altura delgada */
            display: block;
        }

        .page-break { page-break-after: always; }

        /* Banner de Cabecera: Proporción controlada */
        .banner-container {
            width: 100%;
            margin: 6px 0;
            text-align: center;
        }
        .cotizacion-banner {
            width: 100%;
            height: auto;
            display: block;
        }

        /* Enlaces */
        .link-anexo { color: #007bff; text-decoration: none; font-size: 9px; }
    </style>
</head>
<body>

    <table>
        <tr>
            <td class="w-60">
                <div class="blue-title">COTIZACIÓN {{ $cotizacionesRedes->cod_cotizacion }}</div>
                <div class="header-info">
                    <table>
                        <tr>
                            <td>
                                <p><b>FECHA:</b> {{ $cotizacionesRedes->fecha_formato }}</p>
                                <p><b>ATENCIÓN:</b> {{ !empty($infoCliente->nombrecl) ? $infoCliente->nombrecl : 'PUBLICO GENERAL' }}</p>
                            </td>
                            <td>
                                <p><b>PROYECTO:</b> {{ !empty($cotizacionesRedes->proyecto) ? $cotizacionesRedes->proyecto : 'N/A' }}</p>
                                <p><b>CONSTRUCTORA:</b> {{ !empty($cotizacionesRedes->constructora) ? $cotizacionesRedes->constructora : 'N/A' }}</p>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
            <td class="w-40 text-center">
                @if($logo_path) 
                    <img style="width: 150px;" src="{{ $logo_path }}"> 
                @endif
                <p style="font-weight: bold; color: #666; margin: 0; font-size: 8px;">50% más ligero, misma resistencia.</p>
            </td>
        </tr>
    </table>

    <div style="margin-top: 5px;">
        @if($cinta_header) <img src="{{ $cinta_header }}" class="cinta-img"> @endif
    </div>

    <div class="banner-container">
        @if (!empty($banner_producto))
            <img src="{{ $banner_producto }}" alt="banner" class="cotizacion-banner">
        @elseif($banner_path) 
            <img src="{{ $banner_path }}" alt="banner" class="cotizacion-banner"> 
        @endif
    </div>

    <table class="table-coti">
        <thead>
            <tr>
                <th width="10%">CANTIDAD</th>
                <th width="45%">PRODUCTO</th>
                <th width="15%">DESCRIPCIÓN</th>
                <th width="15%">PRECIO UNITARIO</th>
                <th width="15%">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @if (!$DetalleCotizaciones->isEmpty())
                @foreach ($DetalleCotizaciones as $item)
                    <tr>
                        <td>{{ $item->cantidad }}</td>
                        <td class="text-left">
                            <b>{{ $item->nombre_producto }}</b>
                            @if ($item->tipo_cobro == 'm2')
                                <br><small>Medidas: {{ $item->alto }} x {{ $item->largo }}</small>
                            @endif
                        </td>
                        <td><span class="link-anexo">ANEXO {{ $item->SKU }}</span></td>
                        <td>
                            @if (!empty($cotizacionesRedes->tipo_cotizacion) and $cotizacionesRedes->tipo_cotizacion == 'Renta')
                                <?php $costo = !empty($item->precio_comercial) ? $item->precio_comercial * 0.01 : $item->precio_unit; ?>
                                ${{ number_format($costo, 2) }}
                            @else
                                ${{ number_format($item->precio_unit, 2) }}
                            @endif
                        </td>
                        <td><b>${{ number_format($item->total_ind, 2) }}</b></td>
                    </tr>
                @endforeach
            @else 
                <tr><td colspan="5">No hay productos registrados.</td></tr>
            @endif
        </tbody>
    </table>

    <div class="bottom-section">
        
        @if($cinta_header) <img src="{{ $cinta_header }}" class="cinta-img" style="border-radius: 0 10px 0 0;"> @endif

        <table style="width: 100%;">
            <tr>
                <td width="25%" style="vertical-align: middle;">
                    @if($logo_bbva) <img src="{{ $logo_bbva }}" style="width: 80px; display: block; margin-bottom: 5px;"> @endif
                    <div style="font-size: 9px; color: #333;">
                        <b style="color: {{ $color_azul }}; text-transform: uppercase;">Luis Ángel Coral López</b><br>
                        CUENTA: 2943604209<br>
                        CLABE: 012910029436042092
                    </div>
                </td>
                
                <td width="20%" style="vertical-align: middle; text-align: center;">
                    @if($logo_mp) <img src="{{ $logo_mp }}" style="width: 100px;"> @endif
                </td>

                <td width="15%" style="vertical-align: middle; text-align: center;">
                    @if($qr_andamios) <img src="{{ $qr_andamios }}" style="width: 100px;"> @endif
                </td>

                <td width="40%" style="vertical-align: top; margin-top: -2px">
                    <div class="tabla-total-container">
                        <table class="tabla-total">
                            @if ($cotizacionesRedes->descuento_aplicado > 0)
                            <tr>
                                <td class="text-left">DESCUENTO</td>
                                <td class="text-right">- ${{ number_format($cotizacionesRedes->descuento_aplicado, 2) }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="text-left">ENVÍO</td>
                                <td class="text-right">${{ number_format($cotizacionesRedes->envio, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="text-left">SUBTOTAL</td>
                                <td class="text-right">${{ number_format($cotizacionesRedes->subtotal, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="text-left">IVA</td>
                                <td class="text-right">${{ number_format($cotizacionesRedes->iva, 2) }}</td>
                            </tr>
                            <tr class="total-row">
                                <td class="text-left">TOTAL</td>
                                <td class="text-right">${{ number_format($cotizacionesRedes->total, 2) }}</td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>

        <div style="margin-top: 15px; border-top: 1px solid #eee; padding-top: 10px;">
            <b style="color: {{ $color_azul }}; font-size: 11px;">CONDICIONES</b>
            <div class="condiciones-text">
                @if (!empty($cotizacionesRedes->configuracion))
                    {!! $cotizacionesRedes->configuracion !!}
                @else
                    <table width="100%">
                        <tr>
                            <td width="50%">
                                • Pago en una sola exhibición<br>
                                • Aceptamos anticipos, saldos para la liberación y/o entrega
                            </td>
                            <td width="50%">
                                • Precios vigentes para el mes en curso<br>
                                • * Verifica cobertura<br>
                                • * Aplican restricciones
                            </td>
                        </tr>
                    </table>
                @endif
            </div>
        </div>

        <div style="margin-top: 10px;">
            @if($cinta_footer) <img src="{{ $cinta_footer }}" style="width: 100%;"> @endif
        </div>
    </div>

    <div class="page-break"></div>

    @if (!empty($cotizacionesRedes->tipo_cotizacion) and $cotizacionesRedes->tipo_cotizacion == 'Renta')
         <div style="position: relative; height: 100%;">
            <table>
                <tr>
                    <td class="w-60">
                        <div class="blue-title">CONTRATO DE ALQUILER</div>
                        <div style="font-size: 14px; color: #666;">Andamios Ligeros</div>
                    </td>
                    <td class="w-40 text-center">
                         @if($logo_path) <img style="width: 120px;" src="{{ $logo_path }}"> @endif
                    </td>
                </tr>
            </table>
            
            <div style="margin-top:20px; font-size: 11px; text-align: justify;">
                <p>El propietario de los andamios metálicos ofrece lo siguiente: (Ver Hoja 1). El valor total de la contrata de alquiler asciende a la suma acordada. En caso de pérdida o deterioro de los andamios, los contratistas se hacen responsables.</p>
                <br>
                <table width="100%">
                    <tr>
                        <td class="w-50">
                            <b style="color: {{ $color_azul }};">REQUISITOS PERSONA FÍSICA</b>
                            <ul>
                                <li>Orden de Compra</li>
                                <li>Constancia Fiscal / RFC</li>
                                <li>INE Vigente</li>
                                <li>Comprobante Domicilio</li>
                            </ul>
                        </td>
                        <td class="w-50">
                            <b style="color: {{ $color_azul }};">REQUISITOS PERSONA MORAL</b>
                            <ul>
                                <li>Orden de Compra</li>
                                <li>Constancia Fiscal / RFC</li>
                                <li>Acta Constitutiva</li>
                                <li>INE Representante Legal</li>
                            </ul>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="bottom-section" style="position: absolute; bottom: 0;">
                <table>
                    <tr>
                        <td class="text-left" style="vertical-align: bottom;">
                             @if($logo_bbva) <img src="{{ $logo_bbva }}" style="width: 70px;"> @endif
                        </td>
                        <td class="text-right" style="vertical-align: bottom;">
                            @if($cinta_footer) <img src="{{ $cinta_footer }}" style="width: 100%;"> @endif
                        </td>
                    </tr>
                </table>
             </div>
         </div>
    @else
        <?php 
            $contador = 0;
            $total = count($idsproducts_unicos);
        ?>
        @foreach ($idsproducts_unicos as $id_prod)
            <?php
            $contador++;
            $producto = Productos::join('detalle_producto', 'detalle_producto.id_producto', '=', 'productos.id_producto')
                        ->where('productos.id_producto', $id_prod)
                        ->first();
            
            // === LÓGICA DE IMAGEN DE PRODUCTO OPTIMIZADA (SOPORTE WEBP / BASE64) ===
            $ruta_img = "";
            if (!empty($producto->imagen)) {
                $ruta_img = obtenerImagenBase64('storage/productos/' . $producto->id_producto . '/' . $producto->imagen);
            }
            ?>

            <div style="position: relative;">
                <table>
                    <tr>
                        <td class="w-60">
                            <div class="blue-title">ANEXO ({{ $producto->SKU }})</div>
                            <div style="font-size: 14px; color: #666;">{{ $producto->nombre_p }}</div>
                        </td>
                        <td class="w-40 text-center">
                            @if($logo_path) <img style="width: 120px;" src="{{ $logo_path }}"> @endif
                        </td>
                    </tr>
                </table>
                @if($cinta_header) <img src="{{ $cinta_header }}" class="cinta-img" style="margin: 10px 0;"> @endif

                <div style="margin-bottom: 15px;">
                    <div class="section-header">DESCRIPCIÓN</div>
                    <div class="text-justify" style="font-size: 11px;">
                        {!! $producto->descripcion_producto !!}
                    </div>
                </div>

                @if ($producto->num_plantilla == 1)
                    <table>
                        <tr>
                            <td class="w-50">
                                <div class="section-header">CARACTERÍSTICAS</div>
                                <div style="font-size: 11px;">{!! $producto->caracteristicas_producto !!}</div>
                            </td>
                            <td class="w-50 text-center">
                                @if($ruta_img) <img src="{{ $ruta_img }}" style="width: 100%;"> @endif
                            </td>
                        </tr>
                    </table>
                @else
                    <div class="section-header">CARACTERÍSTICAS</div>
                    <div style="font-size: 11px; margin-bottom: 10px;">{!! $producto->caracteristicas_producto !!}</div>
                    <div class="text-center">
                        @if($ruta_img) <img src="{{ $ruta_img }}" style="max-width: 100%; max-height: 300px; object-fit: contain;"> @endif
                    </div>
                @endif
                
                <div style="margin-top: 15px; font-size: 11px;">
                    {!! $producto->extra_info_producto !!}
                </div>

                <div class="bottom-section">
                    <table style="width: 100%;">
                        <tr>
                            <td width="15%" style="vertical-align: middle;">
                                @if($logo_bbva) <img src="{{ $logo_bbva }}" style="width: 80px; display: block; margin-bottom: 5px;"> @endif
                            </td>
                            <td width="25%" style="vertical-align: middle;">
                                <div style="font-size: 9px; color: #333;">
                                    <b style="color: {{ $color_azul }}; text-transform: uppercase;">Luis Ángel Coral López</b><br>
                                    CUENTA: 2943604209<br>
                                    CLABE: 012910029436042092
                                </div>
                            </td>

                            <td width="60%" style="vertical-align: middle;">
                                @if($logo_mp) <img src="{{ $logo_mp }}" style="width: 100px;"> @endif
                            </td>
                        </tr>
                    </table>

                    <div style="margin-top: 10px;">
                        @if($cinta_footer) <img src="{{ $cinta_footer }}" style="width: 100%;"> @endif
                    </div>
                </div>
            </div>
            
            @if ($contador < $total)
                <div class="page-break"></div>
            @endif

        @endforeach
    @endif

</body>
</html>