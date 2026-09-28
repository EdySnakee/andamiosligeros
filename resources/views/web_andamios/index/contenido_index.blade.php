
<section  class="seccion bg-home" id="inicio">
	<div class="bg-figuras"></div>
	<div class="bg-letras"></div>
	<div class="bg-items"></div>
	<div class="grid12">
		<div class="col-item-b height100">
			<div class="text-info intro">
				<div class="img-fila1">
					<a href="{{route('web_sbt6')}}"><img src="{{url('web/img/banner/01-andamios-ligeros-plegable-sh.webp')}}" alt="Andamio liegero plegable galvanizado SBT-6"></a>
					<a href="{{route('web_stp2')}}"><img src="{{url('web/img/banner/01-andamios-ligeros-estandar.webp')}}" alt="Andamio ligero estandar STP-1"></a>
					<a href="{{url('/andamios-ligeros-galvanizados-baqueteros-SBT4')}}"><img src="{{url('web/img/banner/02-andamios-ligeros-banqueteros.webp')}}" alt="Andamios ligeros banqueteros"></a>
					<a href="{{route('web_pasarela')}}"><img src="{{url('web/img/banner/04-andamios-ligeros-pasarelas.webp')}}" alt="Andamios ligeros tipo pasarela"></a>
					<a href="{{route('web_longitudinal')}}"><img src="{{url('web/img/banner/05-andamios-ligeros-lonitudinal.webp')}}" alt="Andamios ligeros longitudinales"></a>
				</div>
				<div class="img-fila2">
					<a href="{{route('web_sbt5')}}"><img src="{{url('web/img/banner/06-andamios-ligeros-Alto3m.webp')}}" alt="andamios ligeros galvanizados baqueteros 3 metros SBT5"></a>
					<a href="{{route('web_pasilleros')}}"><img src="{{url('web/img/banner/07-andamios-ligeros-pasilleros.webp')}}" alt="andamios ligeros galvanizados pasilleros"></a>
					<a href="{{route('web_dobles')}}"><img src="{{url('web/img/banner/08-andamios-ligeros-dobles2x.webp')}}" alt="andamios ligeros galvanizados dobles"></a>
					<a href="{{route('web_plafoneros')}}"><img src="{{url('web/img/banner/09-andamios-ligeros-plafonero.webp')}}" alt="andamios ligeros galvanizados plafoneros"></a>
				</div>
			</div>
		</div>
	</div>
	<a href="#thanks" class="scroll-down-a"><span></span></a>
</section>

{{-- SEPARADOR --}}
@include('web_andamios.productos.banqueteros.sbt6.components.separador_producto.separador')
<div style="margin-bottom: 50px;"></div>

{{-- GALERIA --}}
@include('web_andamios.productos.banqueteros.sbt6.components.galeria_producto.galeria')

{{-- DROP --}}
@include('web_andamios.productos.banqueteros.sbt6.components.drop_producto.drop')

<div class="banner beneficios">
	<div class="contenido">
		<div class="grid-flex grid-items-4">
			<div class="item-seguridad">
				<div class="icono">
					<img src="{{url('web/img/iconos/icono-galvanizado.svg')}}" alt="Andamios Ligeros totalmente galvanizados" loading="lazy">
				</div>
				<div class="txt-beneficios">
					<p>Totalmente <br> Galvanizados</p>
				</div>
			</div>
			<div class="item-seguridad">
				<div class="icono">
					<img src="{{url('web/img/iconos/icono-porcent.svg')}}" alt="Andamios galvanizados 50% más ligeros, 50% más rápido." loading="lazy">
				</div>
				<div class="txt-beneficios">
					<p>más ligeros, <br> más rápidos</p>
				</div>
			</div>
			<div class="item-seguridad">
				<div class="icono">
					<img src="{{url('web/img/iconos/icono-seguridad.svg')}}" alt="Andamios ligeros los mas ligeros, mas rapidos, y los MAS SEGURO" loading="lazy">
				</div>
				<div class="txt-beneficios">
					<p>Los más <br> seguros</p>
				</div>
			</div>
			<div class="item-seguridad">
				<div class="icono">
					<img src="{{url('web/img/iconos/icono-resguardo.svg')}}" alt="Andamios Galvanizados, no requieren mantenimiento ni resguardo." loading="lazy">
				</div>
				<div class="txt-beneficios">
					<p>Sin mantenimiento,<br> ni resguardo</p>
				</div>
			</div>
		</div>
	</div>
