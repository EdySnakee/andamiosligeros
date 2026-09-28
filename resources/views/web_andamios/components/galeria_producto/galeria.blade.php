@include('web_andamios.components.galeria_producto.galeria_css')
@include('web_andamios.components.galeria_producto.galeria_js')

<section id="informacion-producto">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 col-md-7 mb-4">
                <section class="gallery">
                    <div class="gallery__main">
                        <img id="main-image" class="gallery__img"  
                        data-aos="fade-up"
                        data-aos-easing="ease-in-sine"
                            src="{{ url('web/img/andamios/psvgs/andamio01-tradicional-STP1.png') }}"
                            alt="Imagen principal" />
                    </div>
                    <div class="gallery__thumbs d-flex justify-content-between">
                        <div class="gallery__thumb">
                            <input type="radio" id="img-1" name="gallery" class="gallery__selector" checked />
                            <img src="{{ url('web/img/andamios/psvgs/andamio01-tradicional-STP1.png') }}"
                                alt="Miniatura 1"
                                onclick="changeImage('{{ url('web/img/andamios/psvgs/andamio01-tradicional-STP1.png') }}', this)" />
                        </div>
                        <div class="gallery__thumb">
                            <input type="radio" id="img-2" name="gallery" class="gallery__selector" />
                            <img src="{{ url('web/img/andamios/psvgs/andamio-tradicional-STP-1.png') }}"
                                alt="Miniatura 2"
                                onclick="changeImage('{{ url('web/img/andamios/psvgs/andamio-tradicional-STP-1.png') }}', this)" />
                        </div>
                        <div class="gallery__thumb">
                            <input type="radio" id="img-3" name="gallery" class="gallery__selector" />
                            <img src="{{ url('web/img/andamios/psvgs/andamio01-tradicional-STP1.png') }}"
                                alt="Miniatura 3"
                                onclick="changeImage('{{ url('web/img/andamios/psvgs/andamio01-tradicional-STP1.png') }}', this)" />
                        </div>
                        <div class="gallery__thumb">
                            <input type="radio" id="img-4" name="gallery" class="gallery__selector" />
                            <img src="{{ url('web/img/andamios/psvgs/andamio-tradicional-STP-1.png') }}"
                                alt="Miniatura 4"
                                onclick="changeImage('{{ url('web/img/andamios/psvgs/andamio-tradicional-STP-1.png') }}', this)" />
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-lg-4 col-md-5">
                <h3 class="my-1">Andamio Ligero de Alta Estabilidad:</h3>
                <p>
                    Este andamio de medida estándar con 5 peldaños está diseñado para proporcionar una estabilidad
                    excepcional en obras de altura, facilitando la manipulación de elementos pesados. Con un área de
                    cobertura de 3 m², ofrece una base sólida para trabajos en construcción. Los 5 peldaños en su
                    estructura tipo escalerilla aseguran un ascenso cómodo y seguro.
                </p>
            </div>
        </div>
    </div>
</section>