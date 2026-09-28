{{-- <section id="faq" class="faq seccion-normal pt-0 mt-3"> --}}


<style>
    .faq .accordion .panel-title {
        display: block;
        width: 100%;
        /* background: #fff; */
        padding: 15px 40px 15px 20px;
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 0;
        color: #242424;
        position: relative;
        border-radius: 3px;
        cursor: pointer
    }

    .faq .accordion .panel .panel-body {
        padding: 4px 20px 7px
    }

    .faq .accordion .panel {
        margin-bottom: 20px;
        /* background: #fff; */
        border-radius: 3px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, .1);
        position: relative
    }

    .faq .accordion .panel::after {
        position: absolute;
        content: " ";
        top: 0;
        left: 0;
        height: 100%;
        width: 4px;
        background-image: linear-gradient(55deg, #0056b3 0, #001929 100%)
    }
</style>

<section id="faq" class="faq mt-3 bg-white">
    <div class="container">
        {{-- <div class="section-title extra text-center py-3">
            <h2 class="title"><b>PREGUNTAS FRECUENTES</b></h2>
            <br>
        </div> --}}
        <div class="row">
            <div class="col-lg-6 d-flex">
                <div class="faq-img aos-init aos-animate" data-aos="fade-left">
                    <img  src="{{url('web/img/andamios/psvgs/andamio-tradicional-header-STP2.webp')}}"
                        alt="Andamios Ligeros Galvanizados Plegables">
                </div>
            </div>
            <div class="col-lg-6 d-flex">
                <div class="panel-group accordion" id="accordion-1" data-aos="fade-right">
                    <div class="panel">
                        <div class="panel-heading">
                            <h4 data-toggle="collapse" aria-expanded="false" data-target="#one" aria-controls="one"
                                class="panel-title collapsed">
                                ¿Medidas del andamio plegable STP-4?
                            </h4>
                        </div>
                        <div id="one" class="panel-collapse collapse show" aria-labelledby="one"
                            data-parent="#accordion-1" style="">
                            <div class="panel-body">
                                <p>La espaciosa plataforma de trabajo de 2.5 m²</p>
                            </div>
                        </div>
                    </div>
                    <div class="panel">
                        <div class="panel-heading">
                            <h4 data-toggle="collapse" aria-expanded="true" data-target="#two" aria-controls="two"
                                class="panel-title">
                                ¿Cuantos andamios se puede apilar?
                            </h4>
                        </div>
                        <div id="two" class="panel-collapse collapse " aria-labelledby="two"
                            data-parent="#accordion-1" style="">
                            <div class="panel-body">
                                <p>
                                    Se puede apilar los que requiera, tomar en cuenta que la norma de seguridad indica
                                    que por cada cuatro metros se tiene que apuntalar o asegurar.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="panel">
                        <div class="panel-heading">
                            <h4 data-toggle="collapse" aria-expanded="false" data-target="#three" aria-controls="three"
                                class="panel-title">
                                ¿Cual es el precio del andamio?
                            </h4>
                        </div>
                        <div id="three" class="panel-collapse collapse" aria-labelledby="three"
                            data-parent="#accordion-1">
                            <div class="panel-body">
                                <p>
                                    Contamos con precios competitivos los cuales puede consultar en nuestro apartado de
                                    <a href="{{ url('/promociones') }}" target="_blank">promociones</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="panel">
                        <div class="panel-heading">
                            <h4 data-toggle="collapse" aria-expanded="false" data-target="#four" aria-controls="four"
                                class="panel-title">
                                ¿Que incluye la compra de mi andamio?
                            </h4>
                        </div>
                        <div id="four" class="panel-collapse collapse" aria-labelledby="four"
                            data-parent="#accordion-1">
                            <div class="panel-body">
                                <p>
                                    El andamio plegable incluye cruceta de seguridad y sus 4 niples de seguridad. Los
                                    accessorios: <a href="{{ url('tienda/juego-de-rueda-para-andamio') }}">Ruedas</a>,
                                    <a href="{{ url('tienda/plataforma-metalica-de-1.60m') }}">Plataforma</a> y <a
                                        href="{{ url('tienda/tornillo-nivelador-para-andamio') }}">Niveladores</a> se
                                    venden por separado.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="panel">
                        <div class="panel-heading">
                            <h4 data-toggle="collapse" aria-expanded="false" data-target="#four2" aria-controls="four2"
                                class="panel-title">
                                Diferencias entre el Plegable y el Banquetero
                            </h4>
                        </div>
                        <div id="four2" class="panel-collapse collapse" aria-labelledby="four2"
                            data-parent="#accordion-1">
                            <div class="panel-body">
                                <p>
                                    🏗 El andamio plegable consta de <b>1 cruceta integrada tipo bisagra </b>y se
                                    complementa con una cruceta de seguridad. Esto permite que el andamio sea más fácil
                                    a la hora de armar y desarmar evitando así que las piezas se extravíen, Con una
                                    altura de 1.60m es el más práctico en su tipo.
                                </p>
                                <p>
                                    🏗 El andamio banquetero consta de <b>2 crucetas tipo tijera</b> como los
                                    convencionales, con una altura de 1.80m permite apilar menos piezas para alcanzar la
                                    altura deseada.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>