</div>

{{-- IMG INTERACTIVA --}}
@include('web_andamios.productos.banqueteros.sbt6.components.imagen_interactiva.sbt6-explainer')

{{-- SEPARADOR --}}
@include('web_andamios.productos.banqueteros.sbt6.components.separador_producto.separador')

<section class="seccion-normal bienvenida">
	<div class="contenido">
		<div class="grid-flex wrapper">
		  <div class="col-8">
		  	<div class="texto text-justify">
		  		<h3>CONOCE</h3>
				<h1>Andamios Ligeros Galvanizados</h1>
				<p>En <b>andamios ligeros</b>, nuestro compromiso es lograr un andamio lo suficientemente seguro para el uso en obra, con una capacidad de carga óptima para trabajos en altura, y con un menor peso, facilitando así el trabajo para el personal de obra.</p>
				<p>Andamios ligeros galvanizados, Constituido en su totalidad con tubería de acero galvanizado. Haciéndolo 50% más ligero que los andamios convencionales, facilitando así el trabajo de montaje y desmontaje.</p>
		  	</div>
		  </div>
		  <div class="col-4">
		  	<div class="cont-img">
		  		<div class="cont-sombra">
		  			<img class="img-bienv" src="{{url('web/img/bienvenida_andamios_galvanizados_ligeros.webp')}}" alt="Andamios Galvanizados ligeros" loading="lazy">
		  		</div>
		  	</div>
		  </div>
		</div>
	</div>
</section>

<div class="seccion-sp">
	<div class="contenido-fluid fondo-lineas">
  		<div class="cont-img-banner">
  			<img class="img-banner" src="{{url('web/img/img-banner-andamios-ligeros.webp')}}" alt="Andamios Galvanizados ligeros" loading="lazy">
  		</div>
		<div class="cont-absolute">
			<div class="cont-float">
				<div class="texto text-white text-justify">
			  		<h3>ANDAMIOS LIGEROS</h3>
					<h1>TENDENCIA EN LA INDUSTRIA <br> DE LA CONSTRUCCIÓN</h1>
					<p>Gracias a los materiales utilizados, su modelo de fabricación y el uso como estructuras temporales en las zonas de construcciones, ha permitido ganar terreno rápidamente y convertirse en un elemento indispensable y favorito para los constructores, obreros e inversores.</p>
					<div class="cont-btn">
						<a id="cotizar" href="#" class="btn btn-cotizar btn-white" data-product="Andamios Ligeros Galvanizados">Cotizar</a>
					</div>
			  	</div>
			</div>
		</div>
	</div>
</div>

{{-- ──────────────────────────────────────────────────────────────
     SECCIÓN CATÁLOGO — Modernizada con prod-carousel-*
     ────────────────────────────────────────────────────────────── --}}
