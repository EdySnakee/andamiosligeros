<option value="none" disabled selected>Seleccione una opción</option>;
@foreach($estados as $estado)
    <option value="{{$estado->idmunicipio}}" data-municipio="{{$estado->municipio}}">{{$estado->municipio}}</option>
@endforeach

