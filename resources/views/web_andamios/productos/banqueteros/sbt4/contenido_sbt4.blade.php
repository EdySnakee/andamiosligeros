{{-- <section class="seccion-intro" id="modelos">
	<div class="product-andamio">
		<div class="cont-tit-intro-n">
			<div class="item-tit">
				<img src="{{url('web/img/andamio-ligero-galvanizado-banquetero-sbt4.webp')}}" alt="">
<div class="boton-item">
	<a href="{{url('/promociones')}}" class="btn-land-promo">SOLICTAR PRECIO PROMOCIONAL</a>
</div>
</div>
</div>
<div class="cont-img-andamio">
	<img src="{{url('web/img/andamios/andamio-ligero-galvanizado-pasillero-sbt-4.webp')}}" alt="Andamios Ligeros Galvanizados Banquetero">

</div>
</div>
<a href="#thanks" class="scroll-down-a"><span></span></a>
</section> --}}



{{-- HERO --}}
@include('web_andamios.productos.banqueteros.sbt4.components.hero_producto.hero')

{{-- SEPARADOR 1 --}}
@include('web_andamios.productos.banqueteros.sbt4.components.separador_producto.separador')

{{-- BONDADES --}}
@include('web_andamios.productos.banqueteros.sbt4.components.bondades_producto.bondades')

{{-- GALERIA --}}
@include('web_andamios.productos.banqueteros.sbt4.components.galeria_producto.galeria')

{{-- DROP --}}
@include('web_andamios.productos.banqueteros.sbt4.components.drop_producto.drop')

{{-- GIF DEL PRODUCTO --}}
@include('web_andamios.productos.banqueteros.sbt4.components.gif_producto.gif-producto')

<section class="mb-4">
	@include('web_andamios.productos.banqueteros.sbt4.components.separador_producto.separador')
</section>

{{-- COMPONENTES --}}
@include('web_andamios.productos.banqueteros.sbt4.components.componentes_producto.componentes')

{{-- IMG-COMPONENTES --}}
@include('web_andamios.productos.banqueteros.sbt4.components.img-complementos.img_complementos')

{{-- PAQUETES --}}
@include('web_andamios.productos.banqueteros.sbt4.components.cards_paquetes.cards_paquetes')

<section class="mb-4">
	@include('web_andamios.productos.banqueteros.sbt4.components.separador_producto.separador')
</section>

{{-- MEDIDAS --}}
@include('web_andamios.productos.banqueteros.sbt4.detalle_sbt4')

{{-- CARACTERISTICAS --}}
<section style="margin-top: 80px;">
	@include('web_andamios.productos.banqueteros.sbt4.components.caracteristicas.caracteristicas')
</section>

{{-- SEPARADOR 2 --}}
<section style="margin-top: 80px;">
@include('web_andamios.productos.banqueteros.sbt4.components.separador_producto.separador')
</section>

{{-- PREGUNTAS --}}
@include('web_andamios.productos.banqueteros.sbt4.components.preguntas_producto.preguntas')

{{-- CAROUSEL TESTIMONNIOS --}}
@include('web_andamios.productos.banqueteros.sbt4.components.carousel_testimonios.carousel_testimonios')

<section style="margin-top: 80px;">
@include('web_andamios.productos.banqueteros.sbt4.components.separador_producto.separador')
</section>

{{-- IMG INTERACTIVA --}}
@include('web_andamios.productos.banqueteros.sbt4.components.imagen_interactiva.sbt6-explainer')

{{-- VIDEOS --}}
@include('web_andamios.productos.banqueteros.sbt4.components.videos_producto.videos_producto')

{{-- CAROUSEL --}}
@include('web_andamios.productos.banqueteros.sbt4.components.carousel_marcas_producto.carousel')

{{-- BANNER OFICIAL --}}
@include('web_andamios.index.banner-financial')
