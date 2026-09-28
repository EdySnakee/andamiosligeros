@include('web_redes.includes.menu-top')
<header id="menu-principal">
    <div class="ten columns offset-by-one">
        <div class="row">
            <div class="twelve columns logo">
                <a class="menu-itemns" href="{{ url('/') }}" title="">
                    <img class="light" src="{{url('web/imagenes/originales/redes-anticaidas-logotipo-largo.svg')}}" alt="Redesanticaidas.mx logotipo">
                    <img class="dark" src="{{url('web/imagenes/originales/redes-anticaidas-logotipo-largo.svg')}}" alt="Redesanticaidas.mx logotipo">
                </a>
                <div class="menu-itemns itemsm">
                    <div class="menu-icon">
                        <span class="top"></span>
                        <span class="middle"></span>
                        <span class="bottom"></span>
                    </div>
                    <nav class="onepage">
                        <ul>
                            <li class=""><a href="{{ url('/') }}">INICIO</a></li>
                            <li><a href="{{ url('/sistema-t') }}">SISTEMA T</a></li>
                            <li><a href="{{ url('/sistema-s') }}">SISTEMA S</a></li>
                            <li><a href="{{ url('/sistema-u') }}">SISTEMA U</a></li>
                            <li><a href="{{ url('/sistema-v') }}">SISTEMA V</a></li>
                            <li><a href="#contacto">CONTACTO</a></li>

                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="c-header-mobile-close-trigger"></div>
@include('web_redes.includes.redes_sociales_web')