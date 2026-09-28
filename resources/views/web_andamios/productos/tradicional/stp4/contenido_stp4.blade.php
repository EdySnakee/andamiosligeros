{{-- <section class="seccion-intro" id="modelos">
	<div class="producto-center-header">
		<div class="cont-tit-intro">
			<h3 class="text-yellow">ANDAMIO LIGERO TRADICIONAL</h3>
			<h1 class="border-title-secc">
				STP-4
			</h1>

		</div>
		<div class="cont-img-ficha">
			<img class="transform" src="{{url('web/img/andamios/psvgs/andamio-tradicional-header-STP2.webp')}}" alt="">
		</div>
		<div class="piso">
			<img src="{{url('web/img/suelo-red.webp')}}" alt="">
		</div>
	</div>
</section> --}}

{{-- <section class="seccion-fichas">
	<div class="contenido-fichas">
		<div class="grid-flex wrapper">
			<div class="ficha-t ficha-d">
				<div class="tit-ficha">
					<h3>Descripción <i class="fa fa-file-text" aria-hidden="true"></i></h3>
				</div>
				<div class="txt-ficha">
					<p>Andamio tradicional de 4 peldaños en la escalerilla, con cruceta tipo tijeras, es ideal para alcanzar gran altura y con su área de trabajo de 2.5m2 crea un espacio cómodo en la plataforma. Además la distancia entre peldaños permite al trabajador acceder por el fácilmente.</p>
				</div>
			</div>
			<div class="ficha-t ficha-mat">
				<div class="tit-ficha">
					<h3>Materiales <i class="fa fa-cogs" aria-hidden="true"></i></h3>
				</div>
				<div class="txt-ficha text-center">
					<ul>
						<li><p>Tubería acero galvanizadaode 1,1/2 pulgadas.</p></li>
						<li><p>Soldadura en microalambre</p></li>
						<li><p>Acabado en electrogalvanizado.</p></li>
						<li><p>Perno de seguridad de acero tipo mariposa.</p></li>
						<li><p>Niples de ensamble en Acero</p></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section> --}}




{{-- HERO --}}
@include('web_andamios.productos.tradicional.stp4.components.hero_producto.hero')

{{-- SEPARADOR 1 --}}
@include('web_andamios.productos.tradicional.stp4.components.separador_producto.separador')

{{-- BONDADES --}}
@include('web_andamios.productos.tradicional.stp4.components.bondades_producto.bondades')

{{-- GALERIA --}}
@include('web_andamios.productos.tradicional.stp4.components.galeria_producto.galeria')

{{-- DROP --}}
@include('web_andamios.productos.tradicional.stp4.components.drop_producto.drop')



{{-- CONFIRMACIONES Y MARCAS --}}
<section class="seccion-fichas pb2 mb-3">
    <div class="contenido-fichas">
        <div class="cont-materiales">
            <div class="grid-flex wrapper">
                <div class="menu-mat">
                    <div class="cont-menu-mat">
                        <div class="tit-mat">
                            <h3><i class="fa fa-arrows" aria-hidden="true"></i> MEDIDAS MODELO STP-4</h3>
                        </div>
                    </div>
                    <ul>
                        <li><a href="#" class="btn-med active-med" attr-med="altura">Altura</a></li>
                        <li><a href="#" class="btn-med" attr-med="ancho">Ancho</a></li>
                        <li><a href="#" class="btn-med" attr-med="longitud">Longitud</a></li>
                        <li><a href="#" class="btn-med" attr-med="entrepeldano">Entrepeldaño</a></li>
                        <li><a href="#" class="btn-med" attr-med="niple">Niple</a></li>
                        <li><a href="#" class="btn-med" attr-med="peldano">Peldaño</a></li>
                        <li><a href="#" class="btn-med" attr-med="perno_superior">Perno superior</a></li>
                        <li><a href="#" class="btn-med" attr-med="perno_inferior">Perno inferior</a></li>
                    </ul>
                </div>
            </div>
            <div class="grid-flex wrapper">
                <div class="cont-img-svg">
                    @include('web_andamios.productos.tradicional.stp4.img-svg-stp4')
                </div>
            </div>
            {{-- <div class="grid-flex wrapper">
                <div class="infopeso">
                    <h2><b>Peso Total: 26kg</b></h2>
                    <br>

                    <a id="open_ficha" attr-ficha="andamios-ligeros-galvanizados-tradicionales-4-peldanos-STP4.pdf" class="btn-slide btn-vermas">Descargar ficha técnica</a>
                    <a id="cotizar" href="#" class="btn-slide btn-cotizar-s" data-product="Andamios Ligeros Tradicionales STP4">Cotizar</a>
               
				</div>
             
            </div> --}}
			<div class="row">
				<div class="col-12 text-center">
					<a id="cotizar" href="#" class="hero-btn"
						data-product="Andamios Ligeros Tradicionales STP4">
						COTIZAR AHORA</a>
				</div>
			</div>
        </div>
    </div>
</section>

{{-- SEPARADOR 2 --}}
@include('web_andamios.productos.tradicional.stp4.components.separador_producto.separador')

{{-- PREGUNTAS --}}
@include('web_andamios.productos.tradicional.stp4.components.preguntas_producto.preguntas')

{{-- CAROUSEL --}}
@include('web_andamios.productos.tradicional.stp4.components.carousel_marcas_producto.carousel')


{{-- BANNER OFICIAL --}}
@include('web_andamios.index.banner-financial')
