<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Formato de Cambio de Producto - {{ $formato->folio_cambio ?: $formato->id }}</title>
  <style>
    @page {
      margin: 24px 34px 36px 34px;
    }
    body {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 10.5px;
      color: #2b2b2b;
      line-height: 1.3;
      margin: 0;
      padding: 0;
    }

    /* HEADER */
    .header-wrapper {
      width: 100%;
      border-bottom: 3px solid #f2bc1c;
      margin-bottom: 12px;
      padding-bottom: 6px;
    }
    .header-table {
      width: 100%;
      border-collapse: collapse;
    }
    .header-table td {
      border: none;
      padding: 0;
      vertical-align: middle;
    }
    .titulo-principal {
      color: #1a4189;
      font-size: 19px;
      font-weight: bold;
      margin: 0;
      letter-spacing: 0.3px;
    }
    .subtitulo {
      color: #1d63b8;
      font-size: 9.5px;
      font-weight: bold;
      margin-top: 3px;
      letter-spacing: 0.3px;
      text-transform: uppercase;
    }
    .logo-img {
      max-height: 48px;
      max-width: 145px;
    }
    .eslogan {
      font-size: 8.5px;
      color: #555555;
      margin-top: 2px;
      font-weight: bold;
    }

    /* TABLA DATOS GENERALES */
    .info-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 10px;
    }
    .info-table td {
      border: 1px solid #d6deeb;
      padding: 5px 8px;
      font-size: 10px;
      vertical-align: middle;
    }
    .info-table td.etiqueta {
      color: #1a4189;
      font-weight: bold;
      text-transform: uppercase;
      background-color: #f5f7fa;
      width: 22%;
      font-size: 9px;
    }
    .info-table td.valor {
      width: 28%;
      color: #222222;
    }

    /* SECCIONES */
    .seccion-titulo {
      color: #1a4189;
      font-size: 10.5px;
      font-weight: bold;
      text-transform: uppercase;
      margin-top: 12px;
      margin-bottom: 5px;
      letter-spacing: 0.2px;
    }

    /* TABLAS DE PRODUCTOS */
    .productos-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 6px;
    }
    .productos-table th {
      background-color: #1a4189;
      color: #ffffff;
      font-size: 9px;
      font-weight: bold;
      text-transform: uppercase;
      padding: 6px 6px;
      border: 1px solid #1a4189;
      text-align: center;
    }
    .productos-table td {
      border: 1px solid #d6deeb;
      padding: 5px 7px;
      font-size: 9.8px;
      vertical-align: middle;
    }

    /* CONDICIONES */
    .condiciones-titulo {
      color: #1a4189;
      font-size: 9.5px;
      font-weight: bold;
      text-transform: uppercase;
      margin-top: 8px;
      margin-bottom: 3px;
    }
    .condiciones-lista {
      margin: 0 0 8px 0;
      padding-left: 14px;
      font-size: 9px;
      color: #333333;
      line-height: 1.35;
    }
    .condiciones-lista li {
      margin-bottom: 2px;
    }

    /* OBSERVACIONES */
    .observaciones-lineas {
      width: 100%;
      margin-top: 2px;
    }
    .observaciones-texto {
      font-size: 10px;
      line-height: 18px;
      border-bottom: 1px solid #555555;
      padding-bottom: 5px;
      min-height: 28px;
    }
    .linea-vacia {
      border-bottom: 1px solid #555555;
      height: 18px;
      width: 100%;
    }

    /* TEXTO LEGAL */
    .texto-legal {
      font-size: 8.8px;
      color: #333333;
      line-height: 1.35;
      margin-top: 10px;
      margin-bottom: 28px;
    }

    /* FIRMAS (3 COLUMNAS) */
    .firmas-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 26px;
    }
    .firmas-table td {
      border: none;
      text-align: center;
      vertical-align: top;
      width: 33.33%;
      padding: 0 12px;
    }
    .linea-firma {
      border-top: 1.2px solid #4c6ea8;
      margin-bottom: 4px;
    }
    .titulo-firma {
      color: #1a4189;
      font-weight: bold;
      font-size: 9px;
      text-transform: uppercase;
      letter-spacing: 0.2px;
    }

    /* FOOTER */
    .footer-legal {
      position: fixed;
      bottom: 6px;
      left: 0;
      right: 0;
      text-align: center;
      font-size: 8.5px;
      color: #1a4189;
      letter-spacing: 0.2px;
    }
  </style>
