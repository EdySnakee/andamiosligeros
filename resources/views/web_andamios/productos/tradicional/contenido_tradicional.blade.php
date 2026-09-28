{{-- ============================================================
     ANDAMIOS LIGEROS TRADICIONALES — Contenido modernizado
     ============================================================ --}}

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
        <small class="prod-hero__subtitle">Tradicionales · STP-1 y STP-2</small>
      </h1>

      <p class="prod-hero__desc">
        Diseñados para altura y seguridad. Nuestros andamios galvanizados ofrecen
        la combinación perfecta entre resistencia, ligereza y estabilidad para
        cualquier obra de construcción.
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
      <img src="{{url('web/img/andamios/portada-andamios-ligeros-estandar.webp')}}"
           alt="Andamio Ligero Tradicional STP-2 — Vista general">
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

{{-- ── SECCIÓN MODELOS ───────────────────────────────────── --}}
<section class="prod-section" id="modelos">
  <div class="prod-container">

    {{-- ── PRODUCTO: STP-2 ── --}}
    <div class="prod-product-card prod-reveal">

      {{-- Imagen --}}
      <div class="prod-product-img prod-reveal-left">
        <div class="prod-product-img__frame">
          <img src="{{url('web/img/andamios/andamio-ligero-galvanizado-tradicional-STP-2.webp')}}"
               alt="Andamio Ligero Galvanizado Tradicional STP-2">
          <span class="prod-product-img__badge">STP-2</span>
        </div>
      </div>

      {{-- Información --}}
      <div class="prod-product-info prod-reveal-right prod-delay-1">
        <p class="prod-product-info__label">Andamio Ligero Tradicional</p>

        <h2 class="prod-product-info__title">
          Modelo <span>STP-2</span>
        </h2>

        <div class="prod-product-info__divider"></div>

        <p class="prod-product-info__desc">
          Andamio tradicional de <strong>cuatro peldaños</strong> en la escalerilla,
          ideal para alcanzar gran altura. Su área de trabajo de 3 m² crea un espacio
          cómodo en la plataforma, y la distancia entre peldaños garantiza al trabajador
          libertad de movimiento.
        </p>

        <div class="prod-product-specs">
          <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> 4 Peldaños</span>
          <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> 3 m² de plataforma</span>
          <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> Galvanizado</span>
          <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> Gran altura</span>
        </div>

        <div class="prod-product-btns">
          <a href="{{route('web_stp2')}}" class="prod-btn prod-btn--outline">
            <i class="fa fa-file-text-o"></i>
            Ver ficha técnica
          </a>
          <a id="cotizar" href="#" class="prod-btn prod-btn--primary btn-cotizar-s"
             data-product="Andamios Ligeros Tradicionales STP-2">
            <i class="fa fa-comments"></i>
            Cotizar
          </a>
        </div>
      </div>

    </div>
  </div>
</section>

{{-- ── SECCIÓN STP-1 (fondo alternativo) ──────────────────── --}}
<section class="prod-section prod-section--alt">
  <div class="prod-container">

    {{-- ── PRODUCTO: STP-1 ── --}}
    <div class="prod-product-card prod-product-card--reverse prod-reveal">

      {{-- Imagen (queda a la derecha por el reverse) --}}
      <div class="prod-product-img prod-reveal-right">
        <div class="prod-product-img__frame">
          <img src="{{url('web/img/andamios/andamio-ligero-galvanizado-tradicional-STP-1.webp')}}"
               alt="Andamio Ligero Galvanizado Tradicional STP-1">
          <span class="prod-product-img__badge">STP-1</span>
        </div>
      </div>

      {{-- Información (queda a la izquierda) --}}
      <div class="prod-product-info prod-reveal-left prod-delay-1">
        <p class="prod-product-info__label">Andamio Ligero Tradicional</p>

        <h2 class="prod-product-info__title">
          Modelo <span>STP-1</span>
        </h2>

        <div class="prod-product-info__divider"></div>

        <p class="prod-product-info__desc">
          Andamio estándar de <strong>cinco peldaños</strong> en la escalerilla, ideal
          para obras de altura y manipulación de elementos pesados. Se recomienda para
          trabajadores de mayor edad o complexión robusta.
        </p>

        <div class="prod-product-specs">
          <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> 5 Peldaños</span>
          <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> Mayor estabilidad</span>
          <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> Galvanizado</span>
          <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> Carga pesada</span>
        </div>

        <div class="prod-product-btns">
          <a href="{{route('web_stp1')}}" class="prod-btn prod-btn--outline">
            <i class="fa fa-file-text-o"></i>
            Ver ficha técnica
          </a>
          <a id="cotizar" href="#" class="prod-btn prod-btn--primary btn-cotizar-s"
             data-product="Andamios Ligeros Tradicionales STP-1">
            <i class="fa fa-comments"></i>
            Cotizar
          </a>
        </div>
      </div>

    </div>
  </div>
