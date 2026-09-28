@if(!$result_clientes->isEmpty())
    <div class="cont-busqueda">
        @foreach($result_clientes as $itemcl)
            <div data-idcl="{{$itemcl->idcl}}">{{$itemcl->nombrecl}} {{$itemcl->telefonocl}}</div>
        @endforeach
    </div>
@else
    <div value="SC">Sin clientes</div>
@endif