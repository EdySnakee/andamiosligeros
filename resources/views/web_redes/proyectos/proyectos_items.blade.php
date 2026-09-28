
@if(!$datos_clientes->isEmpty())
    @foreach($datos_clientes as $info_clientes)
	    <div class="grid-gallery__item item_proyecto animate__animated animate__bounceInUp">
	        <a class="info_cliente" class="tit_proyecto" href="{{url('obras')}}/{{$info_clientes->url_cliente}}" target="_blank">{{$info_clientes->nombre_cliente}}</a>
	        <img class="grid-gallery__image" src="{{url('storage/clientes/portadas')}}/{{$info_clientes->id_proyecto}}/{{$info_clientes->id_cliente}}/{{$info_clientes->imagenp}}" alt="">
	    </div>
    @endforeach
@else
    <h5>SIN PROYECTOS CREADOS</h5>
@endif