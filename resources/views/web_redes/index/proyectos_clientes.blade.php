<div id="proyectos" class="o-container-fluid">
    <div class="row">
        <div class="eight columns offset-by-two">
            <div class="o-text-wrapper-mobile">
                <div class="cinetic-divider-huge text-center"></div>
                <h2 class="font-ant-titulos color-purple-txt text-center"> PROYECTOS Y CLIENTES</strong></h2>
                <p class="hero-p text-center">MALLAS ANTICAIDAS instalaciones, reúne todas las exigencias del CLIENTE; diseñando y materializando un "traje" a la medida y necesidades del mismo; con la PROVIDAD profesional y la HONESTIDAD a conciencia plena y a verdad sabida. </p>
                <div class="cinetic-divider"></div>
            </div>
        </div>
        <div class="slider-wrapper ten columns offset-by-one">
            <div class="swiper-container twelve columns">
                <div class="swiper-wrapper">
                    @if(!$datos_clientes->isEmpty())
                        @foreach($datos_clientes as $info_slider)
                            <div class="swiper-slide">
                                <div class="o-container-fluid">
                                    <div class="row">
                                        <div class="twelve columns">
                                            <div class="slide-inner">
                                                <div class="parallax">
                                                    <div class="c-bg-img" style="background-image: url({{url('storage/clientes/portadas')}}/{{$info_slider->id_proyecto}}/{{$info_slider->id_cliente}}/{{$info_slider->imagenp}}"></div>
                                                    <div class="cinetic-divider-75vh"></div>
                                                    <div class="cinetic-slider-text-wrapper">
                                                        <h4 class="cinetic-slider-text u-color-white"><span class="cinetic-slider-text-animation">{{$info_slider->estado}}, </span> <span class="u-p cinetic-slider-text-animation">{{$info_slider->nombre_cliente}}</span></h4>
                                                    </div>
                                                    <div class="see-project-slider">
                                                        <div class="see-project-wrapper-slider">
                                                            <div class="see-project-text-slider"> Ver obras </div>
                                                        </div>
                                                    </div><a target="_blank" href="{{url('proyectos')}}/{{$info_slider->url_proyecto}}"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h1>SIN PROYECTOS CREADOS</h1>
                    @endif
                </div>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"><img src="{{url('web/img/icon-arrow-left-black.svg')}}" /></div>
            <div class="swiper-button-next"><img src="{{url('web/img/icon-arrow-right-white.svg')}}" /></div>
            <div class="progress-bar"></div>
            <div class="slider-count">
                <div class="current-slide">1</div>
                <div class="total-slide"> / 11</div>
            </div>
        </div>
    </div>
</div>