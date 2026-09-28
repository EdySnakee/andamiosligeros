@include('web_andamios.components.galeria_producto.galeria_css')
@include('web_andamios.components.galeria_producto.galeria_js')

<section id="informacion-producto">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 col-md-7 mb-4">
                <section class="gallery">
                    <div class="gallery__main">
                        <img id="main-image" class="gallery__img" data-aos="fade-up" data-aos-easing="ease-in-sine"
                            src="{{url('web/img/andamios/psvgs/andamio-tradicional-header-STP2.webp')}}"
                            alt="Imagen principal" />
                    </div>
                    <div class="gallery__thumbs d-flex justify-content-between">
                        <div class="gallery__thumb">
                            <input type="radio" id="img-1" name="gallery" class="gallery__selector" checked />
                            <img src="{{url('web/img/andamios/psvgs/andamio-tradicional-header-STP2.webp')}}"
                                alt="Miniatura 1"
                                onclick="changeImage('{{ url('web/img/andamios/psvgs/andamio-tradicional-header-STP2.webp') }}', this)" />
                        </div>
                        <div class="gallery__thumb">
                            <input type="radio" id="img-2" name="gallery" class="gallery__selector" />
                            <img src="{{url('web/img/andamios/psvgs/andamio-tradicional-STP-4.png')}}"
                                alt="Miniatura 2"
                                onclick="changeImage('{{ url('web/img/andamios/psvgs/andamio-tradicional-STP-4.png') }}', this)" />
                        </div>
                        <div class="gallery__thumb">
                            <input type="radio" id="img-3" name="gallery" class="gallery__selector" />
                            <img src="{{url('web/img/andamios/psvgs/andamio-tradicional-header-STP2.webp')}}"
                                alt="Miniatura 3"
                                onclick="changeImage('{{ url('web/img/andamios/psvgs/andamio-tradicional-header-STP2.webp') }}', this)" />
                        </div>
                    
                        <div class="gallery__thumb">
                            <input type="radio" id="img-4" name="gallery" class="gallery__selector" />
                            <img src="{{url('web/img/andamios/psvgs/andamio01-tradicional-STP2.webp')}}"
                                alt="Miniatura 4"
                                onclick="changeImage('{{ url('web/img/andamios/psvgs/andamio01-tradicional-STP2.webp') }}', this)" />
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-lg-4 col-md-5">
                <h3 class="my-1">Andamio Tradicional STP-4:</h3>
                <p>
                    <b>
                        Seguridad y Confort en las Alturas
                    </b>
                    Eleva tu rendimiento con nuestro andamio tradicional de 4 peldaños, diseñado para ofrecer una
                    solución robusta y segura en cualquier entorno de trabajo. Con su resistente cruceta tipo tijeras,
                    este andamio está optimizado para alcanzar alturas considerables, brindándote la estabilidad que
                    necesitas en todo momento.
                    La espaciosa plataforma de trabajo de 2.5 m² proporciona un área amplia y cómoda.
                </p>
            </div>
        </div>
    </div>
</section>
