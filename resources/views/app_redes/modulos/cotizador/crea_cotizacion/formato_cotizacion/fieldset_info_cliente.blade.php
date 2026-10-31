@if(!empty($datos_clientes) && !empty($datos_clientes->nombrecl))
    <li style="list-style: none; margin-bottom: 2px; font-size: 15px; line-height: 1.4;">
        <b style="color: #333;">EN ATENCIÓN:</b>
        <span style="font-weight: 700; color: #0d2b68; font-size: 15.5px; margin-left: 3px;">{{ $datos_clientes->nombrecl }}</span>
    </li>
    @if(!empty($datos_clientes->rfccl))
        <li style="list-style: none; margin-bottom: 2px; font-size: 14px; color: #444;">
            <b>Empresa/RFC:</b> {{ $datos_clientes->rfccl }}
        </li>
    @endif
    @php
        $tel_cliente = !empty($datos_clientes->telefonocl) ? $datos_clientes->telefonocl : (!empty($datos_clientes->celularcl) ? $datos_clientes->celularcl : null);
    @endphp
    @if(!empty($tel_cliente))
        <li class="no-captura info-cliente-tel" style="list-style: none; margin-bottom: 2px; font-size: 14px; color: #444;">
            <b>Teléfono:</b> {{ $tel_cliente }}
        </li>
    @endif
    @if(!empty($datos_clientes->emailcl))
        <li style="list-style: none; margin-bottom: 2px; font-size: 14px; color: #444;">
            <b>Email:</b> {{ $datos_clientes->emailcl }}
        </li>
    @endif
    @php
        $dir_raw = trim(($datos_clientes->direccioncl ?? '') . ' ' . ($datos_clientes->lugarcl ?? '') . ' ' . ($datos_clientes->cpcl ?? ''));
        $dir_limpia = trim(str_replace(['|', '-'], ' ', $dir_raw));
    @endphp
    @if(!empty($dir_limpia))
        <li style="list-style: none; margin-bottom: 2px; font-size: 14px; color: #444;">
            <b>Dirección:</b> {{ $dir_limpia }}
        </li>
    @endif
@endif
