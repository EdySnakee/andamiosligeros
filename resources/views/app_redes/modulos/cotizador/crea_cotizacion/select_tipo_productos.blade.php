@if(!$info_productos->isEmpty())
	<option disabled selected>Selecciona un producto</option>
  @foreach($info_productos as $result_productos)
      <option value="{{$result_productos->id_producto}}">{{$result_productos->nombre_p}}</option>
  @endforeach
  @else
      <option value="SC">Sin productos</option>
@endif