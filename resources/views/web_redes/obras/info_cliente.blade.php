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
            <style>
            .conttems {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
            }
            .conttems a {
                margin-top: 2rem;
            }
            .conttems a:hover .nombre_cliente {
                background: transparent;
                transition: 0.3s;
            }

            .conttems a {
                margin-top: 2rem;
            }
            .conttems a:hover .nombre_cliente h5 {
                color: #ffffff;
                text-shadow: 1px 1px 1px #333;
            }
            .conttems .item {
                margin-top: 2rem;
            }
            </style>
            <div class="conttems">
                @foreach($galeriaClientesRedes as $result_datos_galeira)
                    <div class="item">
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
    <h1>SIN INFORMACIÓN DEL CLIENTE</h1>
@endif

