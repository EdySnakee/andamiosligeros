<!DOCTYPE html>

<html>
<head>
<title>¡PAGO CONFIRMADO (Orden en Tienda en Línea)!</title>
<style>
body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
.container { max-width: 650px; margin: 0 auto; border: 1px solid #ccc; padding: 20px; border-radius: 8px; }
.header { background-color: #f8f8f8; padding: 15px; border-bottom: 2px solid #4CAF50; text-align: center; border-radius: 8px 8px 0 0; }
.content { padding: 20px 0; }
h2 { color: #4CAF50; }
h3 { color: #555; border-bottom: 1px solid #eee; padding-bottom: 5px; margin-top: 20px; }
table { width: 100%; border-collapse: collapse; margin-top: 15px; }
th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 0.9em; }
th { background-color: #f2f2f2; }
.footer { margin-top: 30px; border-top: 1px solid #eee; padding-top: 15px; font-size: 0.8em; color: #777; text-align: center; }
.highlight { color: #4CAF50; font-weight: bold; }
</style>
</head>
<body>
<div class="container">
<div class="header">
<h2 style="margin: 0;">¡Pago Aprobado (Orden en Tienda en Línea)! ✅</h2>
<p>Se ha recibido una nueva orden de la tienda en línea.</p>
</div>

    <div class="content">
        <p>Se ha recibido la notificación de pago aprobado para la siguiente orden:</p>

        @php
            $es_openpay = (strpos($mp_payment_type, 'openpay') !== false || strpos($mp_id, 'tr') === 0 || strpos($mp_id, 'ch_') === 0 || (isset($orden->mp_payment_type) && strpos($orden->mp_payment_type, 'openpay') !== false));
            $pasarela_nombre = $es_openpay ? 'Openpay by BBVA' : 'Mercado Pago';
            $costo_envio = round($orden->total - ($orden->subtotal + $orden->iva), 2);

            $tipo_pago_nombre = $mp_payment_type;
            if ($mp_payment_type === 'openpay_card') {
                $tipo_pago_nombre = 'Tarjeta de Crédito / Débito (Openpay)';
            } elseif ($mp_payment_type === 'openpay_checkout') {
                $tipo_pago_nombre = 'Checkout Openpay';
            } elseif ($mp_payment_type === 'openpay_bank_account') {
                $tipo_pago_nombre = 'Transferencia SPEI (Openpay)';
            } elseif ($mp_payment_type === 'openpay_store') {
                $tipo_pago_nombre = 'Pago en Efectivo / Tienda (Paynet)';
            }
        @endphp

        <h3>Detalles de la Transacción</h3>
        <ul style="list-style: none; padding: 0;">
            <li><strong>Tipo:</strong> <span class="highlight">{{ (isset($orden->status_accion) && $orden->status_accion === 'confirma_pedido') ? 'Orden en Promoción' : 'Orden en Tienda en Línea' }}</span></li> 
            <li><strong>ID de Orden:</strong> <span class="highlight">#{{ $orden->id_orden }}</span></li>
            <li><strong>Pasarela de Pago:</strong> <strong>{{ $pasarela_nombre }}</strong></li>
            @if ($es_openpay)
                <li><strong>ID de Transacción Openpay:</strong> <code>{{ $mp_id }}</code></li>
            @else
                <li><strong>ID de Pago Mercado Pago:</strong> <code>{{ $mp_id }}</code></li>
            @endif
            <li><strong>Método de Pago:</strong> <code>{{ $tipo_pago_nombre }}</code></li>
            <li><strong>Monto Total:</strong> <span class="highlight">${{ number_format($orden->total, 2) }}</span></li>
        </ul>

        @if ($cliente)
        <h3>Información del Cliente</h3>
        <table>
            <tr><th width="30%">Nombre Completo</th><td>{{ $cliente->nombrecl }}</td></tr>
            <tr><th>Correo Electrónico</th><td>{{ $cliente->emailcl }}</td></tr>
            <tr><th>Teléfono</th><td>{{ $cliente->telefonocl }}</td></tr>
            <tr><th>Dirección</th><td>{{ $cliente->direccioncl }}</td></tr>
        </table>
        @endif

        <h3>Productos Comprados</h3>
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
                {{-- $detalles viene de \App\OrdenesDetalle::where(...) --}}
                @foreach ($detalles as $detalle)
                    <tr>
                        <td>{{ $detalle->nombre_producto }}</td>
                        <td>{{ $detalle->cantidad }}</td>
                        <td>${{ number_format($detalle->precio_unit, 2) }}</td>
                        <td>${{ number_format($detalle->total_ind, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr><td colspan="3" style="text-align: right;">Subtotal:</td><td>${{ number_format($orden->subtotal, 2) }}</td></tr>
                @if ($costo_envio > 0)
                    <tr><td colspan="3" style="text-align: right;">Costo de Envío:</td><td>${{ number_format($costo_envio, 2) }}</td></tr>
                @endif
                @if ($orden->iva > 0)
                    <tr><td colspan="3" style="text-align: right;">IVA (16%):</td><td>${{ number_format($orden->iva, 2) }}</td></tr>
                @endif
                <tr style="font-weight: bold; background-color: #f2f2f2;">
                    <td colspan="3" style="text-align: right;">TOTAL:</td>
                    <td>${{ number_format($orden->total, 2) }}</td>
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