</head>
<body>

  <!-- HEADER -->
  <div class="header-wrapper">
    <table class="header-table">
      <tr>
        <td style="width: 68%;">
          <div class="titulo-principal">FORMATO DE CAMBIO DE PRODUCTO</div>
          <div class="subtitulo">ANDAMIOS LIGEROS &nbsp;|&nbsp; DEVOLUCIÓN, SUSTITUCIÓN Y AJUSTE DE DIFERENCIA</div>
        </td>
        <td style="width: 32%; text-align: center;">
          @if(!empty($logoBase64))
            <img src="{{ $logoBase64 }}" class="logo-img" alt="Andamios Ligeros">
          @endif
          <div class="eslogan">50% mas ligero, misma resistencia.</div>
        </td>
      </tr>
    </table>
  </div>

  <!-- DATOS GENERALES -->
  <table class="info-table">
    <tr>
      <td class="etiqueta">FOLIO DE CAMBIO</td>
      <td class="valor">{{ $formato->folio_cambio ?: '____________________' }}</td>
      <td class="etiqueta">FECHA</td>
      <td class="valor">{{ !empty($formato->fecha_formato) ? $formato->fecha_formato : ($formato->fecha ? date('d/m/Y', strtotime($formato->fecha)) : '____ / ____ / ______') }}</td>
    </tr>
    <tr>
      <td class="etiqueta">CLIENTE / EMPRESA</td>
      <td class="valor">{{ $formato->cliente ?: '____________________' }}</td>
      <td class="etiqueta">TELÉFONO</td>
      <td class="valor">{{ $formato->telefono ?: '____________________' }}</td>
    </tr>
    <tr>
      <td class="etiqueta">COTIZACIÓN / FACTURA</td>
      <td class="valor">{{ $formato->cotizacion_factura ?: '____________________' }}</td>
      <td class="etiqueta">VENDEDOR</td>
      <td class="valor">{{ $formato->vendedor ?: '____________________' }}</td>
    </tr>
  </table>

  <!-- SECCIÓN 1 -->
  <div class="seccion-titulo">1. PRODUCTO QUE ENTREGA / CAMBIA EL CLIENTE</div>
  <table class="productos-table">
    <thead>
      <tr>
        <th style="width: 8%;">N.°</th>
        <th style="width: 38%;">PRODUCTO / DESCRIPCIÓN</th>
        <th style="width: 14%;">CANTIDAD</th>
        <th style="width: 18%;">VALOR RECONOCIDO</th>
        <th style="width: 22%;">ESTADO / OBSERVACIONES</th>
      </tr>
    </thead>
    <tbody>
      @forelse($formato->detallesEntregados as $idx => $det)
      <tr>
        <td style="text-align: center;">{{ $idx + 1 }}</td>
        <td>{{ $det->nombre_producto }}</td>
        <td style="text-align: center;">{{ \App\Http\Controllers\Traits\FormatosHelperTrait::formatearCantidad($det->cantidad) }}</td>
        <td style="text-align: center;">$ {{ $det->precio_unitario > 0 ? number_format($det->precio_unitario, 2) : '_____________' }}</td>
        <td>{{ $det->estado_observaciones ?: '' }}</td>
      </tr>
      @empty
      <tr>
        <td style="text-align: center;">1</td>
        <td>&nbsp;</td>
        <td style="text-align: center;">________</td>
        <td style="text-align: center;">$ _____________</td>
        <td style="text-align: center;">_________________</td>
      </tr>
      @endforelse
    </tbody>
  </table>

  <!-- SECCIÓN 2 -->
  <div class="seccion-titulo">2. PRODUCTO NUEVO / PRODUCTO DE SUSTITUCIÓN</div>
  <table class="productos-table">
    <thead>
      <tr>
        <th style="width: 8%;">N.°</th>
        <th style="width: 40%;">PRODUCTO / DESCRIPCIÓN</th>
        <th style="width: 14%;">CANTIDAD</th>
        <th style="width: 19%;">PRECIO UNITARIO</th>
        <th style="width: 19%;">IMPORTE</th>
      </tr>
    </thead>
    <tbody>
      @forelse($formato->detallesSustitucion as $idx => $det)
      <tr>
        <td style="text-align: center;">{{ $idx + 1 }}</td>
        <td>{{ $det->nombre_producto }}</td>
        <td style="text-align: center;">{{ \App\Http\Controllers\Traits\FormatosHelperTrait::formatearCantidad($det->cantidad) }}</td>
        <td style="text-align: center;">$ {{ $det->precio_unitario > 0 ? number_format($det->precio_unitario, 2) : '_____________' }}</td>
        <td style="text-align: center;">$ {{ $det->importe > 0 ? number_format($det->importe, 2) : '_____________' }}</td>
      </tr>
      @empty
      <tr>
        <td style="text-align: center;">1</td>
        <td>&nbsp;</td>
        <td style="text-align: center;">________</td>
        <td style="text-align: center;">$ _____________</td>
        <td style="text-align: center;">$ _____________</td>
      </tr>
      @endforelse
    </tbody>
  </table>

  <!-- SECCIÓN 3 -->
  <div class="seccion-titulo">3. PAGO DE LA DIFERENCIA Y CONDICIONES</div>
  <table class="info-table">
    <tr>
      <td class="etiqueta" style="width: 18%;">FORMA DE PAGO</td>
      <td class="valor" style="width: 42%;">{{ count($formasPago) > 0 ? implode(', ', $formasPago) : '____________________' }}</td>
      <td class="etiqueta" style="width: 16%;">FECHA DE PAGO</td>
      <td class="valor" style="width: 24%;">{{ !empty($formato->fecha_pago) ? $formato->fecha_pago : '____ / ____ / ______' }}</td>
    </tr>
  </table>

  <div class="condiciones-titulo">CONDICIONES DEL CAMBIO</div>
  <ul class="condiciones-lista">
    <li>El cambio queda sujeto a la revisión y aceptación del producto entregado, así como a la validación de las condiciones comerciales aplicables.</li>
    <li>El valor reconocido y el precio del producto de sustitución se registran en este formato. El cliente cubrirá la diferencia indicada, si corresponde.</li>
    <li>La entrega del producto de sustitución se realizará conforme a lo acordado, una vez validado el pago de la diferencia y la disponibilidad del producto.</li>
  </ul>

  <!-- SECCIÓN 4 -->
  <div class="seccion-titulo">4. OBSERVACIONES</div>
  <div class="observaciones-lineas">
    @if(!empty($formato->observaciones))
      <div class="observaciones-texto">{!! nl2br(e($formato->observaciones)) !!}</div>
    @else
      <div class="linea-vacia"></div>
      <div class="linea-vacia"></div>
    @endif
  </div>

  <!-- LEYENDA LEGAL -->
  <div class="texto-legal">
    Con la firma de este documento, ambas partes dejan constancia de los productos involucrados en el cambio, el valor reconocido y la diferencia acordada. Este formato no sustituye la factura, nota de crédito ni los comprobantes fiscales que correspondan.
  </div>

  <!-- FIRMAS -->
  <table class="firmas-table">
    <tr>
      <td>
        <div class="linea-firma"></div>
        <div class="titulo-firma">AUTORIZÓ (ANDAMIOS LIGEROS)</div>
      </td>
      <td>
        <div class="linea-firma"></div>
        <div class="titulo-firma">ENTREGÓ EL PRODUCTO</div>
      </td>
      <td>
        <div class="linea-firma"></div>
        <div class="titulo-firma">ACEPTÓ EL CAMBIO (CLIENTE)</div>
      </td>
    </tr>
  </table>

  <!-- FOOTER -->
  <div class="footer-legal">
    ANDAMIOS LIGEROS &bull; Formato interno de control de cambios y ajustes comerciales
  </div>

</body>
</html>

