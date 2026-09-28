<?php

?>

@if (!$inventario_sucursal->isEmpty())
    @foreach ($inventario_sucursal as $item)
        <tr class="accordion-toggle info-inventario">

            @if ($item->tipo_producto === 'andamio')
                <td>
                    {{ $item->nombre_modelo }}
                </td>
                <td>
                    {{ $item->desc_modelo }}
                </td>
                <td>
                    <small><b>$</b></small>{{ number_format($item->costo_modelo, 2) }}
                </td>

                <td>
                    {{ $item->cantidad }}
                </td>
                <td>
                    <small><b>$</b></small>{{ number_format($item->suma_modelo, 2) }}
                </td>
            @elseif ($item->tipo_producto === 'accesorio')
                <td>
                    {{ $item->nombre_accesorio }}
                </td>
                <td>
                    {{ $item->desc_accesorio }}
                </td>
                <td>
                    <small><b>$</b></small>{{ number_format($item->costo_accesorio, 2) }}
                </td>

                <td>
                    {{ $item->cantidad }}
                </td>
                <td>
                    <small><b>$</b></small>{{ number_format($item->suma_accesorio, 2) }}
                </td>
            @endif

            <td>
                <div class="progress-wrapper">
                    <div class="progress-label">
                        {{ $item->cantidad > 0 ? 'Disponible' : 'Agotado' }}
                    </div>
                    <div class="progress">
                        <div class="progress-bar {{ $item->cantidad <= 5 ? 'low-stock' : '5' }} {{ $item->cantidad <= 0 ? 'no-stock' : '' }}"
                            role="progressbar" style="width: {{ min(($item->cantidad / 45) * 100, 100) }}%;"
                            aria-valuenow="{{ $item->cantidad }}" aria-valuemin="0" aria-valuemax="500">
                            {{ $item->cantidad }} pz
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="10" class="text-center">
            <h2>No hay productos en inventario para esta sucursal</h2>
        </td>
    </tr>
@endif
<tr class="mt-1">
    <td colspan="12">
        Total de productos en inventario: {!! $inventario_sucursal->count() !!}
    </td>
    {{-- <td colspan="8" class="text-right py-2">{!! $inventario_sucursal->links() !!}</td> --}}
</tr>
