<!DOCTYPE html>

<html>

<head>
    <title>¡PAGO CONFIRMADO (Cotización)!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 650px;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
        }

        .header {
            background-color: #f8f8f8;
            padding: 15px;
            border-bottom: 2px solid #007bff;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        .content {
            padding: 20px 0;
        }

        h2 {
            color: #007bff;
        }

        h3 {
            color: #555;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 0.9em;
        }

        th {
            background-color: #f2f2f2;
        }

        .footer {
            margin-top: 30px;
            border-top: 1px solid #eee;
            padding-top: 15px;
            font-size: 0.8em;
            color: #777;
            text-align: center;
        }

        .highlight {
            color: #007bff;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2 style="margin: 0;">¡Pago Aprobado (Cotización)! ✅</h2>
            <p>Se ha recibido un pago para una cotización.</p>
        </div>

        <div class="content">
            <p>Se ha recibido la notificación de pago aprobado para la siguiente cotización:</p>

            <h3>Detalles de la Transacción</h3>
            @php
                $es_openpay_cot = (strpos($mp_payment_type, 'openpay') !== false || strpos($mp_id, 'tr') === 0 || strpos($mp_id, 'ch_') === 0);
                $pasarela_nombre_cot = $es_openpay_cot ? 'Openpay by BBVA' : 'Mercado Pago';
            @endphp
            <ul style="list-style: none; padding: 0;">
                <li><strong>Tipo:</strong> <span class="highlight">Cotización</span></li>
                <li><strong>Código Cotización:</strong> <span class="highlight">#{{ $cotizacion->cod_cotizacion }}</span></li>
                <li><strong>Pasarela de Pago:</strong> <strong>{{ $pasarela_nombre_cot }}</strong></li>
                @if ($es_openpay_cot)
                    <li><strong>ID de Transacción Openpay:</strong> <code>{{ $mp_id }}</code></li>
                @else
                    <li><strong>ID de Pago Mercado Pago:</strong> <code>{{ $mp_id }}</code></li>
                @endif
                <li><strong>Tipo de Pago:</strong> <code>{{ $mp_payment_type }}</code></li>
                <li><strong>Monto Total:</strong> <span class="highlight">${{ number_format($cotizacion->total, 2) }}</span></li>
            </ul>


            @if ($cliente)
            <h3>Información del Cliente</h3>
            <table>
                <tr>
                    <th width="30%">Nombre Completo</th>
                    <td>{{ $cliente->nombrecl }}</td>
                </tr>
                <tr>
                    <th>Correo Electrónico</th>
                    <td>{{ $cliente->emailcl }}</td>
                </tr>
                <tr>
                    <th>Teléfono</th>
                    <td>{{ $cliente->telefonocl }}</td>
                </tr>
                <tr>
                    <th>Dirección</th>
                    <td>{{ $cliente->direccioncl }}</td>
                </tr>
            </table>
            @endif

            <h3>Conceptos Cotizados</h3>
            <table>
                <thead>
                    <tr>
                        <th width="40%">Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unit.</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- $detalles viene de \App\DetalleCotizaciones::where(...) --}}
                    @foreach ($detalles as $detalle)
                    <tr>
                        <td>
                            {{ $detalle->nombre_producto }}
                            @if ($detalle->tipo_cobro == 'm2')
                            ({{ $detalle->alto }} x {{ $detalle->largo }})
                            @endif
                        </td>
                        <td>{{ $detalle->cantidad }}</td>
                        <td>${{ number_format($detalle->precio_unit, 2) }}</td>
                        <td>${{ number_format($detalle->total_ind, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    @if($cotizacion->descuento_aplicado > 0)
                    <tr>
                        <td colspan="3" style="text-align: right;">Descuento:</td>
                        <td>-${{ number_format($cotizacion->descuento_aplicado, 2) }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td colspan="3" style="text-align: right;">Subtotal:</td>
                        <td>${{ number_format($cotizacion->subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: right;">IVA (si aplica):</td>
                        <td>${{ number_format($cotizacion->iva, 2) }}</td>
                    </tr>
                    <tr style="font-weight: bold; background-color: #f2f2f2;">
                        <td colspan="3" style="text-align: right;">TOTAL:</td>
                        <td>${{ number_format($cotizacion->total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="footer">
            <p>Este es un correo automático del sistema de notificaciones de Andamios Ligeros.</p>
        </div>
    </div>


</body>

</html>