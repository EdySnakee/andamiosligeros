<!-- Cronómetro -->
<section class="cta-cronometro" data-aos="fade-right" data-aos-duration="700">
    <div class="container">
        <div class="cronometro2">
            <div class="cronometro-inner2">
                <span id="cronometro-text">05:00</span>
            </div>
        </div>
    </div>
</section>

<!-- Sección Hero -->
<section class="hero-section">
    <div class="hero-content content">
        <h1>Dile adiós a los andamios “convencionales”, conoce el nuevo Andamio Ligero Plegable SBT-10, ideal para uso
            doméstico, fáciles de armar y desarmar.</h1>
        <p class="hero-subtitle">Ligeros, plegables y seguros para cualquier trabajo del hogar.</p>
        <div class="hero-video">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/bgZnOI6ArOw?si=VCnSvUmhLXvsqp3v"
                title="YouTube video player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
    </div>
</section>

<!-- Sección de Producto -->
<section class="producto-section">
    <div class="producto-content content">
        <div class="producto-texto" data-aos="fade-right" data-aos-duration="1000">
            <h2>Andamio Ligero Plegable SBT-10</h2>
            <p>¿Por qué el Andamio Ligero Plegable SBT-10 es perfecto para ti?</p>
            <ul>
                <li>Es ligero y plegable.</li>
                <li>Fácil de armar y desarmar. </li>
                <li>Ideal para trabajos en interiores y espacios reducidos. </li>
                <li>Diseñado para ofrecer máxima seguridad y estabilidad.</li>
                <li>Gran capacidad de carga de 200 KG.</li>
                <li>Está fabricado con tubo de acero 100% galvanizado, lo cual evita la corrosión y oxidación.</li>
            </ul>
        </div>
        <div class="producto-imagen" data-aos="fade-left" data-aos-duration="1000">
            <img src="{{ url('web/img/Andamio_SBT-10.png') }}" alt="Andamio SBT-4">
        </div>
    </div>
</section>

<!-- Sección CTA con Contador-->
<section class="cta-cron-section">
    <div class="cta-cron-content content">
        <div class="cta-cron-left">
            <h2>¡Compra ahora y obtén un descuento exclusivo!</h2>
            <p>Unidades disponibles en este momento:</p>
            <h3 class='counter' id="counter">0</h3>
            <h3>De
                <span class="precio-original-container">
                    <span class="precio-original">$3,330 </span>
                    <span class="linea" data-aos="fade-right" data-aos-duration="1000"></span>
                </span>
                a
            </h3>
            <div class="precio-descuento-container" data-aos="zoom-in" data-aos-duration="2200">
                <h3 class="precio-descuento">$1,999</h3>
            </div>
            <form enctype="multipart/form-data" method="get" class="cart" action="{{ route('comprar_ahora') }}">
                <div class="quantity quantity-lg">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="request" value="landing">
                    <input type="hidden" name="id_producto" value="34">
                    <input type="hidden" name="cantidad" value="1">
                    <input type="hidden" name="imagen"
                        value="https://andamiosligeros.com/storage/files/34_SBT-10.webp">
                    <input type="hidden" name="envio" value="0">
                    <input type="hidden" name="post_titulo" value="Andamio Ligero Plegable SBT-10">
                    <input type="hidden" name="precio_prodcuto" value="1999">
                </div>
                <button id="setLocalStorage" type="submit" class="cta-cron-button cta-button">Quiero aprovechar mi descuento</button>
            </form>
        </div>
    </div>
</section>