<section class="prod-carousel-section" id="andamios">

  {{-- Encabezado --}}
  <div class="prod-carousel-section__header">
    <p class="prod-carousel-section__eyebrow">Galvanizados · Certificados</p>
    <h2 class="prod-carousel-section__title">
      Descubre Nuestros<br><span>Modelos</span>
    </h2>
    <div class="prod-carousel-section__accent"></div>
  </div>

  {{-- Carrusel --}}
  <div class="prod-carousel-section__track">
    <div class="owl-carousel" id="carrousel-andamios">

      {{-- ── Slide 1: SBT-6 Plegable ── --}}
      <div class="prod-carousel-slide prod-carousel-slide--sbt6 item-carrousel">
        <div class="prod-carousel-slide__media">
          <div class="prod-carousel-slide__frame">
            <img class="prod-carousel-slide__img"
                 src="{{url('web/img/andamios/andamios-plegables-multiusos-galvanizados.webp')}}"
                 alt="Andamio Plegable SBT-6" loading="lazy">
            <span class="prod-carousel-slide__model-badge">★ SBT-6</span>
          </div>
        </div>
        <div class="prod-carousel-slide__info">
          <p class="prod-carousel-slide__label">Andamios Ligeros · Línea Exclusiva</p>
          <h3 class="prod-carousel-slide__title">Plegable <span>SBT-6</span></h3>
          <div class="prod-carousel-slide__divider"></div>
          <p class="prod-carousel-slide__desc">
            Nuestros andamios ligeros SBT-6 son fáciles de transportar gracias a su
            diseño plegable y peso reducido. Diseño robusto y seguro para trabajar en
            altura con máxima estabilidad.
          </p>
          <div class="prod-carousel-slide__specs">
            <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> Plegable</span>
            <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> 500 kg</span>
            <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> Galvanizado</span>
          </div>
          <div class="prod-carousel-slide__btns">
            <a href="{{ url('/andamios-plegables-multiusos-galvanizados') }}" class="prod-btn prod-btn--outline">
              <i class="fa fa-file-text-o"></i> Ver más
            </a>
            <a id="cotizar" href="#" class="prod-btn prod-btn--primary btn-cotizar-s"
               data-product="Andamio Plegable SBT-6">
              <i class="fa fa-comments"></i> Cotizar
            </a>
          </div>
        </div>
      </div>

      {{-- ── Slide 2: Tradicionales ── --}}
      <div class="prod-carousel-slide item-carrousel">
        <div class="prod-carousel-slide__media">
          <div class="prod-carousel-slide__frame">
            <img class="prod-carousel-slide__img"
                 src="{{url('web/img/carrousel/Andamio-Ligero-Tradicional-Galvanizado.webp')}}"
                 alt="Andamio Ligero Tradicional Galvanizado" loading="lazy">
            <span class="prod-carousel-slide__model-badge">STP</span>
          </div>
        </div>
        <div class="prod-carousel-slide__info">
          <p class="prod-carousel-slide__label">Andamios Ligeros · Uso Convencional</p>
          <h3 class="prod-carousel-slide__title"><span>Tradicionales</span></h3>
          <div class="prod-carousel-slide__divider"></div>
          <p class="prod-carousel-slide__desc">
            El más ligero en su tipo. Permite trabajar en espacios cerrados garantizando
            libertad de movimiento y fácil acceso entre peldaños. Modelos
            <strong style="color:#ffbb01">STP-1</strong> y <strong style="color:#ffbb01">STP-2</strong>.
          </p>
          <div class="prod-carousel-slide__specs">
            <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> 4–5 Peldaños</span>
            <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> 500 kg</span>
            <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> Galvanizado</span>
          </div>
          <div class="prod-carousel-slide__btns">
            <a href="{{route('web_tradicionales')}}" class="prod-btn prod-btn--outline">
              <i class="fa fa-file-text-o"></i> Ver más
            </a>
            <a id="cotizar" href="#" class="prod-btn prod-btn--primary btn-cotizar-s"
               data-product="Andamios Ligeros Tradicionales">
              <i class="fa fa-comments"></i> Cotizar
            </a>
          </div>
        </div>
      </div>

      {{-- ── Slide 3: Banqueteros ── --}}
      <div class="prod-carousel-slide item-carrousel">
        <div class="prod-carousel-slide__media">
          <div class="prod-carousel-slide__frame">
            <img class="prod-carousel-slide__img"
                 src="{{url('web/img/carrousel/Andamio-Ligero-Banquetero-Galvanizado.webp')}}"
                 alt="Andamio Ligero Galvanizado Banquetero" loading="lazy">
            <span class="prod-carousel-slide__model-badge">SBT</span>
          </div>
        </div>
        <div class="prod-carousel-slide__info">
          <p class="prod-carousel-slide__label">Andamios Ligeros · Espacios Reducidos</p>
          <h3 class="prod-carousel-slide__title"><span>Banqueteros</span></h3>
          <div class="prod-carousel-slide__divider"></div>
          <p class="prod-carousel-slide__desc">
            Ideal para espacios pequeños y trabajos en interior. No se debe apilar más
            de 5 niveles. Modelos <strong style="color:#ffbb01">SBT-1</strong>,
            <strong style="color:#ffbb01">SBT-2</strong>, <strong style="color:#ffbb01">SBT-5</strong>
            y <strong style="color:#ffbb01">SBT-6</strong>.
          </p>
          <div class="prod-carousel-slide__specs">
            <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> Interior</span>
            <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> 500 kg</span>
            <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> Galvanizado</span>
          </div>
          <div class="prod-carousel-slide__btns">
            <a href="{{route('web_banqueteros')}}" class="prod-btn prod-btn--outline">
              <i class="fa fa-file-text-o"></i> Ver más
            </a>
            <a id="cotizar" href="#" class="prod-btn prod-btn--primary btn-cotizar-s"
               data-product="Andamios Ligeros Banqueteros">
              <i class="fa fa-comments"></i> Cotizar
            </a>
          </div>
        </div>
      </div>

      {{-- ── Slide 4: Plafoneros ── --}}
      <div class="prod-carousel-slide item-carrousel">
        <div class="prod-carousel-slide__media">
          <div class="prod-carousel-slide__frame">
            <img class="prod-carousel-slide__img"
                 src="{{url('web/img/carrousel/andamio-ligero-galvanizado-barandal.webp')}}"
                 alt="Andamio Ligero Galvanizado Plafonero" loading="lazy">
            <span class="prod-carousel-slide__model-badge">SPL</span>
          </div>
        </div>
        <div class="prod-carousel-slide__info">
          <p class="prod-carousel-slide__label">Andamios Ligeros · Seguridad en Plataforma</p>
          <h3 class="prod-carousel-slide__title"><span>Plafoneros</span></h3>
          <div class="prod-carousel-slide__divider"></div>
          <p class="prod-carousel-slide__desc">
            Complemento perfecto para trabajar sobre la plataforma en el nivel más alto.
            Pasamanos y rodapiés integrados para máxima seguridad.
            Modelos <strong style="color:#ffbb01">SPL-1</strong> y <strong style="color:#ffbb01">SPL-2</strong>.
          </p>
          <div class="prod-carousel-slide__specs">
            <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> Pasamanos</span>
            <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> Rodapiés</span>
            <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> Galvanizado</span>
          </div>
          <div class="prod-carousel-slide__btns">
            <a id="cotizar" href="#" class="prod-btn prod-btn--primary btn-cotizar-s"
               data-product="Andamios Ligeros Plafoneros">
              <i class="fa fa-comments"></i> Cotizar
            </a>
          </div>
        </div>
      </div>

      {{-- ── Slide 5: Pasarela ── --}}
      <div class="prod-carousel-slide item-carrousel">
        <div class="prod-carousel-slide__media">
          <div class="prod-carousel-slide__frame">
            <img class="prod-carousel-slide__img"
                 src="{{url('web/img/carrousel/andamios-galvanizados-ligeros-tipo-pasarela.webp')}}"
                 alt="Andamio Ligero Galvanizado Tipo Pasarela" loading="lazy">
            <span class="prod-carousel-slide__model-badge">Pasarela</span>
          </div>
        </div>
        <div class="prod-carousel-slide__info">
          <p class="prod-carousel-slide__label">Andamios Ligeros · Tránsito Peatonal</p>
          <h3 class="prod-carousel-slide__title"><span>Pasarela</span></h3>
          <div class="prod-carousel-slide__divider"></div>
          <p class="prod-carousel-slide__desc">
            2 marcos que crean un puente seguro y amplio para el tránsito de peatones.
            Compatible con el andamio tradicional estándar. Capacidad de 500 kg por módulo.
          </p>
          <div class="prod-carousel-slide__specs">
            <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> Puente peatonal</span>
            <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> 500 kg</span>
            <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> Galvanizado</span>
          </div>
          <div class="prod-carousel-slide__btns">
            <a id="cotizar" href="#" class="prod-btn prod-btn--primary btn-cotizar-s"
               data-product="Andamios Ligeros PASARELA">
              <i class="fa fa-comments"></i> Cotizar
            </a>
          </div>
        </div>
      </div>

      {{-- ── Slide 6: Dobles ── --}}
      <div class="prod-carousel-slide item-carrousel">
        <div class="prod-carousel-slide__media">
          <div class="prod-carousel-slide__frame">
            <img class="prod-carousel-slide__img"
                 src="{{url('web/img/carrousel/andamio-ligero-galvanizado-doble.webp')}}"
                 alt="Andamio Ligero Tradicional Doble" loading="lazy">
            <span class="prod-carousel-slide__model-badge">Doble 2X</span>
          </div>
        </div>
        <div class="prod-carousel-slide__info">
          <p class="prod-carousel-slide__label">Andamios Ligeros · Mayor Cobertura</p>
          <h3 class="prod-carousel-slide__title"><span>Dobles</span></h3>
          <div class="prod-carousel-slide__divider"></div>
          <p class="prod-carousel-slide__desc">
            Andamio doble ancho 2X. Con sus 5 m² de área permite trabajar más rápido
            sin moverlo varias veces. Ideal para cubrir la mayor cantidad de área.
            Soporta 500 kg.
          </p>
          <div class="prod-carousel-slide__specs">
            <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> 5 m² área</span>
            <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> 500 kg</span>
            <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> Galvanizado</span>
          </div>
          <div class="prod-carousel-slide__btns">
            <a id="cotizar" href="#" class="prod-btn prod-btn--primary btn-cotizar-s"
               data-product="Andamios Ligeros DOBLES">
              <i class="fa fa-comments"></i> Cotizar
            </a>
          </div>
        </div>
      </div>

      {{-- ── Slide 7: Longitudinales ── --}}
      <div class="prod-carousel-slide item-carrousel">
        <div class="prod-carousel-slide__media">
          <div class="prod-carousel-slide__frame">
            <img class="prod-carousel-slide__img"
                 src="{{url('web/img/carrousel/andamio-ligero-galvanizado-longitudinal.webp')}}"
                 alt="Andamio Ligero Galvanizado Longitudinal" loading="lazy">
            <span class="prod-carousel-slide__model-badge">SLT</span>
          </div>
        </div>
        <div class="prod-carousel-slide__info">
          <p class="prod-carousel-slide__label">Andamios Ligeros · Alta Estabilidad</p>
          <h3 class="prod-carousel-slide__title"><span>Longitudinales</span></h3>
          <div class="prod-carousel-slide__divider"></div>
          <p class="prod-carousel-slide__desc">
            4 mts entre crucetas para librar cualquier obstáculo. El MÁS ESTABLE de
            los andamios. Ideal para espectaculares, publicitarios y luminarias.
            Modelos <strong style="color:#ffbb01">SLT-1</strong> y <strong style="color:#ffbb01">SLT-2</strong>.
          </p>
          <div class="prod-carousel-slide__specs">
            <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> 4 m crucetas</span>
            <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> 500 kg</span>
            <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> Galvanizado</span>
          </div>
          <div class="prod-carousel-slide__btns">
            <a id="cotizar" href="#" class="prod-btn prod-btn--primary btn-cotizar-s"
               data-product="Andamios Ligeros Longitudinales">
              <i class="fa fa-comments"></i> Cotizar
            </a>
          </div>
        </div>
      </div>

    </div>{{-- /owl-carousel --}}
  </div>{{-- /track --}}

