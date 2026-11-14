<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Formato de Entrega - {{ $formato->folio_entrega ?: $formato->id }}</title>
  <style>
    @page {
      margin: 28px 36px 42px 36px;
    }
    body {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 11px;
      color: #2b2b2b;
      line-height: 1.35;
      margin: 0;
      padding: 0;
    }

    /* HEADER */
    .header-wrapper {
      width: 100%;
      border-bottom: 3px solid #f2bc1c;
      margin-bottom: 14px;
    }
    .header-table {
      width: 100%;
      border-collapse: collapse;
    }
    .header-table td {
      border: none;
      padding: 0;
      vertical-align: bottom;
    }
    .titulo-principal {
      color: #1a4189;
      font-size: 22px;
      font-weight: bold;
      margin: 0;
      letter-spacing: 0.4px;
      line-height: 1.15;
    }
    .subtitulo {
      color: #1d63b8;
      font-size: 10px;
      font-weight: bold;
      margin-top: 4px;
      margin-bottom: 10px;
      letter-spacing: 0.4px;
      text-transform: uppercase;
    }
    .logo-img {
      max-height: 52px;
      max-width: 155px;
    }
    .eslogan {
      font-size: 9px;
      color: #555555;
      margin-top: 2px;
      margin-bottom: 4px;
      font-weight: bold;
    }
    .cinta-header {
      width: 155px;
      height: 5px;
      display: block;
      margin-left: auto;
    }

    /* TABLA DATOS GENERALES */
    .info-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 12px;
    }
    .info-table td {
      border: 1px solid #d6deeb;
      padding: 6px 9px;
      font-size: 10.5px;
      vertical-align: middle;
    }
    .info-table td.etiqueta {
      color: #1a4189;
      font-weight: bold;
      text-transform: uppercase;
      background-color: #f5f7fa;
      width: 22%;
      font-size: 9.5px;
    }
    .info-table td.valor {
      width: 28%;
      color: #222222;
    }

    /* SECCIONES */
    .seccion-titulo {
      color: #1a4189;
      font-size: 11.5px;
      font-weight: bold;
      text-transform: uppercase;
      margin-top: 18px;
      margin-bottom: 8px;
      letter-spacing: 0.3px;
    }

    /* TABLA DE PRODUCTOS */
    .productos-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 10px;
    }
    .productos-table th {
      background-color: #1a4189;
      color: #ffffff;
      font-size: 10px;
      font-weight: bold;
      text-transform: uppercase;
      padding: 7px 8px;
      border: 1px solid #1a4189;
      text-align: center;
    }
    .productos-table td {
      border: 1px solid #d6deeb;
      padding: 7px 9px;
      font-size: 10.5px;
      vertical-align: middle;
    }

    /* OBSERVACIONES */
    .observaciones-lineas {
      width: 100%;
      margin-top: 4px;
    }
    .observaciones-texto {
      font-size: 10.5px;
      line-height: 20px;
      border-bottom: 1px solid #555555;
      padding-bottom: 6px;
      min-height: 36px;
    }
    .linea-vacia {
      border-bottom: 1.2px solid #555555;
      height: 22px;
      width: 100%;
    }

    /* TEXTO LEGAL */
    .texto-legal {
      font-size: 9.5px;
      color: #333333;
      line-height: 1.4;
      margin-top: 12px;
      margin-bottom: 34px;
    }

    /* FIRMA */
    .firmas-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 32px;
    }
    .firmas-table td {
      border: none;
      text-align: center;
      vertical-align: top;
    }
    .firma-box {
      width: 210px;
      margin: 0 auto;
    }
    .linea-firma {
      border-top: 1.2px solid #4c6ea8;
      margin-bottom: 5px;
    }
    .titulo-firma {
      color: #1a4189;
      font-weight: bold;
      font-size: 10.5px;
      text-transform: uppercase;
      letter-spacing: 0.4px;
    }

    /* FOOTER */
    .footer-legal {
      position: fixed;
      bottom: 8px;
      left: 0;
      right: 0;
      text-align: center;
      font-size: 9px;
      color: #1a4189;
      letter-spacing: 0.3px;
    }
  </style>
