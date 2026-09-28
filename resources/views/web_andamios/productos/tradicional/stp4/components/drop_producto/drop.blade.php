@include('web_andamios.components.drop_producto.drop_css')


<section class="my-2" id="colapse-producto">
    <div class="container">
        <div class="accordion" id="accordionExample">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6">
                    <div class="pt-2">
                        <ul class="testimonial-list">
                            <li>
                                <div class="card card_caracteristicas p-3 " data-toggle="collapse"
                                    data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"
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
                        </ul>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-1">
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                            data-parent="#accordionExample">
                            <div class="card-body" data-aos="fade-up" data-aos-anchor-placement="center-bottom">
                                <p>Andamio tradicional de 4 peldaños en la escalerilla, con cruceta tipo tijeras, es
                                    ideal para alcanzar gran altura y con su área de trabajo de 2.5m2 crea un espacio
                                    cómodo en la plataforma. Además la distancia entre peldaños permite al trabajador
                                    acceder por el fácilmente.</p>
                            </div>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                            data-parent="#accordionExample">
                            <div class="card-body" data-aos="fade-up" data-aos-anchor-placement="center-bottom">
                                <p>Tubería de Acero Galvanizado de Alta Resistencia:
                                    Fabricada en acero galvanizado de 1 1/2 pulgadas, esta tubería es la columna
                                    vertebral de cualquier estructura confiable. Su soldadura con tecnología de
                                    microalambre garantiza una unión sólida y duradera, mientras que su acabado
                                    electrogalvanizado añade una capa de protección contra la corrosión.</p>
                            </div>
                        </div>
                        <div id="collapseTree" class="collapse" aria-labelledby="headingTwo"
                            data-parent="#accordionExample">
                            <div class="card-body" data-aos="fade-up" data-aos-anchor-placement="center-bottom">
                                {{-- <h3>Descargar ficha tecnica</h3> --}}
                                <button id="open_ficha" attr-ficha="andamios-ligeros-galvanizados-tradicionales-4-peldanos-STP4.pdf" class="btn btn-primary modern-btn">Descarga ficha
                                    tecnica</button>
                                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