<!-- Sección Mockups del Producto -->
<section class="mockups-producto-section">
    <div class="mockups-producto-content content">
        <h2>SBT-10</h2>
        <div class="slider-container">
            <div class="slider">
                <div class="slide"><img src="{{ url('web/img/SBT-10/Andamio_SBT-10-1.png') }}" alt="Andamio_SBT-10-1">
                </div>
                <div class="slide"><img src="{{ url('web/img/SBT-10/Andamio_SBT-10-2.png') }}" alt="Andamio_SBT-10-2">
                </div>
                <div class="slide"><img src="{{ url('web/img/SBT-10/Andamio_SBT-10-3.png') }}" alt="Andamio_SBT-10-3">
                </div>
                <div class="slide"><img src="{{ url('web/img/SBT-10/Andamio_SBT-10-4.png') }}" alt="Andamio_SBT-10-4">
                </div>
                <div class="slide"><img src="{{ url('web/img/SBT-10/Andamio_SBT-10-5.png') }}" alt="Andamio_SBT-10-5">
                </div>
                <div class="slide"><img src="{{ url('web/img/SBT-10/Andamio_SBT-10-6.png') }}" alt="Andamio_SBT-10-6">
                </div>
                <div class="slide"><img src="{{ url('web/img/SBT-10/Andamio_SBT-10-7.png') }}" alt="Andamio_SBT-10-7">
                </div>
                <div class="slide"><img src="{{ url('web/img/SBT-10/Andamio_SBT-10-8.png') }}"
                        alt="Andamio_SBT-10-8">
                </div>
                <div class="slide"><img src="{{ url('web/img/SBT-10/Andamio_SBT-10-9.png') }}"
                        alt="Andamio_SBT-10-9">
                </div>
                <div class="slide"><img src="{{ url('web/img/SBT-10/Andamio_SBT-10-10.png') }}"
                        alt="Andamio_SBT-10-10"></div>
                <div class="slide"><img src="{{ url('web/img/SBT-10/Andamio_SBT-10-11.png') }}"
                        alt="Andamio_SBT-10-11"></div>
                <div class="slide"><img src="{{ url('web/img/SBT-10/Andamio_SBT-10-12.png') }}"
                        alt="Andamio_SBT-10-12"></div>
            </div>
            <a href="#" class="nav-button prev">&lt;</a>
            <a href="#" class="nav-button next">&gt;</a>
        </div>
    </div>
</section>

<!-- Sección Ofertas Especiales y Descuentos -->
<section class="ofertas-section">
    <div class="ofertas-content content">
        <div class="ofertas-grid">
            <div class="oferta-item" data-aos="fade-right" data-aos-duration="1000">
                <div class="icono-oferta">
                    <i class="fa fa-award"></i>
                </div>
                <h3>Garantía de Andamios Ligeros.</h3>
                <p>Si el mismo día que recibes tu pedido, tu producto tiene algún defecto de fábrica, te lo cambiamos
                    sin hacer preguntas ni aclaraciones.
                </p>
            </div>
            <div class="oferta-item" data-aos="fade-up" data-aos-duration="1000">
                <div class="icono-oferta">
                    <img src="{{ url('web/img/MercadoPago-Rosado.png') }}" alt="mercado-pago">
                </div>
                <h3>Compra 100% segura, protegida por Mercado Pago.</h3>
                <p>Garantía de Mercado Pago, compra con confianza, aceptamos todas las tarjetas de débito y crédito.</p>
            </div>
            <div class="oferta-item" data-aos="fade-left" data-aos-duration="1000">
                <div class="icono-oferta">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <h3>Envío el mismo día.</h3>
                <p>Enviamos tu Andamio Ligero Plegable SBT-10 el mismo día para que lo recibas en menos de 5 días
                    hábiles.</p>
            </div>
        </div>
    </div>
</section>

<!-- Sección CTA con Contador 2-->
<section class="cta-cron-section">
    <div class="cta-cron-content content">
        <div class="cta-cron-left">
            <h2>¡Compra ahora y obtén un descuento exclusivo!</h2>
            <p>Unidades disponibles en este momento:</p>
            <h3 class='counter counter2' id="counter2">0</h3>
            <h3 class="mobile">De
                <span class="precio-original-container">
                    <span class="precio-original">$3,330 </span>
                    <span class="linea" data-aos="fade-right" data-aos-duration="1000"></span>
                </span>
                a
            </h3>
            <div class="precio-descuento-container mobile" data-aos="zoom-in" data-aos-duration="2200">
                <h3 class="precio-descuento">$1,999</h3>
            </div>
            <form enctype="multipart/form-data" method="get" class="cart mobile"
                action="{{ route('comprar_ahora') }}">
                <div class="quantity quantity-lg">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="request" value="landing">
                    <input type="hidden" name="id_producto" value="34">
                    <input type="hidden" name="cantidad" value="1">
                    <input type="hidden" name="imagen"
                        value="https://andamiosligeros.com/storage/files/34_SBT-10.webp">
                    <input type="hidden" name="envio" value="0">
                    <input type="hidden" name="post_titulo" value="Andamio Ligero Plegable SBT-10">
                    <input type="hidden" name="precio_prodcuto" value="1999">
                </div>
                <button id="setLocalStorage" type="submit" class="cta-cron-button cta-button">Quiero aprovechar mi descuento</button>
            </form>
        </div>
        <div class="cta-cron-right">
            <h3>De
                <span class="precio-original-container">
                    <span class="precio-original">$3,330 </span>
                    <span class="linea" data-aos="fade-right" data-aos-duration="1000"></span>
                </span>
                a
            </h3>
            <div class="precio-descuento-container" data-aos="zoom-in" data-aos-duration="2200">
                <h3 class="precio-descuento">$1,999</h3>
            </div>
            <form enctype="multipart/form-data" method="get" class="cart"
                action="{{ route('comprar_ahora') }}">
                <div class="quantity quantity-lg">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="request" value="landing">
                    <input type="hidden" name="id_producto" value="34">
                    <input type="hidden" name="cantidad" value="1">
                    <input type="hidden" name="imagen"
                        value="https://andamiosligeros.com/storage/files/34_SBT-10.webp">
                    <input type="hidden" name="envio" value="0">
                    <input type="hidden" name="post_titulo" value="Andamio Ligero Plegable SBT-10">
                    <input type="hidden" name="precio_prodcuto" value="1999">
                </div>
                <button id="setLocalStorage" type="submit" class="cta-cron-button cta-button">Quiero aprovechar mi descuento</button>
            </form>
        </div>
    </div>
