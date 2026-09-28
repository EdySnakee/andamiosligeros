@if($accion == "agregar")
	<option disabled selected>Selecciona un Cliente</option>
	@if(!$datos_clientes->isEmpty())
	  @foreach($datos_clientes as $result_datos_clientes)
	      <option value="{{$result_datos_clientes->idcl}}">{{$result_datos_clientes->nombrecl}} {{$result_datos_clientes->telefonocl}}</option>
	  @endforeach
	  @else
	      <option value="SC">Sin clientes</option>
	@endif
@elseif($accion == "editar")
	@if(!empty($datos_clientes))
	    <option value="{{$datos_clientes->idcl}}" selected>{{$datos_clientes->nombrecl}} {{$datos_clientes->telefonocl}}</option>
	  @else
	    <option value="SC">Sin cliente asignado | contacte al admin</option>
	@endif
@endif