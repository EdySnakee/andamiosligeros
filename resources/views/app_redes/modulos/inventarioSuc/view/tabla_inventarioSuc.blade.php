@if (!$inventario_sucursal->isEmpty())
    @foreach ($inventario_sucursal as $item)
        <tr class="accordion-toggle info-inventario">
            {{-- Lógica para mostrar Nombre y Descripción --}}
            @if ($item->tipo_producto === 'andamio')
                <td>{{ $item->nombre_modelo }}</td>
                <td>{{ $item->desc_modelo }}</td>
            @elseif ($item->tipo_producto === 'accesorio')
                <td>{{ $item->nombre_accesorio }}</td>
                <td>{{ $item->desc_accesorio }}</td>
            @endif

            {{-- AQUÍ ESTÁ LA CORRECCIÓN: Mostramos tipo_producto, NO dinero --}}
            <td>{{ $item->tipo_producto }}</td> 
            <td>{{ $item->cantidad }}</td>
            <td>
                {{-- Barra de progreso original --}}
                <div class="progress-wrapper">
                    <div class="progress-label">
                        {{ $item->cantidad > 0 ? 'Disponible' : 'Agotado' }}
                    </div>
                    <div class="progress">
                        <div class="progress-bar {{ $item->cantidad <= 5 ? 'low-stock' : '5' }} {{ $item->cantidad <= 1 ? 'no-stock' : '' }}"
                            role="progressbar"
                            style="width: {{ min(($item->cantidad / 45) * 100, 100) }}%;"
                            aria-valuenow="{{ $item->cantidad }}" aria-valuemin="0"
                            aria-valuemax="500">
                            {{ $item->cantidad }} pz
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr><td colspan="5" class="text-center"><h2>Sin existencias</h2></td></tr>
@endif