</section>

<!-- Sección Llamada a la Acción (CTA) -->
{{-- <section class="cta-section">
    <div class="cta-background" data-aos="fade-right" data-aos-duration="500">
        <div class="cta-content content">
            <div class="cta-text">
                <h2>¡No Pierdas la Oportunidad!</h2>
                <p>Transforma tus proyectos con nuestros productos innovadores. Aprovecha nuestras ofertas exclusivas y
                    obtén el
                    mejor equipo al mejor precio.</p>
            </div>
            <div class="cta-buttons">
                <a href="#comprar" class="cta-button">Comprar Ahora</a>
            </div>
        </div>
    </div>
</section> --}}

{{-- Sección de Medidas --}}
<section class="medidas-section">
    <div class="medidas-content content">
        <h2>Medidas</h2>
        <div class="medidas-btn-container">
            <a class="medidas-btn active" href="#SBT-10_Alto">Alto</a>
            <a class="medidas-btn" href="#SBT-10_Ancho">Ancho</a>
            <a class="medidas-btn" href="#SBT-10_Longitud">Longitud</a>
        </div>
        <div class="medidas-img-container">
            <img id="SBT-10_Alto" src="{{ url('web/img/SBT-10/Andamio_SBT-10_Alto.png') }}" alt="">
            <img id="SBT-10_Ancho" src="{{ url('web/img/SBT-10/Andamio_SBT-10_Ancho.png') }}" alt="">
            <img id="SBT-10_Longitud" src="{{ url('web/img/SBT-10/Andamio_SBT-10_Longitud.png') }}" alt="">
        </div>
    </div>
</section>

<!-- Sección de Testimonios -->
<section class="testimonios-section">
    <div class="testimonios-content content">
        <h2>Lo que nuestros clientes dicen</h2>
        <div class="grid-testimonios">
            <div class="testimonio" data-aos="fade-up" data-aos-duration="400">
                <img src="{{ url('web/img/GiancarloBustamente.jpeg') }}" alt="Giancarlo Bustamente">
                <p class="nombre">Giancarlo Bustamante.</p>
                <p class="comentario">"¡Wow! En verdad me sorprende lo ligeros y resistentes que son, soy plomero de
                    profesión y para uso rudo es perfecto."</p>
            </div>
            <div class="testimonio" data-aos="fade-up" data-aos-duration="800">
                <img src="{{ url('web/img/MariaGomez.jpeg') }}" alt="Maria Gomez">
                <p class="nombre">María Gómez</p>
                <p class="comentario">"Excelente servicio y productos de alta calidad. Recomiendo esta empresa a todos
                    mis colegas."</p>
            </div>
            <div class="testimonio" data-aos="fade-up" data-aos-duration="1200">
                <img src="{{ url('web/img/CarlosRamirez.jpeg') }}" alt="Carlos Ramirez">
                <p class="nombre">Carlos Ramírez</p>
                <p class="comentario">"La mejor experiencia de compra que he tenido. Los andamios son duraderos y el
                    soporte al cliente es excepcional."</p>
            </div>
        </div>
    </div>
</section>

