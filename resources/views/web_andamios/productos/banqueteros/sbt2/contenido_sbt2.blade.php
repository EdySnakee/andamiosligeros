<section class="seccion-intro" id="modelos">
    <div class="producto-center-header">
        <div class="cont-tit-intro">
            <h3 class="text-yellow">ANDAMIO LIGERO BANQUETERO</h3>
            <h1 class="border-title-secc">
                SBT-2
            </h1>

        </div>
        <div class="cont-img-ficha">
            <img src="{{ url('web/img/andamios/andamio-ligero-galvanizado-banquetero-sbt-2.webp') }}" alt="">
        </div>
        <div class="piso">
            <img src="{{ url('web/img/suelo-red.webp') }}" alt="">
        </div>
    </div>
</section>

{{-- SEPARADOR 1 --}}
@include('web_andamios.productos.banqueteros.sbt6.components.separador_producto.separador')

{{-- BONDADES --}}
@include('web_andamios.productos.banqueteros.sbt6.components.bondades_producto.bondades')

{{-- GALERIA --}}
@include('web_andamios.productos.banqueteros.sbt2.galeria_producto.galeria')

{{-- DROP --}}
@include('web_andamios.productos.banqueteros.sbt2.drop_producto.drop')

{{-- GIF DEL PRODUCTO --}}
@include('web_andamios.productos.banqueteros.sbt6.components.gif_producto.gif-producto')

{{-- <section class="seccion-fichas">
    <div class="contenido-fichas">
        <div class="grid-flex wrapper">
            <div class="ficha-t ficha-d">
                <div class="tit-ficha">
                    <h3>Descripción <i class="fa fa-file-text" aria-hidden="true"></i></h3>
                </div>
                <div class="txt-ficha">
                    <p>Andamio banquetero de cuatro peldaños, el mas práctico en su tipo, es ideal para obras ligeras,
                        trabajos en interior y espacios reducidos, con sus cuatro peldaños permite el acceso a través de
                        el.</p>
                </div>
            </div>
            <div class="ficha-t ficha-mat">
                <div class="tit-ficha">
                    <h3>Materiales <i class="fa fa-cogs" aria-hidden="true"></i></h3>
                </div>
                <div class="txt-ficha">
                    <p>Tubería galvanizada de 1,1/2 pulgadas. Cal. 18 <br> Soldadura de microalambre de acero al bajo
                        <br> Carbono con núcleo fundente. <br> Acabado en electrogalvanizado. <br> Pernos de seguridad
                        en acero de 1/2 <br> Pulgadas con mariposa. <br> Niples en acero 1, 1/4 de pulgada cédula 30.
                        <br> Pasadoores en acero de 1/4 pulgada.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section> --}}

{{-- <section class="seccion-fichas pb2">
    <div class="contenido-fichas">
        <div class="cont-materiales">
            <div class="grid-flex wrapper">
                <div class="infopeso">
                    <h2><b>Peso Total: 21kg</b></h2>
                    <br>
                    <a id="open_ficha" attr-ficha="andamios-ligeros-galvanizados-baqueteros-4-peldanos-SBT2.pdf"
                        class="btn-slide btn-vermas">Descargar ficha técnica</a>
                    <a id="cotizar" href="#" class="btn-slide btn-cotizar-s"
                        data-product="Andamios Ligeros Tradicionales STP2">Cotizar</a>
                </div>
            </div>
        </div>
    </div>
</section> --}}

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


{{-- CARACTERISTICAS --}}
{{-- @include('web_andamios.productos.banqueteros.sbt6.components.caracteristicas.caracteristicas') --}}


{{-- PREGUNTAS --}}
@include('web_andamios.productos.banqueteros.sbt2.preguntas_producto.preguntas')


{{-- CAROUSEL TESTIMONNIOS --}}
@include('web_andamios.productos.banqueteros.sbt6.components.carousel_testimonios.carousel_testimonios')


{{-- SEPARADOR 2 --}}
@include('web_andamios.productos.banqueteros.sbt6.components.separador_producto.separador')

{{-- VIDEOS --}}
@include('web_andamios.productos.banqueteros.sbt6.components.videos_producto.videos_producto')


{{-- CAROUSEL --}}
@include('web_andamios.productos.banqueteros.sbt6.components.carousel_marcas_producto.carousel')


{{-- BANNER OFICIAL --}}
@include('web_andamios.index.banner-financial')
