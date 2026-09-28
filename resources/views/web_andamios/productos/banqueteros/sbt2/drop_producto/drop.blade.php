<style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap");

    body {
        font-family: "Poppins", sans-serif;
        font-weight: 300;
    }

    .modern-btn {
        background-color: #007bff;
        color: white;
        border-radius: 10px;
        padding: 15px 30px;
        border: none;
        font-size: 16px;
        font-weight: bold;
        transition: background-color 0.3s ease, transform 0.2s ease;
        box-shadow: 0 8px 10px rgba(0, 123, 255, 0.461);
    }

    .modern-btn:hover {
        background-color: #0056b3;
        box-shadow: 0 15px 20px rgba(0, 123, 255, 0.245);
        transform: translateY(-3px);
    }

    .modern-btn:active {
        transform: translateY(2px);
    }


    .card_caracteristicas {
        border: none;
        cursor: pointer;
        box-shadow: 0 0 40px rgba(51, 51, 51, .1);
        transition: background-color 0.3s ease;
    }

    .card_caracteristicas:hover {
        background-color: #f5f5f5;
        transform: scale(1.05);
    }

    .card_caracteristicas::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 5px;
        background-color: #febf01;
        transform: scaleY(0);
        transition: transform 0.3s ease;
    }

    .card_caracteristicas:hover::before,
    .card_caracteristicas.active::before {
        transform: scaleY(1);
    }

    .testimonial-list {
        list-style: none;
        padding: 0;
    }

    .testimonial-list li {
        margin-bottom: 20px;
    }

    .card-body {
        font-size: 16px;
        transition: color 0.3s ease;
    }

    .collapse.show .card-body {
        color: #000;
    }

    .collapse:not(.show) .card-body {
        color: #666;
    }


    /* Botón descarga alineado a la derecha */
    .action-right .btn-download {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: #1E3A8A;
        color: #fff;
        text-decoration: none;
        box-shadow: 0 8px 12px rgba(30, 58, 138, .25);
        transition: transform .2s ease, box-shadow .2s ease, opacity .2s ease;
    }

    .action-right .btn-download:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 18px rgba(30, 58, 138, .28);
    }

    .action-right .btn-download:active {
        transform: translateY(1px);
    }

    .action-right .btn-download svg {
        display: block
    }

    /* Botón descarga sin fondo, icono negro */
    .btn-download {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        color: #000;
        text-decoration: none;
        transition: opacity .2s ease;
    }

    .btn-download:hover {
        opacity: 0.7;
    }




    @media (max-width: 768px) {
        .card_caracteristicas {
            padding: 15px;
        }

        .card-body {
            font-size: 14px;
        }

        .testimonial-list li {
            margin-bottom: 15px;
        }
    }

    @media (max-width: 576px) {
        .card_caracteristicas {
            padding: 10px;
        }

        .card-body {
            font-size: 12px;
        }
    }
</style>

