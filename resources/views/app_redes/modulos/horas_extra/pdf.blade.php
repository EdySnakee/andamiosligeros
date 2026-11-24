<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Horas Extra ({{ $filtros['desde'] }} a {{ $filtros['hasta'] }})</title>
    <style>
        @page {
            margin: 22px 26px 30px 26px;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9.5px;
            color: #222222;
            line-height: 1.3;
            margin: 0;
            padding: 0;
        }
        .header-wrapper {
            width: 100%;
            border-bottom: 3px solid #f2bc1c;
            margin-bottom: 10px;
            padding-bottom: 6px;
        }
        table.header-table {
            width: 100%;
            border-collapse: collapse;
        }
        table.header-table td {
            border: none;
            padding: 0;
            vertical-align: bottom;
        }
        .titulo-principal {
            color: #1a4189;
            font-size: 18px;
            font-weight: bold;
            margin: 0;
        }
        .subtitulo {
            color: #1d63b8;
            font-size: 9.5px;
            font-weight: bold;
            margin-top: 3px;
            text-transform: uppercase;
        }
        .logo-img {
            max-height: 44px;
            max-width: 145px;
        }
        .cinta-header {
            width: 145px;
            height: 4px;
            display: block;
            margin-left: auto;
            margin-top: 4px;
        }
        table.meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        table.meta-table td {
            border: 1px solid #d6deeb;
            padding: 4px 7px;
            font-size: 9px;
        }
        table.meta-table td.lbl {
            background-color: #f5f7fa;
            color: #1a4189;
            font-weight: bold;
            width: 14%;
            text-transform: uppercase;
        }
        .seccion-titulo {
            color: #1a4189;
            font-size: 10.5px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 10px 0 5px 0;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        table.data-table th {
            background-color: #1a4189;
            color: #ffffff;
            font-size: 8.5px;
            text-transform: uppercase;
            text-align: left;
            padding: 5px 5px;
            border: 1px solid #1a4189;
        }
        table.data-table td {
            border: 1px solid #d6deeb;
            padding: 4px 5px;
            font-size: 8.8px;
            vertical-align: top;
        }
        table.data-table tr:nth-child(even) td {
            background-color: #fafbfd;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .nota-metodologica {
            border: 1px solid #d6deeb;
            background-color: #f8fafc;
            padding: 6px 8px;
            font-size: 8.5px;
            color: #475569;
            margin-top: 8px;
        }
        table.firmas-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 26px;
        }
        table.firmas-table td {
            width: 50%;
            text-align: center;
            padding: 0 30px;
            vertical-align: bottom;
        }
        .linea-firma {
            border-top: 1px solid #334155;
            padding-top: 4px;
            font-size: 9px;
            font-weight: bold;
            color: #1e293b;
        }
    </style>
