{{-- ── HERO SECTION ──────────────────────────────────────── --}}

<section class="prod-hero" id="inicio">

  {{-- Columna izquierda: información --}}
  <div class="prod-hero__info">

    <div class="prod-hero__content">
      <div class="prod-badge">Galvanizados &amp; Certificados</div>

      <p class="prod-hero__eyebrow">Andamios Ligeros</p>

      <h1 class="prod-hero__title">
        ANDAMIOS
        <span class="prod-hero__title-accent">LIGEROS</span>
        <small class="prod-hero__subtitle">Banqueteros · SBT-1, SBT-2 y SBT-5</small>
      </h1>

      <p class="prod-hero__desc">
        Compactos, ágiles y seguros. Nuestros andamios banqueteros galvanizados
        están diseñados para obras ligeras, interiores y espacios reducidos,
        sin sacrificar resistencia ni seguridad.
      </p>

      <a href="#modelos" class="prod-hero__btn">
        Ver modelos
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="6 9 12 15 18 9"/>
        </svg>
      </a>
    </div>

    {{-- Scroll indicator --}}
    <div class="prod-hero__scroll">
      <span>Scroll</span>
      <div class="prod-hero__scroll-line"></div>
    </div>

  </div>

  {{-- Columna derecha: imagen del producto --}}
  <div class="prod-hero__media">
    <div class="prod-hero__img-wrap">
      <img src="{{url('web/img/andamios/portada-andamios-ligeros-banqueteros.webp')}}"
           alt="Andamios Ligeros Banqueteros — Vista general">
    </div>

    {{-- Chip de información --}}
    <div class="prod-hero__chip">
      <div class="prod-hero__chip-icon">
        <i class="fa fa-shield"></i>
      </div>
      <div class="prod-hero__chip-text">
        <strong>Galvanizado</strong>
        Resistente a la corrosión
      </div>
    </div>
  </div>

</section>

{{-- ══════════════════════════════════════════════════════════
     PRODUCTO ESTRELLA — SBT-6 Andamio Plegable
     ══════════════════════════════════════════════════════════ --}}
<section class="prod-featured prod-reveal" id="producto-estrella">
  <div class="prod-featured__inner">

    {{-- Columna imagen --}}
    <div class="prod-featured__media prod-reveal-left">
      <div class="prod-featured__img-glow"></div>
      <img class="prod-featured__img"
           src="{{url('web/img/andamios/andamios-plegables-multiusos-galvanizados.webp')}}"
           alt="Andamio Ligero Plegable Galvanizado SBT-6">
      <div class="prod-featured__star-badge">
        <i class="fa fa-star"></i> Producto Estrella
      </div>
    </div>

    {{-- Columna info --}}
    <div class="prod-featured__info prod-reveal-right prod-delay-1">

      <p class="prod-featured__label">Línea exclusiva · Andamios Banqueteros</p>

      <h2 class="prod-featured__title">
        Andamio Plegable<br><span>SBT-6</span>
      </h2>

      <div class="prod-featured__divider"></div>

      <p class="prod-featured__desc">
        Nuestra línea más exclusiva con <strong style="color:#ffbb01;">bisagra integrada</strong>.
        Los andamios más prácticos, versátiles y fáciles de utilizar — ideales para
        espacios pequeños, en interior o exterior, con capacidad de carga de hasta 500 kg.
      </p>

      {{-- Tarjetas de características --}}
      <div class="prod-featured__perks">
        <div class="prod-featured__perk">
          <span class="prod-featured__perk-icon"><i class="fa fa-truck"></i></span>
          <span class="prod-featured__perk-title">Fácil transporte</span>
          <p class="prod-featured__perk-text">Diseño plegable y peso reducido para llevarlo a cualquier obra</p>
        </div>
        <div class="prod-featured__perk">
          <span class="prod-featured__perk-icon"><i class="fa fa-wrench"></i></span>
          <span class="prod-featured__perk-title">Fácil montaje</span>
          <p class="prod-featured__perk-text">Sin herramientas especiales — listo en segundos</p>
        </div>
        <div class="prod-featured__perk">
          <span class="prod-featured__perk-icon"><i class="fa fa-shield"></i></span>
          <span class="prod-featured__perk-title">500 kg de carga</span>
          <p class="prod-featured__perk-text">Gran resistencia galvanizada para trabajar con seguridad</p>
        </div>
      </div>

      {{-- CTAs --}}
      <div class="prod-featured__btns">
        <a href="{{ url('/promociones/promocion-plataforma-gratis-en-la-compra-de-tu-andamio') }}"
           class="prod-featured__btn-buy">
          <i class="fa fa-shopping-cart"></i>
          Comprar ahora
        </a>
        <a href="{{ route('web_sbt6') }}" class="prod-featured__btn-more">
          <i class="fa fa-info-circle"></i>
          Ver más información
        </a>
      </div>

    </div>
  </div>