<section class="my-2" id="colapse-producto">
    <div class="container">
        <div class="accordion" id="accordionExample">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6">
                    <div class="pt-2">
                        <ul class="testimonial-list">
                            <li>
                                <div class="card card_caracteristicas p-3 " data-toggle="collapse"
                                    data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne"
                                    data-aos="fade-right" data-aos-offset="100" data-aos-easing="ease-in-sine">
                                    <div class="d-flex flex-row align-items-center">
                                        <img src="https://img.icons8.com/?size=100&id=DD7ChOITzFAz&format=png&color=000000"
                                            width="50" class="mr-2">
                                        <span class="font-weight-normal">Descripción</span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="card card_caracteristicas p-3" data-toggle="collapse"
                                    data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"
                                    data-aos="fade-right" data-aos-offset="100" data-aos-easing="ease-in-sine">
                                    <div class="d-flex flex-row align-items-center">
                                        <img src="https://img.icons8.com/?size=100&id=AX0cgeASZsRU&format=png&color=000000"
                                            width="50" class="mr-2">
                                        <span class="font-weight-normal">Materiales</span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="card card_caracteristicas p-3" data-toggle="collapse"
                                    data-target="#collapseTree" aria-expanded="false" aria-controls="collapseTwo"
                                    data-aos="fade-right" data-aos-offset="100" data-aos-easing="ease-in-sine">
                                    <div class="d-flex flex-row align-items-center">
                                        <img src="https://img.icons8.com/?size=100&id=79990&format=png&color=000000"
                                            width="50" class="mr-2">
                                        <span class="font-weight-normal">Ficha tecnica</span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="card card_caracteristicas p-3" data-toggle="collapse"
                                    data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour"
                                    title="Abrir revista digital en visor interactivo. Usa el botón de la derecha para descargar el PDF.">

                                    <div class="d-flex align-items-center justify-content-center position-relative">
                                        <!-- Texto centrado -->
                                        <div class="d-flex flex-row align-items-center">
                                            <img src="https://img.icons8.com/material-outlined/48/magazine--v1.png?color=1E3A8A"
                                                width="50" class="mr-2" alt="Revista digital">
                                            <span class="font-weight-normal">Revista digital</span>
                                        </div>

                                        <!-- Botón a la derecha, alineado horizontal -->
                                        <a href="/web/img/SBT-6/revista/Revista-Andamio-Ligero-SBT6-2025.pdf"
                                            class="btn-download position-absolute" style="right: 15px;" download
                                            aria-label="Descargar revista digital en PDF" title="Descargar Revista digital en PDF">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                viewBox="0 0 24 24" fill="none">
                                                <path
                                                    d="M12 3v10m0 0 4-4m-4 4-4-4M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-1">
                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                            data-parent="#accordionExample">
                            <div class="card-body" data-aos="fade-up" data-aos-anchor-placement="center-bottom">
                                <p style="text-align: justify;">
                                    Con una altura de 2.00 metros y una capacidad de carga de hasta 500 kg,
                                    nuestros andamios ligeros SBT-2 te permiten trabajar en diferentes áreas y realizar
                                    una amplia variedad de tareas. Además, su diseño sencillo y fácil de montar te
                                    permite ahorrar tiempo y ser más eficiente en tu trabajo.
                                </p>
                            </div>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                            data-parent="#accordionExample">
                            <div class="card-body" data-aos="fade-up" data-aos-anchor-placement="center-bottom">
                                <p style="text-align: justify">Tubería de Acero Galvanizado de Alta Resistencia:
                                    Fabricada en acero galvanizado de 1 1/2 pulgadas, esta tubería es la columna
                                    vertebral de cualquier estructura confiable. Su soldadura con tecnología de
                                    microalambre garantiza una unión sólida y duradera, mientras que su acabado
                                    electrogalvanizado añade una capa de protección contra la corrosión.</p>
                            </div>
                        </div>
                        <div id="collapseTree" class="collapse" aria-labelledby="headingTwo"
                            data-parent="#accordionExample">
                            <div class="card-body" data-aos="fade-up" data-aos-anchor-placement="center-bottom">
                                <p style="text-align: justify">
                                    Accede a la ficha técnica oficial de este andamio, homologado bajo normas vigentes y
                                    respaldado con memoria de cálculo y análisis estructurales que garantizan seguridad,
                                    resistencia y cumplimiento normativo en cada proyecto.
                                </p>
                                <button id="open_ficha"
                                    attr-ficha="andamios-ligeros-galvanizados-baqueteros-4-peldanos-SBT2.pdf"
                                    class="btn btn-primary modern-btn">Descarga ficha
                                    tecnica</button>
                            </div>
                        </div>
                        <div id="collapseFour" class="collapse show" aria-labelledby="headingFour"
                            data-parent="#accordionExample">
                            <div class="card-body" data-aos="fade-up" data-aos-anchor-placement="center-bottom">
                                <iframe allowfullscreen="allowfullscreen" allow="clipboard-write" scrolling="no"
                                    class="fp-iframe" src="https://heyzine.com/flip-book/6e2d28d457.html"
                                    style="border: 0px solid lightgray; width: 100%; height: 400px;"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.btn-download').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.stopPropagation(); // evita abrir/cerrar el acordeón
            });
        });
    });
</script>
