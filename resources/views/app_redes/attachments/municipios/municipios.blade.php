<option value="SC" disabled selected>Selecciona una Ciudad</option>
@foreach($estados as $estado)
    <option value="{{$estado->idmunicipio}}">{{$estado->municipio}}</option>
@endforeach
