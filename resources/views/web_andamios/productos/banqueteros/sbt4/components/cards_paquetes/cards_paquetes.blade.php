<section class="productos py-5">
    <div class="container">
        <div class="row products-row">

            <!-- Card 1 -->
            <div class="col-12 col-sm-6 col-lg-4 mb-4" id="paquete-pr1">
                <div class="producto-card reveal">
                    <h5 class="plan-title">SBT-6 y plataforma</h5>
                    <div class="img-wrap">
                        <img src="/web/img/andamios/SBT-6/Andamio-Ligero-SBT6-Con-Plataforma.webp" alt="Andamio SBT-6">
                    </div>
                    <p class="plan-price">$4400 <span class="plan-unit">MXN</span></p>
                    <a target="new" href="{{ url('/promociones/promocion-plataforma-gratis-en-la-compra-de-tu-andamio') }}"
                        class="btn-comprar">Comprar Ahora</a>
                    <ul class="features flex-grow">
                        <li>Plataforma Metálica Reforzada</li>
                        <li>Andamio Ligero Plegable SBT-6</li>
                        <li>Compacto y Económico</li>
                        <li>Estabilidad Profesional</li>
                        <li>Fácil Traslado y Armado Rápido</li>
                        <li>Ideal para Trabajos de Altura</li>
                    </ul>
                </div>
            </div>

            <!-- Card 2 (destacada) -->
            <div class="col-12 col-sm-6 col-lg-4 mb-4" id="paquete-pr2">
                <div class="producto-card destacado reveal">
                    <div class="badge-top">Más vendido</div>
                    <h5 class="plan-title">Andamio SBT-4</h5>
                    <div class="img-wrap">
                        <img src="/web/img/andamios/SBT-4/Andamio-Banquetero-SBT4-landing-3.png" alt="Andamio SBT-4">
                    </div>
                    <p class="plan-price plan-price-destacado">$2600 <span class="plan-unit">MXN</span></p>
                    <a target="_blank"
                        href="{{ url('/promociones/promocion-plataforma-gratis-en-la-compra-de-tu-andamio') }}"
                        class="btn-comprar destacado-btn">Comprar Ahora</a>
                    <ul class="features flex-grow">
                        <li>Estructura resistente</li>
                        <li>Compacto y económico</li>
                        <li>Estabilidad profesional</li>
                        <li>Fácil traslado y armado rápido</li>
                    </ul>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-12 col-sm-6 col-lg-4 mb-4" id="paquete-pr3">
                <div class="producto-card reveal">
                    <h5 class="plan-title">SBT-6 completo</h5>
                    <div class="img-wrap">
                        <img src="/web/img/andamios/SBT-6/Andamio-SBT6-Plataforma-Ruedas.png" alt="Andamio SBT-6">
                    </div>
                    <p class="plan-price">$6500 <span class="plan-unit">MXN</span></p>
                    <a target="_blank"
                        href="https://andamiosligeros.com/tienda/paquete-andamio-plegable--plataforma-y-juego-de-ruedas"
                        class="btn-comprar">Comprar Ahora</a>
                    <ul class="features flex-grow">
                        <li>Plataforma Metálica Reforzada</li>
                        <li>Andamio Ligero Plegable SBT-6</li>
                        <li>Incluye Ruedas con Freno</li>
                        <li>Armado en Tiempo Récord</li>
                        <li>Seguridad en Altura</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* ===== Grid con gutters consistentes (Bootstrap 4) ===== */
    .products-row {
        margin-left: -12px;
        margin-right: -12px;
    }

    .products-row>[class*="col-"] {
        padding-left: 12px;
        padding-right: 12px;
    }

    /* ===== Card ===== */
    .producto-card {
        display: flex;
        /* para alinear contenidos verticalmente */
        flex-direction: column;
        height: 100%;
        background: #fff;
        border-radius: 18px;
        padding: 1.5rem;
        box-shadow: 0 4px 18px rgba(0, 0, 0, .08);
        text-align: center;
        position: relative;
        transition: transform .28s ease, box-shadow .28s ease;
        will-change: transform;
    }

    .producto-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 28px rgba(0, 0, 0, .16);
    }

    /* Imagen consistente (sin saltos) */
    .img-wrap {
        width: 100%;
        height: 200px;
        /* fija el alto del área de imagen */
        border-radius: .75rem;
        overflow: hidden;
        margin-bottom: 1rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, .12);
        background: #ffffffff;
    }

    .img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
        transition: transform .3s ease;
    }

    .producto-card:hover .img-wrap img {
        transform: scale(1.03);
    }

    /* Títulos y precios */
    .plan-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #222;
        margin-bottom: .75rem;
        text-transform: uppercase;
    }

    .plan-price {
        font-size: 2rem;
        font-weight: 800;
        color: #000;
        margin: .25rem 0 1rem;
    }

    .plan-price-destacado {
        font-size: 2.3rem;
    }

    .plan-unit {
        font-size: .9rem;
        color: #555;
    }

    /* Botón */
    .btn-comprar {
        display: inline-block;
        align-self: center;
        background: #FFBB00;
        color: #fff;
        padding: .65rem 1.6rem;
        border-radius: 30px;
        font-weight: 700;
        text-decoration: none;
        transition: all .25s ease;
        box-shadow: 0 4px 12px rgba(224, 215, 42, .25);
    }

    .btn-comprar:hover {
        background: #0648D6;
        color: #f4cc5d;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(6, 72, 214, .25);
    }

    /* Lista de features ocupa el espacio restante para alinear alturas */
    .features {
        list-style: none;
        padding: 0;
        margin-top: 1.1rem;
        text-align: left;
    }

    .features.flex-grow {
        flex: 1;
    }

    /* empuja para que todas las cards igualen altura */
    .features li {
        margin: .5rem 0;
        font-size: .95rem;
        color: #444;
        padding-left: 1.4rem;
        position: relative;
    }

    .features li::before {
        content: "✔";
        position: absolute;
        left: 0;
        color: #4CAF50;
        font-weight: 700;
    }

    /* Card destacada */
    .destacado {
        border: 2px solid #FFBB00;
    }

    .destacado .plan-price {
        color: #FFBB00;
    }

    .destacado-btn {
        background: #0648D6;
    }

    .destacado-btn:hover {
        background: #0648D6;
        color: #FFBB00;
    }

    /* Badge */
    .badge-top {
        position: absolute;
        top: -12px;
        left: 50%;
        transform: translateX(-50%);
        background: #FFBB00;
        color: #fff;
        padding: .3rem 1rem;
        border-radius: 20px;
        font-size: .8rem;
        font-weight: 700;
    }

    /* ===== Animación on-scroll: fade-up ===== */
    .reveal {
        opacity: 0;
        transform: translateY(18px);
    }

    .reveal.visible {
        animation: fadeUp .5s ease forwards;
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(18px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Ajustes responsivos finos */
    @media (max-width: 575.98px) {
        .img-wrap {
            height: 180px;
        }
    }

    @media (min-width: 1200px) {
        .img-wrap {
            height: 220px;
        }
    }
</style>

<script>
    // Animación on-scroll (ES5, sin dependencias)
    (function() {
        var els = [].slice.call(document.querySelectorAll('.reveal'));
        if ('IntersectionObserver' in window) {
            var io = new IntersectionObserver(function(entries) {
                for (var i = 0; i < entries.length; i++) {
                    if (entries[i].isIntersecting) {
                        entries[i].target.classList.add('visible');
                        io.unobserve(entries[i].target);
                    }
                }
            }, {
                threshold: 0.15
            });
            for (var j = 0; j < els.length; j++) io.observe(els[j]);
        } else {
            // fallback básico
            for (var k = 0; k < els.length; k++) els[k].classList.add('visible');
        }
    })();
</script>