</section>

{{-- ── PRODUCTO: STP-4 ── --}}
<section class="prod-section">
  <div class="prod-container">

    <div class="prod-product-card prod-reveal">

      {{-- Imagen --}}
      <div class="prod-product-img prod-reveal-left">
        <div class="prod-product-img__frame" style="background: transparent;">
          <img src="{{url('web/img/andamios/psvgs/andamio-tradicional-header-STP2.webp')}}"
               alt="Andamio Ligero Galvanizado Tradicional STP-4" style="object-fit: contain; max-height: 90%;">
          <span class="prod-product-img__badge">STP-4</span>
        </div>
      </div>

      {{-- Información --}}
      <div class="prod-product-info prod-reveal-right prod-delay-1">
        <p class="prod-product-info__label">Andamio Ligero Tradicional</p>

        <h2 class="prod-product-info__title">
          Modelo <span>STP-4</span>
        </h2>

        <div class="prod-product-info__divider"></div>

        <p class="prod-product-info__desc">
          Andamio tradicional de <strong>4 peldaños</strong> en la escalerilla, con cruceta
          tipo tijeras. Ideal para alcanzar gran altura, con un área de trabajo de 2.5m² que
          crea un espacio cómodo. Fabricado en acero galvanizado de 1½ pulgadas de alta
          resistencia, garantizando durabilidad y seguridad con capacidad de carga de hasta 500 kg.
        </p>

        <div class="prod-product-specs">
          <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> 4 Peldaños</span>
          <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> 2.5 m² de plataforma</span>
          <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> Soporta 500 kg</span>
          <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> Cruceta tijera</span>
        </div>

        <div class="prod-product-btns">
          <a href="{{url('andamios-ligeros-galvanizados-tradicionales-4-peldanos-STP4')}}" class="prod-btn prod-btn--outline">
            <i class="fa fa-file-text-o"></i>
            Ver ficha técnica
          </a>
          <a id="cotizar" href="#" class="prod-btn prod-btn--primary btn-cotizar-s"
             data-product="Andamios Ligeros Tradicionales STP-4">
            <i class="fa fa-comments"></i>
            Cotizar
          </a>
        </div>
      </div>

    </div>
  </div>
</section>

{{-- ── PRODUCTO: STP-5 (fondo alternativo) ── --}}
<section class="prod-section prod-section--alt">
  <div class="prod-container">

    <div class="prod-product-card prod-product-card--reverse prod-reveal">

      {{-- Imagen (queda a la derecha por el reverse) --}}
      <div class="prod-product-img prod-reveal-right">
        <div class="prod-product-img__frame" style="background: transparent;">
          <img src="{{url('storage/files/14_tradicional-st__4_.webp')}}"
               alt="Andamio Plegable Galvanizado Multiusos STP-5" style="object-fit: contain; max-height: 90%;">
          <span class="prod-product-img__badge">STP-5</span>
        </div>
      </div>

      {{-- Información (queda a la izquierda) --}}
      <div class="prod-product-info prod-reveal-left prod-delay-1">
        <p class="prod-product-info__label">Andamio Plegable Multiusos</p>

        <h2 class="prod-product-info__title">
          Modelo <span>STP-5</span>
        </h2>

        <div class="prod-product-info__divider"></div>

        <p class="prod-product-info__desc">
          Andamio <strong>plegable</strong> galvanizado con cruceta integrada tipo bisagra.
          Su sistema permite un armado y desarmado rápido, optimizando el tiempo en obra.
          Con 1.80m de altura y 4 peldaños, su diseño es sumamente práctico para
          transportar o almacenar en espacios reducidos sin comprometer su estabilidad extrema.
        </p>

        <div class="prod-product-specs">
          <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> 4 Peldaños</span>
          <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> Cruceta bisagra integrada</span>
          <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> Modelo Plegable</span>
          <span class="prod-spec-chip"><i class="fa fa-check-circle"></i> Armado rápido</span>
        </div>

        <div class="prod-product-btns">
          <a href="{{url('tienda/andamio-plegable-galvanizado-multiusos-stp-5')}}" class="prod-btn prod-btn--outline">
            <i class="fa fa-file-text-o"></i>
            Ver ficha técnica
          </a>
          <a id="cotizar" href="#" class="prod-btn prod-btn--primary btn-cotizar-s"
             data-product="Andamio Plegable Multiusos STP-5">
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