<!-- Sección de Preguntas Frecuentes -->
<section class="faqs-section">
    <div class="content">
        <h2>Preguntas Frecuentes</h2>
        <div class="faq-item">
            <button class="faq-question">¿Cuál es el peso máximo que soportan los andamios?<i
                    class="fa fa-chevron-down"></i></button>
            <div class="faq-answer">
                <p>Los andamios están diseñados para soportar hasta 300 kg, garantizando seguridad y estabilidad en sus
                    proyectos.</p>
            </div>
        </div>
        <div class="faq-item">
            <button class="faq-question">¿Los andamios están galvanizados?<i class="fa fa-chevron-down"></i></button>
            <div class="faq-answer">
                <p>Sí, nuestros andamios están galvanizados para ofrecer una mayor resistencia a la corrosión y una vida
                    útil más prolongada.</p>
            </div>
        </div>
        <div class="faq-item">
            <button class="faq-question">¿Ofrecen envío a todo el país?<i class="fa fa-chevron-down"></i></button>
            <div class="faq-answer">
                <p>Ofrecemos envío a todo el territorio nacional con tiempos de entrega de 3 a 5 días hábiles.</p>
            </div>
        </div>
    </div>
</section>

<!-- Sección Garantías y Políticas de Devolución -->
{{-- <section class="garantias-section">
    <div class="garantias-content content">
        <h2>Garantías y Políticas de Devolución</h2>
        <div class="garantia-item" data-aos="fade-left" data-aos-duration="1000">
            <h3><i class="fa fa-shield-alt"></i> Garantía del Producto</h3>
            <p>Nuestros productos están respaldados por una garantía de 2 años. Cualquier defecto de fabricación será
                cubierto sin costo adicional para el cliente.</p>
        </div>
        <div class="garantia-item" data-aos="fade-right" data-aos-duration="1000">
            <h3><i class="fa-solid fa-rotate-left"></i> Política de Devolución</h3>
            <p>Ofrecemos una política de devolución de 30 días. Si no está satisfecho con su compra, puede devolver el
                producto en su estado original dentro de los 30 días posteriores a la recepción para un reembolso
                completo.</p>
        </div>
    </div>
</section> --}}

<!-- Sección Comparaciones -->
<section class="comparaciones-section">
    <div class="content">
        <h2>¿Cómo se Compara Nuestro Producto?</h2>
        <p class="comparaciones-texto">Compara nuestro producto con las opciones de la competencia y descubre por qué
            somos la mejor elección para tus necesidades.</p>
        <div class="tabla-container">
            <div class="comparaciones-tabla">
                <div class="tabla-header">
                    <div class="tabla-titulo">Características</div>
                    <div class="tabla-titulo">Nuestro Producto</div>
                    <div class="tabla-titulo">Competidor A</div>
                    <div class="tabla-titulo">Competidor B</div>
                </div>
                <div class="tabla-row">
                    <div class="tabla-item">Capacidad de Carga</div>
                    <div class="tabla-item">200 kg</div>
                    <div class="tabla-item">150 kg</div>
                    <div class="tabla-item">180 kg</div>
                </div>
                <div class="tabla-row">
                    <div class="tabla-item">Altura Ajustable</div>
                    <div class="tabla-item">Sí</div>
                    <div class="tabla-item">No</div>
                    <div class="tabla-item">Sí</div>
                </div>
                <div class="tabla-row">
                    <div class="tabla-item">Material</div>
                    <div class="tabla-item">Tubería Galvanizada</div>
                    <div class="tabla-item">Aluminio</div>
                    <div class="tabla-item">Acero</div>
                </div>
                <div class="tabla-row">
                    <div class="tabla-item">Precio</div>
                    <div class="tabla-item">$1999</div>
                    <div class="tabla-item">$2490</div>
                    <div class="tabla-item">$2329</div>
                </div>
            </div>
        </div>
        <div class="comparaciones-razones">
            <h2>¿Por Qué Elegir Nuestro Producto?</h2>
            <ul>
                <li><i class="fa fa-check-circle" aria-hidden="true"></i> Mayor capacidad de carga para garantizar la
                    seguridad.</li>
                <li><i class="fa fa-check-circle" aria-hidden="true"></i> Diseño ajustable para adaptarse a diferentes
                    necesidades.</li>
                <li><i class="fa fa-check-circle" aria-hidden="true"></i> Fabricado con materiales de alta calidad
                    para mayor durabilidad.</li>
                <li><i class="fa fa-check-circle" aria-hidden="true"></i> Precio competitivo con características
                    superiores.</li>
            </ul>
        </div>
    </div>
