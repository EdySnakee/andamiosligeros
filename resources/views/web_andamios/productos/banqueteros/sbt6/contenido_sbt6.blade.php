
{{-- HERO --}}
@include('web_andamios.productos.banqueteros.sbt6.components.hero_producto.hero')

{{-- SEPARADOR 1 --}}
@include('web_andamios.productos.banqueteros.sbt6.components.separador_producto.separador')

{{-- BONDADES --}}
@include('web_andamios.productos.banqueteros.sbt6.components.bondades_producto.bondades')

{{-- GALERIA --}}
@include('web_andamios.productos.banqueteros.sbt6.components.galeria_producto.galeria')

{{-- DROP --}}
@include('web_andamios.productos.banqueteros.sbt6.components.drop_producto.drop')

{{-- GIF DEL PRODUCTO --}}
@include('web_andamios.productos.banqueteros.sbt6.components.gif_producto.gif-producto')

{{-- SEPARADOR 3 --}}
<section class="mb-4">
    @include('web_andamios.productos.banqueteros.sbt6.components.separador_producto.separador')
</section>

{{-- COMPONENTES --}}
@include('web_andamios.productos.banqueteros.sbt6.components.componentes_producto.componentes')

{{-- IMG-COMPONENTES --}}
@include('web_andamios.productos.banqueteros.sbt6.components.img-complementos.img_complementos')


{{-- PAQUETES --}}
@include('web_andamios.productos.banqueteros.sbt6.components.cards_paquetes.cards_paquetes')

{{-- SEPARADOR 3 --}}
<section class="mb-4">
    @include('web_andamios.productos.banqueteros.sbt6.components.separador_producto.separador')
</section>

{{-- MEDIDAS --}}
<section class="seccion-fichas">
    <div style="text-align:center; margin: 2rem 0;">
        <h2
            style="
      color:#FACC15;
      font-size:2.5rem;
      font-weight:700;
      margin-bottom:3rem;
      line-height:1.2;
      font-family:system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
  ">
            Andamio <b style="color:#1E3A8A;">SBT-6</b>
        </h2>

        <a class="hero-btn" href="{{ url('/promociones/promocion-plataforma-gratis-en-la-compra-de-tu-andamio') }}">
            COMPRAR AHORA
        </a>
    </div>

    <div class="contenido-fichas">
        <div class="grid-flex wrapper">
            <div class="cont-img-svg">
                @include('web_andamios.productos.banqueteros.sbt6.img-svg-sbt-6')
            </div>
        </div>
        <div class="grid-flex wrapper">
            <div class="menu-mat">
                <ul>
                    <li><a href="#" class="btn-med " attr-med="altura">Altura</a></li>
                    <li><a href="#" class="btn-med" attr-med="ancho">Ancho</a></li>
                    <li><a href="#" class="btn-med active-med" attr-med="longitud">Longitud</a></li>
                </ul>
                <div class="cont-menu-mat">
                    <div class="tit-mat">
                        <h3><i class="fa fa-arrows" aria-hidden="true"></i> MEDIDAS MODELO SBT-6</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="row my-4">
			<div class="col-12 text-center">
                <a class="hero-btn" href="{{ url('/tienda/andamio-plegable-galvanizado-multiusos-sbt-6') }}">
					COMPRAR AHORA</a>
			</div>
		</div> --}}

    </div>
</section>


{{-- CARACTERISTICAS --}}
@include('web_andamios.productos.banqueteros.sbt6.components.caracteristicas.caracteristicas')


{{-- PREGUNTAS --}}
@include('web_andamios.productos.banqueteros.sbt6.components.preguntas_producto.preguntas')


{{-- CAROUSEL TESTIMONNIOS --}}
@include('web_andamios.productos.banqueteros.sbt6.components.carousel_testimonios.carousel_testimonios')


{{-- SEPARADOR 2 --}}
@include('web_andamios.productos.banqueteros.sbt6.components.separador_producto.separador')



{{-- IMG INTERACTIVA --}}
@include('web_andamios.productos.banqueteros.sbt6.components.imagen_interactiva.sbt6-explainer')


{{-- VIDEOS --}}
@include('web_andamios.productos.banqueteros.sbt6.components.videos_producto.videos_producto')


{{-- CAROUSEL --}}
@include('web_andamios.productos.banqueteros.sbt6.components.carousel_marcas_producto.carousel')


{{-- BANNER OFICIAL --}}
@include('web_andamios.index.banner-financial')