</section>

{{-- ── SECCIÓN MODELOS ───────────────────────────────────── --}}
<section class="prod-section" id="modelos">
  <div class="prod-container">

    {{-- ── PRODUCTO: SBT-1 ── --}}
    <div class="prod-product-card prod-reveal">

      {{-- Imagen --}}
      <div class="prod-product-img prod-reveal-left">
        <div class="prod-product-img__frame">
          <img src="{{url('web/img/andamios/andamio-ligero-galvanizado-banquetero-sbt1-sbt3.webp')}}"
               alt="Andamio Ligero Galvanizado Banquetero SBT-1">
          <span class="prod-product-img__badge">SBT-1</span>
        </div>
      </div>

      {{-- Información --}}
      <div class="prod-product-info prod-reveal-right prod-delay-1">
        <p class="prod-product-info__label">Andamio Ligero Banquetero</p>

        <h2 class="prod-product-info__title">
          Modelo <span>SBT-1</span>
        </h2>

        <div class="prod-product-info__divider"></div>

        <p class="prod-product-info__desc">
          Andamio ligero galvanizado banquetero de <strong>cinco peldaños</strong>,
          ideal para obras ligeras, trabajos en interior y espacios reducidos.
          Sus cinco peldaños permiten subir con seguridad y comodidad por la escalerilla.
        </p>

        <div class="prod-product-specs">
          <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> 5 Peldaños</span>
          <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> Espacios reducidos</span>
          <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> Galvanizado</span>
          <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> Uso interior</span>
        </div>

        <div class="prod-product-btns">
          <a href="{{route('web_sbt1')}}" class="prod-btn prod-btn--outline">
            <i class="fa fa-file-text-o"></i>
            Ver ficha técnica
          </a>
          <a id="cotizar" href="#" class="prod-btn prod-btn--primary btn-cotizar-s"
             data-product="Andamios Ligeros Banqueteros SBT-1">
            <i class="fa fa-comments"></i>
            Cotizar
          </a>
        </div>
      </div>

    </div>
  </div>
</section>

