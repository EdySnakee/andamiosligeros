<!-- Hero Section Start -->

<div class="hero-main white-sec" style="background: url('{{url('storage/proyectos')}}/{{$Proyectos->id_proyecto}}/{{$Proyectos->img_portada}}')">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-12 col-md-5 hero-left cont-text-banner wow fadeIn" data-wow-delay="0.5s">
                <div class="sec-title">
                    <h1>{{$Proyectos->nombre_proyecto}}</h1>
                </div>
                <p>
                    {{$Proyectos->descripcion}}
                </p>
            </div>
            <div class="col-sm-12 col-md-6 wow fadeIn" data-wow-delay="0.5s">
                
            </div>
        </div>
    </div>
    <?php /*
    */ ?>
</div>
<!-- Hero Section End -->
<!-- Brand logo slider -->
<div class="brand-logo-slider">
    <div class="container">
        <div class="brand-logos owl-carousel">
            <div class="item"><img src="{{url('landing/clientes/Cliente-3M.png')}}" alt="Cliente 3M" /></div>
            <div class="item"><img src="{{url('landing/clientes/Cliente-Abitat.png')}}" alt="Cliente Abitat" /></div>
            <div class="item"><img src="{{url('landing/clientes/Cliente-AKRA.png')}}" alt="Cliente AKRA" /></div>
            <div class="item"><img src="{{url('landing/clientes/Cliente-Anahuac-Organizacion-Constructora.png')}}" alt="Cliente Anahuac Organizacion Constructora" /></div>
            <div class="item"><img src="{{url('landing/clientes/Cliente-AUDI.png')}}" alt="Cliente AUDI" /></div>
            <div class="item"><img src="{{url('landing/clientes/Cliente-Autopistas-Michoacan.png')}}" alt="CCliente Autopistas Michoacan" /></div>
            <div class="item"><img src="{{url('landing/clientes/Cliente-CEMEX.png')}}" alt="Cliente CEMEX" /></div>
            <div class="item"><img src="{{url('landing/clientes/Cliente-CIMESA.png')}}" alt="Cliente CIMESA" /></div>
            <div class="item"><img src="{{url('landing/clientes/Cliente-Constructora-Anglo.png')}}" alt="Cliente Constructora Anglo" /></div>
            <div class="item"><img src="{{url('landing/clientes/Cliente-Constructora-CHUFANI.png')}}" alt="Cliente Constructora CHUFANI" /></div>
            <div class="item"><img src="{{url('landing/clientes/Cliente-Freyssinet.png')}}" alt="Cliente Freyssinet" /></div>
            <div class="item"><img src="{{url('landing/clientes/Cliente-FUJITA.png')}}" alt="Cliente FUJITA" /></div>
            <div class="item"><img src="{{url('landing/clientes/CLiente-GIM.png')}}" alt="CLiente GIM" /></div>
            <div class="item"><img src="{{url('landing/clientes/Cliente-Grupo-Copri.png')}}" alt="Cliente Grupo Copri" /></div>
            <div class="item"><img src="{{url('landing/clientes/Cliente-Grupo-DAGS.png')}}" alt="Cliente Grupo DAGS" /></div>
            <div class="item"><img src="{{url('landing/clientes/Cliente-Grupo-R.png')}}" alt="Cliente Grupo R" /></div>
            <div class="item"><img src="{{url('landing/clientes/Cliente-Hazama.png')}}" alt="Cliente Hazama" /></div>
            <div class="item"><img src="{{url('landing/clientes/Cliente-ICA.png')}}" alt="Cliente ICA" /></div>
            <div class="item"><img src="{{url('landing/clientes/Cliente-Kepler.png')}}" alt="Cliente Kepler" /></div>
            <div class="item"><img src="{{url('landing/clientes/Cliente-Lackma-Constructora.png')}}" alt="Cliente Lackma Constructora" /></div>
            <div class="item"><img src="{{url('landing/clientes/Cliente-Metcon.png')}}" alt="Cliente Metcon" /></div>
            <div class="item"><img src="{{url('landing/clientes/Cliente-Pladis-Proyectos-Integrales.png')}}" alt="Cliente Pladis Proyectos Integrales" /></div>
            <div class="item"><img src="{{url('landing/clientes/Cliente-Postensa.png')}}" alt="Cliente Postensa" /></div>
            <div class="item"><img src="{{url('landing/clientes/Cliente-Saipem.png')}}" alt="Cliente Saipem" /></div>
            <div class="item"><img src="{{url('landing/clientes/Cliente-Vidrios-y-Cristales-Ontiveros.png')}}" alt="Cliente Vidrios y Cristales Ontiveros" /></div>
            <div class="item"><img src="{{url('landing/clientes/Cliente-Ximetria.png')}}" alt="Cliente Ximetria" /></div>
        </div>
    </div>
</div>
<!-- Brand logo end -->
<!-- Our Mission Start -->
<div class="our-mission p-t" id="about">
    <div class="container">
        <div class="sec-title text-center">
            <h3>{{$Proyectos->nombre_proyecto}}</h3>
        </div>
        <div class="sub-txt text-center">
            <p>{{$Proyectos->descripcion}}</p>
        </div>
    </div>
    <div class="row secc-clientes">
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
            </style>
            <div class="conttems">
                @if(!$clientesRedes->isEmpty())
                    @foreach($clientesRedes as $result_datos_clientes)
                        @if($result_datos_clientes->id_cliente)
                            <a href="{{url('/obras')}}/{{$result_datos_clientes->url_cliente}}" target="_blank" id-data-cliente="{{$result_datos_clientes->id_cliente}}">
                                <div class="item">
                                    <div class="col">
                                        @if($result_datos_clientes->imagenp != "")
                                        <div class="imagenp text-center" style="background: url('{{url('storage/clientes/portadas')}}/{{$Proyectos->id_proyecto}}/{{$result_datos_clientes->id_cliente}}/{{$result_datos_clientes->imagenp}}');">
                                            <div class="nombre_cliente">
                                                <h5>{{$result_datos_clientes->nombre_cliente}}</h5>
                                            </div>
                                        </div>
                                        @else
                                        <div class="imagenp text-center" style="background: url('{{url('storage/notfound.jpg')}}');">
                                            <img src="{{url('storage/notfound.jpg')}}" class="img-fluid" alt="" />
                                            <div class="nombre_cliente">
                                                <h5>{{$result_datos_clientes->nombre_cliente}}</h5>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endif
                    @endforeach
                @else
                    <h1>no existen proyectos</h1>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- Our Mission End -->

<div id="result_info_cliente" class="row">
    @include('web_redes.proyectos.info_cliente')
</div>