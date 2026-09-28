@include('web_andamios.components.galeria_producto.galeria_css')
@include('web_andamios.components.galeria_producto.galeria_js')

<section id="informacion-producto">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-7 mb-4">
                <section class="gallery">
                    <div class="gallery__main">
                        <img id="main-image" class="gallery__img" data-aos="fade-up" data-aos-easing="ease-in-sine"
                            src="{{ url('web/img/andamios/andamios-plegables-multiusos-galvanizados.webp') }}"
                            alt="Imagen principal" />
                    </div>
                    <div class="gallery__thumbs d-flex justify-content-between">
                        <div class="gallery__thumb">
                            <input type="radio" id="img-1" name="gallery" class="gallery__selector" checked />
                            <img src="{{ url('web/img/andamios/SBT-6/andamio-SBT-6-1.webp') }}" alt="Miniatura 1" loading="lazy"
                                onclick="changeImage('{{ url('web/img/andamios/SBT-6/andamio-SBT-6-1.webp') }}', this)" />
                        </div>
                        <div class="gallery__thumb">
                            <input type="radio" id="img-2" name="gallery" class="gallery__selector" />
                            <img src="{{ url('web/img/andamios/SBT-6/andamio-SBT-6-2.webp') }}" alt="Miniatura 2" loading="lazy"
                                onclick="changeImage('{{ url('web/img/andamios/SBT-6/andamio-SBT-6-2.webp') }}', this)" />
                        </div>
                        <div class="gallery__thumb">
                            <input type="radio" id="img-3" name="gallery" class="gallery__selector" />
                            <img src="{{ url('web/img/andamios/SBT-6/andamio-SBT-6-3.webp') }}" alt="Miniatura 3" loading="lazy"
                                onclick="changeImage('{{ url('web/img/andamios/SBT-6/andamio-SBT-6-3.webp') }}', this)" />
                        </div>
                        <div class="gallery__thumb">
                            <input type="radio" id="img-4" name="gallery" class="gallery__selector" />
                            <img src="{{ url('web/img/andamios/SBT-6/andamio-SBT-6-4.webp') }}" alt="Miniatura 4" loading="lazy"
                                onclick="changeImage('{{ url('web/img/andamios/SBT-6/andamio-SBT-6-4.webp') }}', this)" />
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-lg-6 col-md-5">
                <h3 class="mb-4">Andamio Ligero de Alta Estabilidad:</h3>
                <p class="mt-4 mb-4" style="text-align: justify;">
                    Nuestros andamios ligeros SBT-2 son fáciles de transportar, gracias a su diseño y su peso
                    reducido. Además, su diseño robusto y seguro garantiza la máxima estabilidad al trabajar en altura,
                    proporcionando la seguridad que necesitas para realizar tu trabajo de manera efectiva.
                </p>
                <div class="mt-4 pt-4 text-center">
                    <a class="hero-btn" href="{{ url('tienda/andamio-galvanizado-banquetero-sbt-2') }}">
                        COMPRAR AHORA
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