</head>
<body>

  <!-- HEADER -->
  <div class="header-wrapper">
    <table class="header-table">
      <tr>
        <td style="width: 68%; padding-bottom: 4px;">
          <div class="titulo-principal">FORMATO DE ENTREGA</div>
          <div class="subtitulo">ANDAMIOS LIGEROS &nbsp;|&nbsp; CONTROL DE ENTREGA DE PRODUCTO</div>
        </td>
        <td style="width: 32%; text-align: center; padding-bottom: 0;">
          @if(!empty($logoBase64))
            <img src="{{ $logoBase64 }}" class="logo-img" alt="Andamios Ligeros">
          @endif
          <div class="eslogan">50% mas ligero, misma resistencia.</div>
          @if(!empty($cintaBase64))
            <img src="{{ $cintaBase64 }}" class="cinta-header" alt="">
          @endif
        </td>
      </tr>
    </table>
  </div>

  <!-- DATOS GENERALES -->
  <table class="info-table">
    <tr>
      <td class="etiqueta">FOLIO DE ENTREGA</td>
      <td class="valor">{{ $formato->folio_entrega ?: '—' }}</td>
      <td class="etiqueta">FECHA DE ENTREGA</td>
      <td class="valor">{{ !empty($formato->fecha_formato) ? $formato->fecha_formato : ($formato->fecha ? date('d/m/Y', strtotime($formato->fecha)) : '____ / ____ / ______') }}</td>
    </tr>
    <tr>
      <td class="etiqueta">CLIENTE / EMPRESA</td>
      <td class="valor">{{ $formato->cliente ?: '—' }}</td>
      <td class="etiqueta">TELÉFONO</td>
      <td class="valor">{{ $formato->telefono ?: '—' }}</td>
    </tr>
    <tr>
      <td class="etiqueta">COTIZACIÓN / PEDIDO</td>
      <td class="valor">{{ $formato->folio_cotizacion ?: '—' }}</td>
      <td class="etiqueta">VENDEDOR</td>
      <td class="valor">{{ $formato->vendedor ?: '—' }}</td>
    </tr>
  </table>

  <!-- DETALLE DE PRODUCTOS ENTREGADOS -->
  <div class="seccion-titulo">DETALLE DE PRODUCTOS ENTREGADOS</div>
  <table class="productos-table">
    <thead>
      <tr>
        <th style="width: 10%;">N.°</th>
        <th style="width: 72%;">PRODUCTO / DESCRIPCIÓN</th>
        <th style="width: 18%;">CANTIDAD</th>
      </tr>
    </thead>
    <tbody>
      @forelse($formato->detalles as $idx => $det)
      <tr>
        <td style="text-align: center;">{{ $idx + 1 }}</td>
        <td>{{ $det->nombre_producto }}</td>
        <td style="text-align: center;">{{ \App\Http\Controllers\Traits\FormatosHelperTrait::formatearCantidad($det->cantidad) }}</td>
      </tr>
      @empty
      <tr>
        <td colspan="3" style="text-align: center; color: #777;">Sin detalles de productos registrados.</td>
      </tr>
      @endforelse
    </tbody>
  </table>

  <!-- OBSERVACIONES / INCIDENCIAS -->
  <div class="seccion-titulo">OBSERVACIONES / INCIDENCIAS</div>
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
    RECIBÍ los productos descritos en este formato y dejo constancia de la revisión realizada al momento de la entrega. Las observaciones, faltantes o daños visibles se anotan en el apartado correspondiente.
  </div>

  <!-- FIRMA -->
  <table class="firmas-table">
    <tr>
      <td>
        <div class="firma-box">
          <div class="linea-firma"></div>
          <div class="titulo-firma">RECIBIÓ</div>
        </div>
      </td>
    </tr>
  </table>

  <!-- FOOTER -->
  <div class="footer-legal">
    ANDAMIOS LIGEROS &bull; Formato interno de control de entrega &bull; Conservar copia firmada
  </div>

</body>
</html>

