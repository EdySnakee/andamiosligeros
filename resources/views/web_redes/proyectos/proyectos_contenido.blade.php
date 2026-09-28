<div class="o-container-fluid">
    <div class="row">
        <div class="twelve columns">
            <div class="portada-proyectos">
                <div class="cont-text-proyectos text-center">
                    <h1 class="font-ant-titulos tit-color-purple">PROYECTOS</h1>
                    <h2 class="font-ant-titulos tit-color-white">MALLAS ANTICAIDAS</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="o-container-fluid">
    <div class="cinetic-divider-large u-hide-desktop"></div>
    <div class="row">
        <div class="ten columns offset-by-one">
            <div class="row">
                <div class="twelve columns">
                    <div class="o-text-wrapper">
                        <ul class="proyectos-estados">
                            @if(!$datos_estados->isEmpty())
                                @foreach($datos_estados as $info_estados)
                                    <li><a href="#" data-id-proyecto="{{$info_estados->id_proyecto}}" id="select_estado" class="select_estado">{{$info_estados->estado}}</a></li>
                                @endforeach
                            @else
                                <h5>SIN PROYECTOS CREADOS</h5>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="twelve columns text-justify">
                    <div class="row">
                        <div class="twelve columns text-center">
                            <div id="urlproyectos">
                                <a class="btn_proyectos_ind" href="{{url('/proyectos')}}/{{$datos_clientes[0]['url_proyecto']}}" target="_blank">Ver todas las obras en {{$datos_clientes[0]['estado']}} </a>
                            </div>
                        </div>
                    </div>
                    <div class="grid-gallery" id="cont_proyectos">
                        
                        @include('web_redes.proyectos.proyectos_items')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>