{{-- ── SECCIÓN SBT-2 (fondo alternativo) ──────────────────── --}}
<section class="prod-section prod-section--alt">
  <div class="prod-container">

    {{-- ── PRODUCTO: SBT-2 ── --}}
    <div class="prod-product-card prod-product-card--reverse prod-reveal">

      {{-- Imagen (a la derecha por el reverse) --}}
      <div class="prod-product-img prod-reveal-right">
        <div class="prod-product-img__frame">
          <img src="{{url('web/img/andamios/andamio-ligero-galvanizado-banquetero-sbt-2.webp')}}"
               alt="Andamio Ligero Galvanizado Banquetero SBT-2">
          <span class="prod-product-img__badge">SBT-2</span>
        </div>
      </div>

      {{-- Información (a la izquierda) --}}
      <div class="prod-product-info prod-reveal-left prod-delay-1">
        <p class="prod-product-info__label">Andamio Ligero Banquetero</p>

        <h2 class="prod-product-info__title">
          Modelo <span>SBT-2</span>
        </h2>

        <div class="prod-product-info__divider"></div>

        <p class="prod-product-info__desc">
          Andamio ligero galvanizado banquetero de <strong>cuatro peldaños</strong>,
          el más práctico en su tipo. Ideal para obras ligeras, trabajos en interior
          y espacios reducidos. Sus cuatro peldaños permiten el acceso a través de él.
        </p>

        <div class="prod-product-specs">
          <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> 4 Peldaños</span>
          <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> El más práctico</span>
          <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> Galvanizado</span>
          <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> Acceso lateral</span>
        </div>

        <div class="prod-product-btns">
          <a href="{{route('web_sbt2')}}" class="prod-btn prod-btn--outline">
            <i class="fa fa-file-text-o"></i>
            Ver ficha técnica
          </a>
          <a id="cotizar" href="#" class="prod-btn prod-btn--primary btn-cotizar-s"
             data-product="Andamios Ligeros Banqueteros SBT-2">
            <i class="fa fa-comments"></i>
            Cotizar
          </a>
        </div>
      </div>

    </div>
  </div>
</section>

{{-- ── SECCIÓN SBT-5 (fondo blanco, imagen izquierda) ─────── --}}
<section class="prod-section">
  <div class="prod-container">

    {{-- ── PRODUCTO: SBT-5 ── --}}
    <div class="prod-product-card prod-reveal">

      {{-- Imagen --}}
      <div class="prod-product-img prod-reveal-left">
        <div class="prod-product-img__frame">
          <img src="{{url('web/img/andamios/andamio-ligero-galvanizado-sbt-5-alto-3mts.webp')}}"
               alt="Andamio Ligero Galvanizado Banquetero SBT-5 Alto 3mts">
          <span class="prod-product-img__badge">SBT-5</span>
        </div>
      </div>

      {{-- Información --}}
      <div class="prod-product-info prod-reveal-right prod-delay-1">
        <p class="prod-product-info__label">Andamio Ligero Banquetero</p>

        <h2 class="prod-product-info__title">
          Modelo <span>SBT-5</span>
        </h2>

        <div class="prod-product-info__divider"></div>

        <p class="prod-product-info__desc">
          Andamio ligero galvanizado de <strong>siete peldaños</strong>. Permite
          alcanzar mayor altura con menos módulos, creando torres en múltiplos de
          3 m. Menos empates entre módulos y mayor altura.
          <br><small style="color:#777;">82 cm ancho × 3 m alto × 2.10 m entre crucetas</small>
        </p>

        <div class="prod-product-specs">
          <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> 7 Peldaños</span>
          <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> Torre 3 m</span>
          <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> Galvanizado</span>
          <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> Mayor altura</span>
        </div>

        <div class="prod-product-btns">
          <a href="{{route('web_sbt5')}}" class="prod-btn prod-btn--outline">
            <i class="fa fa-file-text-o"></i>
            Ver ficha técnica
          </a>
          <a id="cotizar" href="#" class="prod-btn prod-btn--primary btn-cotizar-s"
             data-product="Andamios Ligeros Banqueteros SBT-5">
            <i class="fa fa-comments"></i>
            Cotizar
          </a>
        </div>
      </div>

    </div>
  </div>
</section>

{{-- ── BANNER FINANCIERO ─────────────────────────────────── --}}
@include('web_andamios.index.banner-financial')

{{-- ── SCRIPT: Intersection Observer para animaciones ──────── --}}
<script>
(function () {
  var selectors = '.prod-reveal, .prod-reveal-left, .prod-reveal-right';
  var elements  = document.querySelectorAll(selectors);
  if (!elements.length) return;
  if ('IntersectionObserver' in window) {
    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.15 });
    elements.forEach(function (el) { observer.observe(el); });
  } else {
    elements.forEach(function (el) { el.classList.add('visible'); });
  }
})();
</script>