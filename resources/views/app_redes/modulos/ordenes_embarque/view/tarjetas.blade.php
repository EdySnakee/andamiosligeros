    @if ($ordenes->isEmpty())
        <div class="col-12 text-center mt-5">
            <h3 class="text-muted">No hay órdenes de embarque disponibles</h3>
        </div>
    @else
        @foreach ($ordenes as $orden)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 position-relative">
                    <div class="card-body py-2">
                        <div class="d-flex justify-content-between">
                            <h5 class="font-weight-bold mb-1">Destino: <span class="text-dark" >{{ $orden->destino }}</span> </h5>
                            <span class="badge badge-{{ $orden->estado == 'completada' ? 'success' : ($orden->estado == 'transito' ? 'warning' : ($orden->estado == 'recibido' ? 'warning' : ($orden->estado == 'autorizada' ? 'primary' : 'danger'))) }} align-self-start" 
                                style="font-size: 11px; padding: 0.5em 0.75em;">
                              {{ ucfirst($orden->estado) }}
                          </span>
                        </div>
                        <p class="mb-1 font-weight-bold text-lg">
                            Origen: <span class="text-dark">{{ $orden->origen }}</span>
                        </p>
                        <p class="mb-1"><b>Responsable:</b> {{ $orden->responsable }}</p>
                        <p class="mb-1"><b>Fecha embarque:</b> {{ \Carbon\Carbon::parse($orden->fecha)->format('d/m/Y') }}</p>
                        <p class="mb-1"><b>Conducto:</b> {{ $orden->conducto }}</p>
                        <p class="mb-1"><b>Total piezas:</b> {{ $orden->total_piezas }}</p>
                        <div class="d-flex justify-content-between mt-2">
                            <button class="btn btn-sm btn-info rounded-pill" title="Editar Orden" onclick="editarOrden({{ $orden->id }}, '{{ $orden->estado }}')">
                                <i class="fas fa-eye mr-1"></i> Ver
                            </button>
                            @if (!empty(\Auth::user()->tipo_usuario) && (\Auth::user()->tipo_usuario == 'admin' || \Auth::user()->tipo_usuario == 'g1'))
                                @if ($orden->estado === 'autorizada')
                                    <button class="btn btn-sm btn-warning" title="Pasar a Tránsito" onclick="pasarAtransito({{ $orden->id }})">
                                        <i class="fas fa-arrow-right mr-1"></i> Tránsito
                                    </button>
                                @elseif ($orden->estado === 'transito')
                                    <button class="btn btn-sm btn-success" title="Recibir Orden" onclick="recibirOrden({{ $orden->id }})">
                                        <i class="fas fa-check mr-1"></i> Recibir
                                    </button>
                                @elseif ($orden->estado === 'recibido')
                                    <button class="btn btn-sm btn-primary" title="Completar Orden" onclick="completarOrden({{ $orden->id }})">
                                        <i class="fas fa-check-circle mr-1"></i> Completar
                                    </button>
                                @elseif($orden->estado === 'pendiente')
                                    <button class="btn btn-sm btn-success" title="Autorizar Orden" onclick="autorizarOrden({{ $orden->id }})">
                                        <i class="fas fa-check mr-1"></i> Autorizar
                                    </button>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
