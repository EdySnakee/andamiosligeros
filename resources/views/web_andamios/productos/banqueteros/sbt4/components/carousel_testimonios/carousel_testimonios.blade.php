    <div class="full-container  testimonios-section py-5 px-4">
        <h2 class="text-center text-warning mb-4">Lo que opinan nuestros clientes</h2>

        <div id="testimoniosCarousel" class="carousel slide" data-ride="carousel" data-interval="6000" data-pause="hover"
            aria-label="Carrusel de testimonios">

            <!-- Indicadores -->
            <ol class="carousel-indicators">
                <li data-target="#testimoniosCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#testimoniosCarousel" data-slide-to="1"></li>
            </ol>

            <div class="carousel-inner">

                <!-- Slide 1 -->
                <div class="carousel-item active">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-6 col-lg-3 mb-3">
                            <div class="testimonial-card text-center animable">
                                <img src="https://randomuser.me/api/portraits/men/32.jpg" class="testimonial-img"
                                    alt="Cliente 1">
                                <div class="stars">⭐⭐⭐⭐⭐</div>
                                <p>“Excelente calidad en los andamios, muy seguros y fáciles de montar.”</p>
                                <h6 class="text-warning mt-3">Juan Pérez</h6>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3 mb-3">
                            <div class="testimonial-card text-center animable">
                                <img src="/web/img/andamios/SBT-6/logos_compani/casitas.png" class="testimonial-img"
                                    alt="Cliente 2">
                                <div class="stars">⭐⭐⭐⭐⭐</div>
                                <p>“Su peso reducido y sistema plegable nos permiten moverlos fácilmente entre frentes de trabajo.”</p>
                                <h6 class="text-warning mt-3">Constructora Altavia</h6>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3 mb-3 d-none d-lg-block">
                            <div class="testimonial-card text-center animable">
                                <img src="https://randomuser.me/api/portraits/men/67.jpg" class="testimonial-img"
                                    alt="Cliente 3">
                                <div class="stars">⭐⭐⭐⭐⭐</div>
                                <p>“Muy buena atención y entrega rápida, 100% recomendados.”</p>
                                <h6 class="text-warning mt-3">Carlos López</h6>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3 mb-3 d-none d-lg-block">
                            <div class="testimonial-card text-center animable">
                                <img src="/web/img/andamios/SBT-6/logos_compani/construc2.png" class="testimonial-img"
                                    alt="Cliente 4">
                                <div class="stars">⭐⭐⭐⭐⭐</div>
                                <p>“En proyectos de altura siempre buscamos seguridad y practicidad. Estos andamios nos han dado la confianza”</p>
                                <h6 class="text-warning mt-3">Obras & Infraestructura MX</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="carousel-item">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-6 col-lg-3 mb-3">
                            <div class="testimonial-card text-center animable">
                                <img src="https://randomuser.me/api/portraits/men/15.jpg" class="testimonial-img"
                                    alt="Cliente 5">
                                <div class="stars">⭐⭐⭐⭐⭐</div>
                                <p>“El mejor equipo que hemos comprado, agiliza mucho el trabajo.”</p>
                                <h6 class="text-warning mt-3">Roberto Díaz</h6>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3 mb-3">
                            <div class="testimonial-card text-center animable">
                                <img src="/web/img/andamios/SBT-6/logos_compani/conustro.png" class="testimonial-img"
                                    alt="Cliente 6">
                                <div class="stars">⭐⭐⭐⭐</div>
                                <p>“Los usamos tanto en interiores como en exteriores. Son resistentes y versátiles, incluso en proyectos grandes.”</p>
                                <h6 class="text-warning mt-3">Grupo Edifica</h6>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3 mb-3 d-none d-lg-block">
                            <div class="testimonial-card text-center animable">
                                <img src="https://randomuser.me/api/portraits/men/50.jpg" class="testimonial-img"
                                    alt="Cliente 7">
                                <div class="stars">⭐⭐⭐⭐⭐</div>
                                <p>“Muy buena relación calidad-precio, volveré a comprar.”</p>
                                <h6 class="text-warning mt-3">Luis Ramírez</h6>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3 mb-3 d-none d-lg-block">
                            <div class="testimonial-card text-center animable">
                                <img src="/web/img/andamios/SBT-6/Andamio-Ligero-SBT6.webp" class="testimonial-img"
                                    alt="Cliente 8">
                                <div class="stars">⭐⭐⭐⭐⭐</div>
                                <p>“Son de esos productos que se recomiendan solos. Los clientes vuelven por más módulos y accesorios”</p>
                                <h6 class="text-warning mt-3">Distribuidora Construmax</h6>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <style>
        .testimonios-section {
            border-radius: 1rem;
        }

        /* Card */
        .testimonial-card {
            background: #1E3A8A;
            padding: 2rem 1.5rem;
            border-radius: 1.25rem;
            min-height: 260px;
            transform: translateY(20px);
        }

        /* Imagen circular */
        .testimonial-img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #FFD60A;
            margin-bottom: 1rem;
        }

        /* Estrellas */
        .stars {
            color: #FFD60A;
            font-size: 1rem;
            margin-bottom: 0.75rem;
        }

        /* Texto */
        .testimonial-card p {
            font-size: 0.95rem;
            line-height: 1.5;
            font-style: italic;
            color: #f5f5f5;
        }

        /* Animación */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }


        /* Se activa con JS */
        .testimonial-card.play {
            animation: fadeInUp .7s ease forwards;
        }

        /* Escalonado por columna */
        .carousel-item .col-12:nth-child(1) .testimonial-card.play {
            animation-delay: .05s
        }

        .carousel-item .col-12:nth-child(2) .testimonial-card.play {
            animation-delay: .15s
        }

        .carousel-item .col-12:nth-child(3) .testimonial-card.play {
            animation-delay: .25s
        }

        .carousel-item .col-12:nth-child(4) .testimonial-card.play {
            animation-delay: .35s
        }

        /* Indicadores (mejor contraste) */
        .carousel-indicators li {
            background-color: #FFD60A;
            opacity: .4;
        }

        .carousel-indicators .active {
            opacity: 1;
        }
    </style>

    <script>
        (function($) {
            var $car = $('#testimoniosCarousel');

            function play($item) {
                $item.find('.testimonial-card').each(function() {
                    this.classList.remove('play'); // reset
                    void this.offsetWidth; // reflow para reiniciar
                    this.classList.add('play');
                });
            }

            $car.on('slid.bs.carousel', function() {
                play($(this).find('.carousel-item.active'));
            });

            $(function() {
                play($car.find('.carousel-item.active'));
            });

            var startX = null,
                threshold = 50;
            $car.on('touchstart', function(e) {
                startX = e.originalEvent.touches[0].clientX;
            });
            $car.on('touchmove', function(e) {
                if (startX === null) return;
                var dx = e.originalEvent.touches[0].clientX - startX;
                if (Math.abs(dx) > threshold) {
                    $(this).carousel(dx < 0 ? 'next' : 'prev');
                    startX = null;
                }
            });
        })(jQuery);
    </script>