</section>

{{-- SEPARADOR CON PADRE--}}
<div style="margin-top: -40px; margin-bottom: 40px;">
	@include('web_andamios.productos.banqueteros.sbt6.components.separador_producto.separador')
</div>

{{-- PAQUETES --}}
@include('web_andamios.productos.banqueteros.sbt6.components.cards_paquetes.cards_paquetes')

{{-- COMPONENTES --}}
@include('web_andamios.productos.banqueteros.sbt6.components.componentes_producto.componentes')

@include('web_andamios.index.banner-financial')
<section class="seccion-normal bg-white" id="clientes">
	<div class="contenido">
		<div class="tit-clientes">
			<h1>NUESTROS CLIENTES</h1>
		</div>
		<div class="owl-carousel" id="brand-logos">
                        <div class="item-cli"><img src="{{url('web/img/clientes/Cliente-3M.png')}}" alt="Cliente 3M" loading="lazy" /></div>
            <div class="item-cli"><img src="{{url('web/img/clientes/Cliente-Abitat.png')}}" alt="Cliente Abitat" loading="lazy" /></div>
            <div class="item-cli"><img src="{{url('web/img/clientes/Cliente-AKRA.png')}}" alt="Cliente AKRA" loading="lazy" /></div>
            <div class="item-cli"><img src="{{url('web/img/clientes/Cliente-Anahuac-Organizacion-Constructora.png')}}" alt="Cliente Anahuac Organizacion Constructora" loading="lazy" /></div>
            <div class="item-cli"><img src="{{url('web/img/clientes/Cliente-AUDI.png')}}" alt="Cliente AUDI" loading="lazy" /></div>
            <div class="item-cli"><img src="{{url('web/img/clientes/Cliente-Autopistas-Michoacan.png')}}" alt="CCliente Autopistas Michoacan" loading="lazy" /></div>
            <div class="item-cli"><img src="{{url('web/img/clientes/Cliente-CEMEX.png')}}" alt="Cliente CEMEX" loading="lazy" /></div>
            <div class="item-cli"><img src="{{url('web/img/clientes/Cliente-CIMESA.png')}}" alt="Cliente CIMESA" loading="lazy" /></div>
            <div class="item-cli"><img src="{{url('web/img/clientes/Cliente-Constructora-Anglo.png')}}" alt="Cliente Constructora Anglo" loading="lazy" /></div>
            <div class="item-cli"><img src="{{url('web/img/clientes/Cliente-Constructora-CHUFANI.png')}}" alt="Cliente Constructora CHUFANI" loading="lazy" /></div>
            <div class="item-cli"><img src="{{url('web/img/clientes/Cliente-Freyssinet.png')}}" alt="Cliente Freyssinet" loading="lazy" /></div>
            <div class="item-cli"><img src="{{url('web/img/clientes/Cliente-FUJITA.png')}}" alt="Cliente FUJITA" loading="lazy" /></div>
            <div class="item-cli"><img src="{{url('web/img/clientes/CLiente-GIM.png')}}" alt="CLiente GIM" loading="lazy" /></div>
            <div class="item-cli"><img src="{{url('web/img/clientes/Cliente-Grupo-Copri.png')}}" alt="Cliente Grupo Copri" loading="lazy" /></div>
            <div class="item-cli"><img src="{{url('web/img/clientes/Cliente-Grupo-DAGS.png')}}" alt="Cliente Grupo DAGS" loading="lazy" /></div>
            <div class="item-cli"><img src="{{url('web/img/clientes/Cliente-Grupo-R.png')}}" alt="Cliente Grupo R" loading="lazy" /></div>
            <div class="item-cli"><img src="{{url('web/img/clientes/Cliente-Hazama.png')}}" alt="Cliente Hazama" loading="lazy" /></div>
            <div class="item-cli"><img src="{{url('web/img/clientes/Cliente-ICA.png')}}" alt="Cliente ICA" loading="lazy" /></div>
            <div class="item-cli"><img src="{{url('web/img/clientes/Cliente-Kepler.png')}}" alt="Cliente Kepler" loading="lazy" /></div>
            <div class="item-cli"><img src="{{url('web/img/clientes/Cliente-Lackma-Constructora.png')}}" alt="Cliente Lackma Constructora" loading="lazy" /></div>
            <div class="item-cli"><img src="{{url('web/img/clientes/Cliente-Metcon.png')}}" alt="Cliente Metcon" loading="lazy" /></div>
            <div class="item-cli"><img src="{{url('web/img/clientes/Cliente-Pladis-Proyectos-Integrales.png')}}" alt="Cliente Pladis Proyectos Integrales" loading="lazy" /></div>
            <div class="item-cli"><img src="{{url('web/img/clientes/Cliente-Postensa.png')}}" alt="Cliente Postensa" loading="lazy" /></div>
            <div class="item-cli"><img src="{{url('web/img/clientes/Cliente-Saipem.png')}}" alt="Cliente Saipem" loading="lazy" /></div>
            <div class="item-cli"><img src="{{url('web/img/clientes/Cliente-Vidrios-y-Cristales-Ontiveros.png')}}" alt="Cliente Vidrios y Cristales Ontiveros" loading="lazy" /></div>
            <div class="item-cli"><img src="{{url('web/img/clientes/Cliente-Ximetria.png')}}" alt="Cliente Ximetria" loading="lazy" /></div>
        </div>
	</div>
</section>
<a class="arriba-homepage" href="#">
	↑
</a>