</section>

<!-- Sección CTA con Contador-->
<section class="cta-cron-section">
    <div class="cta-cron-content content">
        <div class="cta-cron-left">
            <h2>¡Compra ahora y obtén un descuento exclusivo!</h2>
            <p>Unidades disponibles en este momento:</p>
            <h3 class='counter' id="counter">0</h3>
            <h3>De
                <span class="precio-original-container">
                    <span class="precio-original">$3,330 </span>
                    <span class="linea" data-aos="fade-right" data-aos-duration="1000"></span>
                </span>
                a
            </h3>
            <div class="precio-descuento-container" data-aos="zoom-in" data-aos-duration="2200">
                <h3 class="precio-descuento">$1,999</h3>
            </div>
            <form enctype="multipart/form-data" method="get" class="cart" action="{{ route('comprar_ahora') }}">
                <div class="quantity quantity-lg">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="request" value="landing">
                    <input type="hidden" name="id_producto" value="34">
                    <input type="hidden" name="cantidad" value="1">
                    <input type="hidden" name="imagen"
                        value="https://andamiosligeros.com/storage/files/34_SBT-10.webp">
                    <input type="hidden" name="envio" value="0">
                    <input type="hidden" name="post_titulo" value="Andamio Ligero Plegable SBT-10">
                    <input type="hidden" name="precio_prodcuto" value="1999">
                </div>
                <button id="setLocalStorage" type="submit" class="cta-cron-button cta-button">Quiero aprovechar mi descuento</button>
            </form>
        </div>
    </div>
</section>

<!-- Sección de Garantía -->
<section class="garantia-section">
    <div class="garantia-content content">
        <div class="garantia-box">
            <div class="garantia-logo" data-aos="zoom-out" data-aos-duration="1000">
                <img src="{{ url('web/img/Garantia-AndamiosLigeros.png') }}" alt="garantia-andamios-ligeros">
            </div>
            <div class="garantia-text">
                <h3>7 Días de Garantía</h3>
                <p>¡Compra con confianza! Si no estás satisfecho, te ofrecemos 7 días para solicitar una devolución sin
                    complicaciones.</p>
            </div>
        </div>
    </div>
</section>

{{-- <section class="section-intro" id="modelos">
    <div class="producto-center-header">



        <div class="cont-tit-intro">
            <h3 class="text-yellow">ANDAMIO LIGERO PASILLERO</h3>
            <h1 class="border-title-secc">
                SBT-4
            </h1>

        </div>
        <div class="cont-img-ficha">
            <img src="{{ url('web/img/andamios/andamio-ligero-galvanizado-pasillero-sbt-4.webp') }}" alt="">
        </div>
        <div class="piso">
            <img src="{{ url('web/img/suelo-red.webp') }}" alt="">
        </div>
    </div>
</section>

<section class="section-fichas">
    <div class="contenido-fichas">
        <div class="grid-flex wrapper">
            <div class="ficha-t ficha-d">
                <div class="tit-ficha">
                    <h3>Descripción <i class="fa fa-file-text" aria-hidden="true"></i></h3>
                </div>
                <div class="txt-ficha">
                    <p>Andamio Pasillero de cuatro peldaños, el más pequeño en su tipo, fácil de transportar, ideal para
                        espacios reducidos y trabajos en interior, no se recomienda apilar más de 3 elementos, tambien
                        es ideal para alturas que no se rebase los 4 metros.</p>
                </div>
            </div>
            <div class="ficha-t ficha-mat">
                <div class="tit-ficha">
                    <h3>Materiales <i class="fa fa-cogs" aria-hidden="true"></i></h3>
                </div>
                <div class="txt-ficha">
                    <p>
                    <p>Tubería galvanizada de 1,1/2 pulgadas. Cal. 18</p>
                    <p>Soldadura de microalambre de acero al bajo</p>
                    <p>Carbono con núcleo fundente.</p>
                    <p>Acabado en electrogalvanizado.</p>
                    <p>Pernos de seguridad en acero de 1/2</p>
                    <p>Pulgadas con mariposa.</p>
                    <p>Niples en acero 1, 1/4 de pulgada cédula 30.</p>
                    <p>Pasadoores en acero de 1/4 pulgada.</p>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section> --}}