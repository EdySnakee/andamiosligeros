@if(!$datos_proyectos_redes->isEmpty())
    @foreach($datos_proyectos_redes as $result_proyectos_redes)

        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col-md-10">
                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{$result_proyectos_redes->estado}}</div>
                  <div class=" mb-0 text-lg text-gray-800">{{$result_proyectos_redes->nombre_proyecto}}</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800">
                    @if(isset($datos_cliente))
                      @if(!$datos_cliente->isEmpty())
                        <?php $contador=0;?>
                        @foreach($datos_cliente as $result_clientes_redes)
                          @if($result_proyectos_redes->id_proyecto == $result_clientes_redes->id_proyecto)
                          <?php 
                            $contador= $contador + 1; 
                            ?>
                          @endif
                        @endforeach
                        <?php 
                        $total_clientes = $contador;
                        echo "Total de clientes: ".$total_clientes;
                        ?>
                      @else
                        Total de clientes: 0
                      @endif
                    @endif
                  </div>                    
                </div>
                <div class="col-md-2 text-center">
                  <i class="far fa-building fa-2x text-gray-300"></i>
                </div>
                  <div class="col-md-6 text-left footer-item">
                      <a href="#" id="confirm_delate" data-id-proyecto="{{$result_proyectos_redes->id_proyecto}}" class="btn btn-danger btn-circle btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar proyecto">
                        <i class="fas fa-trash-alt"></i>
                      </a>
                  </div>
                  <div class="col-md-6 text-right footer-item">
                      <a href="{{url('proyectos')}}/{{$result_proyectos_redes->url_proyecto}}" class="btn btn-info btn-circle btn-sm"  target="_blank" data-toggle="tooltip" data-placement="top" title="Ver proyecto">
                        <i class="far fa-eye"></i>
                      </a>
                      <form action="{{ route('app_redes_edit_proyectos')}}" method="post" style="display: inline-flex; align-items: center; justify-content: center;">
                          {!! csrf_field() !!}
                      <input type="hidden" name="id_proyecto" id="id_proyecto" value="{{$result_proyectos_redes->id_proyecto}}">
                      <button type="submit" class="btn btn-warning btn-circle btn-sm"><i class="fas fa-edit"></i></button>                                    
                      
                      </form>
                      
                      <?php /*
                      <a href="#" class="btn btn-success btn-circle btn-sm" data-toggle="tooltip" data-placement="top" title="Agregar Cliente">
                        <i class="fas fa-user-plus"></i>
                      </a>
                      */ ?>

                  </div>
              </div>
            </div>
          </div>
        </div>

    @endforeach
@else
    <h2>No existen proyectos</h2>
@endif



