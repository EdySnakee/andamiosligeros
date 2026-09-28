   <!-- Entradas Card -->
   <div class="col-xl-6 col-md-6 mb-4">
       <div class="card border-left-success shadow h-100 py-2">
           <div class="card-body">
               <div class="row no-gutters align-items-center">
                   <div class="col mr-2">
                       <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                           Entradas</div>
                       <div class="h5 mb-0 font-weight-bold text-gray-800">Entradas Recientes
                       </div>
                       <!-- Tabla de Entradas -->
                       <div class="table-responsive" style="max-height: 175px; overflow-y: auto;">
                           <table class="table table-bordered table-striped">
                               <thead>
                                   <tr>
                                       <th># Guia</th>
                                       <th>Clave Prod</th>
                                       <th>Cantidad</th>
                                       <th>Fecha</th>
                                   </tr>
                               </thead>
                               <tbody id="tab_entradas">
                                   @if (!$entradas->isEmpty())
                                       @foreach ($entradas as $entrada)
                                           <tr>
                                               <td>{{ $entrada->num_guia }}</td>
                                               @if ($entrada->tipo_producto === 'andamio')
                                                   <td>
                                                       {{ $entrada->nombre_modelo }}
                                                   </td>
                                               @elseif ($entrada->tipo_producto === 'accesorio')
                                                   <td>
                                                       {{ $entrada->nombre_accesorio }}
                                                   </td>
                                               @endif
                                               <td>{{ $entrada->cantidad }}</td>
                                               <td>{{ $entrada->fecha_movimiento }}</td>
                                           </tr>
                                       @endforeach
                                   @else
                                       <tr>
                                           <td colspan="10" class="text-center">
                                               <h3>No hay entradas para esta sucursal</h3>
                                           </td>
                                       </tr>
                                   @endif
                               </tbody>
                           </table>
                       </div>
                   </div>
                   <div class="col-auto">
                       <i class="fas fa-arrow-down fa-2x text-gray-300"></i>
                   </div>
               </div>
           </div>
       </div>
   </div>

   <!-- Salidas Card -->
   <div class="col-xl-6 col-md-6 mb-4">
       <div class="card border-left-danger shadow h-100 py-2">
           <div class="card-body">
               <div class="row no-gutters align-items-center">
                   <div class="col mr-2">
                       <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                           Salidas</div>
                       <div class="h5 mb-0 font-weight-bold text-gray-800">Salidas Recientes
                       </div>
                       <!-- Tabla de Salidas -->
                       <div class="table-responsive" style="max-height: 175px; overflow-y: auto;">
                           <table class="table table-bordered table-striped">
                               <thead>
                                   <tr>
                                    <th># Guia</th>
                                    <th>Clave Prod</th>
                                    <th>Cantidad</th>
                                    <th>Fecha</th>
                                   </tr>
                               </thead>
                               <tbody id="tab_salidas">
                                   @if (!$salidas->isEmpty())
                                   @foreach ($salidas as $salida)
                                   <tr>
                                       <td>{{ $salida->num_guia }}</td>
                                       @if ($salida->tipo_producto === 'andamio')
                                           <td>
                                               {{ $salida->nombre_modelo }}
                                           </td>
                                       @elseif ($salida->tipo_producto === 'accesorio')
                                           <td>
                                               {{ $salida->nombre_accesorio }}
                                           </td>
                                       @endif
                                       <td>{{ $salida->cantidad }}</td>
                                       <td>{{ $salida->fecha_movimiento }}</td>
                                   </tr>
                               @endforeach
                                   @else
                                       <tr>
                                           <td colspan="10" class="text-center">
                                               <h3>No hay salidas para esta sucursal</h3>
                                           </td>
                                       </tr>
                                   @endif
                               </tbody>
                           </table>
                       </div>
                   </div>
                   <div class="col-auto">
                       <i class="fas fa-arrow-up fa-2x text-gray-300"></i>
                   </div>
               </div>
           </div>
       </div>
   </div>