</head>
<body>

    <div class="header-wrapper">
        <table class="header-table">
            <tr>
                <td style="width: 68%;">
                    <div class="titulo-principal">REPORTE DE HORAS EXTRA</div>
                    <div class="subtitulo">Andamios Ligeros &mdash; Control, Validación y Auditoría</div>
                </td>
                <td style="width: 32%; text-align: right;">
                    @if (!empty($logoBase64))
                        <img src="{{ $logoBase64 }}" class="logo-img" alt="Andamios Ligeros">
                    @endif
                    @if (!empty($cintaBase64))
                        <img src="{{ $cintaBase64 }}" class="cinta-header" alt="">
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <table class="meta-table">
        <tr>
            <td class="lbl">Periodo</td>
            <td>{{ $filtros['desde'] }} al {{ $filtros['hasta'] }}</td>
            <td class="lbl">Colaborador</td>
            <td>{{ $usuarioFiltrado ? $usuarioFiltrado->name : 'Todos' }}</td>
            <td class="lbl">Estatus</td>
            <td>{{ !empty($filtros['estatus']) ? ucfirst(str_replace('_', ' ', $filtros['estatus'])) : 'Todos' }}</td>
        </tr>
        <tr>
            <td class="lbl">Generado el</td>
            <td>{{ $generadoAt->format('d/m/Y H:i') }}</td>
            <td class="lbl">Generado por</td>
            <td>{{ $generadoPor ? $generadoPor->name : 'Sistema' }}</td>
            <td class="lbl">Registros</td>
            <td>{{ $registros->count() }}</td>
        </tr>
    </table>

    <div class="seccion-titulo">Detalle de solicitudes y sesiones</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 8%;">Fecha</th>
                <th style="width: 14%;">Usuario</th>
                <th style="width: 10%;">Modalidad</th>
                <th style="width: {{ !empty($esAdmin) ? '23%' : '29%' }};">Motivo</th>
                <th style="width: 7%;" class="text-right">Est.</th>
                <th style="width: 8%;" class="text-right">Dec.</th>
                @if (!empty($esAdmin))
                    <th style="width: 10%;" class="text-right">Activas (%)</th>
                @endif
                <th style="width: 7%;" class="text-right">Val.</th>
                <th style="width: 7%;">Estatus</th>
                <th style="width: {{ !empty($esAdmin) ? '6%' : '10%' }};">Validó</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($registros as $reg)
                @php
                    $motivo = (string) $reg->motivo;
                    $motivoCorto = mb_strlen($motivo) > 80 ? mb_substr($motivo, 0, 80) . '...' : $motivo;
                    $infoEst = $reg->infoEstatus();
                    $pct = $reg->inicio_at ? $reg->porcentajeRespaldo() : null;
                @endphp
                <tr>
                    <td>{{ $reg->fechaYmd() }}</td>
                    <td>{{ $reg->usuario ? $reg->usuario->name : 'Usuario #' . $reg->user_id }}</td>
                    <td>{{ $reg->nombreModalidad() }}</td>
                    <td>{{ $motivoCorto }}</td>
                    <td class="text-right">{{ \App\HoraExtraSolicitud::formatearHoras($reg->horas_estimadas) }}</td>
                    <td class="text-right">{{ \App\HoraExtraSolicitud::formatearMinutos($reg->minutos_declarados) }}</td>
                    @if (!empty($esAdmin))
                        <td class="text-right">
                            @if ($reg->minutos_activos !== null)
                                {{ \App\HoraExtraSolicitud::formatearMinutos($reg->minutos_activos) }} ({{ $pct !== null ? $pct : 0 }}%)
                            @else
                                —
                            @endif
                        </td>
                    @endif
                    <td class="text-right"><strong>{{ \App\HoraExtraSolicitud::formatearMinutos($reg->minutos_validados) }}</strong></td>
                    <td>{{ $infoEst['texto'] }}</td>
                    <td>{{ $reg->validador ? $reg->validador->name : '—' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ !empty($esAdmin) ? 10 : 9 }}" class="text-center">Sin registros en el periodo seleccionado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="seccion-titulo">Totales por colaborador y avisos LFT</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: {{ !empty($esAdmin) ? '24%' : '28%' }};">Colaborador</th>
                <th style="width: 12%;">Rol</th>
                <th style="width: 8%;" class="text-center">Sesiones</th>
                <th style="width: 10%;" class="text-right">Declaradas</th>
                @if (!empty($esAdmin))
                    <th style="width: 10%;" class="text-right">Activas</th>
                @endif
                <th style="width: 11%;" class="text-right">Validadas</th>
                <th style="width: {{ !empty($esAdmin) ? '25%' : '31%' }};">Avisos LFT (3h/día · 3d/sem · 9h/sem)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($totalesUsuario as $tot)
                <tr>
                    <td><strong>{{ $tot['usuario_nombre'] }}</strong></td>
                    <td>{{ $tot['usuario_rol'] }}</td>
                    <td class="text-center">{{ $tot['sesiones'] }}</td>
                    <td class="text-right">{{ \App\HoraExtraSolicitud::formatearMinutos($tot['minutos_declarados']) }}</td>
                    @if (!empty($esAdmin))
                        <td class="text-right">{{ \App\HoraExtraSolicitud::formatearMinutos($tot['minutos_activos']) }}</td>
                    @endif
                    <td class="text-right"><strong>{{ \App\HoraExtraSolicitud::formatearMinutos($tot['minutos_validados']) }}</strong></td>
                    <td>
                        @if (count($tot['avisos_lft']))
                            {{ implode('; ', $tot['avisos_lft']) }}
                        @else
                            Sin excedentes LFT
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ !empty($esAdmin) ? 7 : 6 }}" class="text-center">Sin totales por mostrar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="nota-metodologica">
        <strong>Nota metodológica:</strong> Los tiempos mostrados representan el tiempo estimado, declarado y validado por un administrador distinto al solicitante.
        @if (!empty($esAdmin))
            Los minutos activos reflejan únicamente latidos periódicos de sesión visible y acciones realizadas dentro del sistema administrativo mientras la sesión estuvo en curso; no miden trabajo en herramientas externas (llamadas, mensajería o correo).
        @endif
    </div>

    <table class="firmas-table">
        <tr>
            <td>
                <div class="linea-firma">Elaboró</div>
            </td>
            <td>
                <div class="linea-firma">Autorizó</div>
            </td>
        </tr>
    </table>

</body>
</html>

