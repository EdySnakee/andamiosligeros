@if(isset($galeriaClientesRedes) AND isset($clientesRedes))
    <div class="container-fluid token-sale p-tb">
        <div class="container postx mostrar" id="id0">
            <div class="sec-title text-center">
                <h3>{{(!empty($clientesRedes->nombre_cliente)) ? $clientesRedes->nombre_cliente : ''}}</h3>
            </div>
            <?php echo (!empty($clientesRedes->contenido_html)) ? $clientesRedes->contenido_html : ''?>
        </div>
    </div>
    <div class="container-fluid galeria">
        <div class="container sec-title text-center">
            <h3>Galería de Proyecto</h3>
        </div>
        <div class="container">
            <div id="galeria" class="owl-carousel">
                @foreach($galeriaClientesRedes as $result_datos_galeira)
                    <div class="item">
                        <div class="col">
                            @if($result_datos_galeira->img_galeria != "")
                            <a href="{{url('storage/clientes/galerias')}}/{{$result_datos_galeira->id_proyecto}}/{{$result_datos_galeira->id_cliente}}/{{$result_datos_galeira->img_galeria}}"  data-transition="crossfade" data-thumbnail="{{url('storage/clientes/galerias')}}/{{$result_datos_galeira->id_proyecto}}/{{$result_datos_galeira->id_cliente}}/{{$result_datos_galeira->img_galeria}}" class="html5lightbox galeriaItem" data-group="set1" data-width="100%" data-height="100%">
                                <div class="imagenp text-center" style="background: url('{{url('storage/clientes/galerias')}}/{{$result_datos_galeira->id_proyecto}}/{{$result_datos_galeira->id_cliente}}/{{$result_datos_galeira->img_galeria}}')">
                                </div>
                            </a>
                            @else
                            <a href="{{url('storage/notfound.jpg')}}"  data-transition="crossfade" data-thumbnail="{{url('storage/notfound.jpg')}}" class="html5lightbox galeriaItem" data-group="set1" data-width="100%" data-height="100%">
                                <div class="imagenp text-center" style="background:url ('{{url('storage/notfound.jpg')}}')">
                                </div>
                            </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="container-fluid mapacliente">
        <div class="container sec-title text-center">
            <h3>Ubicación de Proyecto</h3>
        </div>
        <div class="p-tb" id="mapa" 
        data-coordenadas="[
        [{{(!empty($clientesRedes->latitud)) ? $clientesRedes->latitud : ''}},{{(!empty($clientesRedes->longitud)) ? $clientesRedes->longitud : ''}}]
        ]">
        </div>
    </div>
@else
    <div class="container-fluid token-sale p-tb">
        <div class="container postx mostrar" id="id0">
            <div class="sec-title text-center">
                <h3>{{(!empty($clientesRedes[0]["nombre_cliente"])) ? $clientesRedes[0]["nombre_cliente"] : ''}}</h3>
            </div>
            <?php echo (!empty($clientesRedes[0]["contenido_html"])) ? $clientesRedes[0]["contenido_html"] : ''?>
        </div>
    </div>
    <div class="container-fluid galeria">
        <div class="container sec-title text-center">
            <h3>Galería de Proyecto</h3>
        </div>
        <div class="container">
            <div id="galeria" class="owl-carousel">
                @foreach($galeriaClientesRedesArray as $result_datos_galeira)
                    @if($result_datos_galeira->id_cliente == $clientesRedes[0]['id_cliente'])
                        <div class="item">
                            <div class="col">
                                @if($result_datos_galeira->img_galeria != "")
                                    <a href="{{url('storage/clientes/galerias')}}/{{$result_datos_galeira->id_proyecto}}/{{$result_datos_galeira->id_cliente}}/{{$result_datos_galeira->img_galeria}}"  data-transition="crossfade" data-thumbnail="{{url('storage/clientes/galerias')}}/{{$result_datos_galeira->id_proyecto}}/{{$result_datos_galeira->id_cliente}}/{{$result_datos_galeira->img_galeria}}" class="html5lightbox" data-group="set1" data-width="100%" data-height="100%">
                                        <div class="imagenp text-center" style="background: url('{{url('storage/clientes/galerias')}}/{{$result_datos_galeira->id_proyecto}}/{{$result_datos_galeira->id_cliente}}/{{$result_datos_galeira->img_galeria}}')">
                                        </div>
                                    </a>
                                @else
                                    <a href="{{url('storage/notfound.jpg')}}"  data-transition="crossfade" data-thumbnail="{{url('storage/notfound.jpg')}}" class="html5lightbox" data-group="set1" data-width="100%" data-height="100%">
                                        <div class="imagenp text-center" style="background:url ('{{url('storage/notfound.jpg')}}')">
                                        </div>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <div class="container-fluid mapacliente">
        <div class="container sec-title text-center">
            <h3>Ubicación de Proyecto</h3>
        </div>
        <div class="p-tb" id="mapa" 
        data-coordenadas="[
        [{{(!empty($clientesRedes[0]['latitud'])) ? $clientesRedes[0]['latitud'] : ''}},{{(!empty($clientesRedes[0]['longitud'])) ? $clientesRedes[0]['longitud'] : ''}}]
        ]">
        </div>
    </div>
@endif

