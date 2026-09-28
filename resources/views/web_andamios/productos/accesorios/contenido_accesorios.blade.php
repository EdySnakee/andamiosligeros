{{-- ============================================================
     ACCESORIOS — Contenido modernizado (Dinámico)
     Genera las secciones de forma automática con un loop foreach
     ============================================================ --}}

{{-- ── HERO SECTION ──────────────────────────────────────── --}}
<section class="prod-hero" id="inicio">

  {{-- Columna izquierda: información --}}
  <div class="prod-hero__info">

    <div class="prod-hero__content">
      <div class="prod-badge">Complementos &amp; Seguridad</div>

      <p class="prod-hero__eyebrow">Para Andamios y Estructuras</p>

      <h1 class="prod-hero__title">
        NUESTROS
        <span class="prod-hero__title-accent">ACCESORIOS</span>
        <small class="prod-hero__subtitle">Estabilidad · Versatilidad · Confianza</small>
      </h1>

      <p class="prod-hero__desc">
        Optimiza tu equipo con nuestra amplia gama de accesorios para andamios.
        Diseñados para brindar mayor seguridad, movilidad y funcionalidad en
        cualquier terreno o proyecto, garantizando el máximo rendimiento de
        tus estructuras.
      </p>

      <a href="#modelos" class="prod-hero__btn">
        Ver accesorios
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

  {{-- Columna derecha: imagen del producto (dinámica del 1er accesorio) --}}
  <div class="prod-hero__media">
    <div class="prod-hero__img-wrap">
      <img src="{{url('web/img/andamios/portada-accesorios-para-andamios.webp')}}"
           alt="Accesorios para andamios — Vista general" onerror="this.src='{{url('web/img/default_pattern.png')}}';">
    </div>

    {{-- Chip de información --}}
    <div class="prod-hero__chip">
      <div class="prod-hero__chip-icon">
        <i class="fa fa-cogs"></i>
      </div>
      <div class="prod-hero__chip-text">
        <strong>Versatilidad</strong>
        Fácil instalación
      </div>
    </div>
  </div>

</section>

{{-- ── SECCIÓN DE PRODUCTOS (DINÁMICA) ─────────────────────── --}}
@if (!$catProductos->isEmpty())
  @foreach ($catProductos as $index => $item_product)
  
  @php
      // Alternar diseño en productos impares
      $isEven = ($index % 2 == 0);
  @endphp

  <section class="prod-section {{ $isEven ? '' : 'prod-section--alt' }}" {!! $index === 0 ? 'id="modelos"' : '' !!}>
    <div class="prod-container">

      {{-- Añadiendo clase reverse si es impar para acomodar la imagen del lado opuesto --}}
      <div class="prod-product-card {{ $isEven ? '' : 'prod-product-card--reverse' }} prod-reveal">

        {{-- Imagen dinámica --}}
        <div class="prod-product-img {{ $isEven ? 'prod-reveal-left' : 'prod-reveal-right' }}">
          <div class="prod-product-img__frame">
            <img src="{{ url($item_product->imagen_portada) }}"
                 alt="{{ $item_product->imagen_alt ?? $item_product->post_titulo }}" onerror="this.src='{{url('web/img/default_pattern.png')}}';">
            
            <span class="prod-product-img__badge">
              {{ $item_product->modelo ? strtoupper($item_product->modelo) : 'Accesorio' }} 
              {{ $item_product->estrella == 1 ? '★' : '' }}
            </span>
          </div>
        </div>

        {{-- Información dinámica --}}
        <div class="prod-product-info {{ $isEven ? 'prod-reveal-right' : 'prod-reveal-left' }} prod-delay-1">
          <p class="prod-product-info__label">{{ strtoupper($item_product->categoria) }}</p>

          <h2 class="prod-product-info__title">
            <span>{{ $item_product->post_titulo }}</span>
          </h2>

          <div class="prod-product-info__divider"></div>

          <p class="prod-product-info__desc">
            {{ $item_product->descripcion_corta }}
          </p>

          {{-- Omitiendo los chips de specs, ya que no aplican del todo dinámicamente o podríamos poner unos genéricos --}}
          <div class="prod-product-specs" style="margin-top: 2vw;"></div>

          <div class="prod-product-btns">
            <a href="{{ url('/') }}/tienda/{{ $item_product->post_url }}"
               class="prod-btn prod-btn--outline">
              <i class="fa fa-file-text-o"></i>
              Ver ficha técnica
            </a>
            <a id="cotizar" href="#" class="prod-btn prod-btn--primary btn-cotizar-s"
               data-product="{{ $item_product->post_titulo }}">
              <i class="fa fa-comments"></i>
              Cotizar
            </a>
          </div>
        </div>

      </div>
    </div>
  </section>
  @endforeach
@else
  <section class="prod-section" id="modelos">
    <div class="prod-container" style="text-align: center; padding: 5vw 0;">
      <div class="noresult">
        <img width="100px" src="{{url('/script/out-of-stock.png')}}" alt="Sin resultados">
        <br><br>
        <p style="font-size: 1.5vw; color: var(--brand-blue); font-weight: bold;">NO SE ENCONTRARON RESULTADOS EN ESTA CATEGORÍA</p>
      </div>
    </div>
  </section>
@endif

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
