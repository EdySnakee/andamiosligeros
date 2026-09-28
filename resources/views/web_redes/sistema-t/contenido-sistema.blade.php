<!-- page title area start -->
<?php
$titulo_servicio = 'SISTEMA T';
?>
<style>
    /* Estilos modernizados para la vista de Sistema T */
    .brand-hero {
        position: relative;
        background-position: center center;
        background-size: cover;
        background-repeat: no-repeat;
        z-index: 1;
        overflow: hidden;
    }

    .brand-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(0, 35, 90, 0.88) 0%, rgba(145, 80, 152, 0.78) 100%);
        z-index: -1;
    }

    .hero-glass-card {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 24px;
        padding: 50px 40px;
        max-width: 500px;
        margin: 0 auto;
        box-shadow: 0 24px 60px rgba(0, 0, 0, 0.25);
    }

    .hero-subtitle {
        font-size: 1.1rem;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: #be6aeb;
        font-weight: 700;
        margin-bottom: 12px;
        display: block;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        color: #ffffff;
        text-transform: uppercase;
        margin-bottom: 20px;
        letter-spacing: 1px;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.25);
    }

    .hero-breadcrumb .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
    }

    .hero-breadcrumb .breadcrumb-item,
    .hero-breadcrumb .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.85);
        font-size: 0.95rem;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .hero-breadcrumb .breadcrumb-item a:hover {
        color: #be6aeb;
    }

    .hero-breadcrumb .breadcrumb-item.active {
        color: #ffffff;
        font-weight: 600;
    }

    .hero-breadcrumb .breadcrumb-item+.breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.5);
    }

    /* Image improvements */
    .img-modern-wrapper {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.12);
        transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .img-modern-wrapper img {
        width: 100%;
        height: auto;
        display: block;
        transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .img-modern-wrapper:hover {
        box-shadow: 0 35px 70px rgba(145, 80, 152, 0.22);
        transform: translateY(-6px);
    }

    .img-modern-wrapper:hover img {
        transform: scale(1.05);
    }

    .badge-safety {
        position: absolute;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, #00235a, #915098);
        color: #ffffff;
        padding: 8px 18px;
        font-size: 0.85rem;
        font-weight: 700;
        border-radius: 50px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        text-transform: uppercase;
        letter-spacing: 1px;
        border: 1px solid rgba(255, 255, 255, 0.25);
        z-index: 2;
    }

    /* Specs Panel */
    .specs-container {
        background: #f8f9fa;
        border-radius: 20px;
        padding: 30px;
        margin: 45px 0;
        border: 1px solid rgba(0, 35, 90, 0.04);
        box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.02);
    }

    .spec-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 25px 20px;
        text-align: center;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.03);
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        border-top: 4px solid #915098;
        height: 100%;
    }

    .spec-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(145, 80, 152, 0.14);
        border-top-color: #be6aeb;
    }

    .spec-icon {
        font-size: 2.2rem;
        color: #915098;
        margin-bottom: 15px;
        transition: transform 0.4s ease;
    }

    .spec-card:hover .spec-icon {
        transform: scale(1.15);
    }

    .spec-value {
        font-size: 1.9rem;
        font-weight: 800;
        color: #00235a;
        line-height: 1.2;
        margin-bottom: 6px;
        font-family: 'Exo', sans-serif;
    }

    .spec-label {
        font-size: 0.85rem;
        font-weight: 700;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }

    /* Service main description style */
    .s-details-text h2.details-title {
        font-size: 2.2rem;
        font-weight: 800;
        color: #00235a;
        position: relative;
        padding-bottom: 4px;
        margin-top: 10px;
        margin-bottom: 15px;
        text-transform: uppercase;
    }

    .s-details-text h2.details-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 70px;
        height: 4px;
        background: linear-gradient(90deg, #915098, #be6aeb);
        border-radius: 2px;
    }

    .s-details-text p.desc-p {
        font-size: 16px;
        line-height: 1.85;
        color: #4a5568;
        margin-bottom: 24px;
        text-align: justify;
    }

    /* Component Grid */
    .component-card {
        background: #ffffff;
        border-radius: 18px;
        padding: 35px 30px;
        margin-bottom: 30px;
        box-shadow: 0 10px 35px rgba(0, 0, 0, 0.03);
        border: 1px solid rgba(0, 35, 90, 0.04);
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        height: 100%;
    }

    .component-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px rgba(145, 80, 152, 0.14);
        border-color: rgba(145, 80, 152, 0.18);
    }

    .component-icon-box {
        width: 64px;
        height: 64px;
        border-radius: 14px;
        background: rgba(145, 80, 152, 0.08);
        color: #915098;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.7rem;
        margin-bottom: 22px;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .component-card:hover .component-icon-box {
        background: #915098;
        color: #ffffff;
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 8px 25px rgba(145, 80, 152, 0.35);
    }

    .component-name {
        font-size: 1.35rem;
        font-weight: 750;
        color: #00235a;
        margin-bottom: 18px;
        text-transform: uppercase;
        font-family: 'Exo', sans-serif;
    }

    .component-desc-list {
        margin: 0;
        padding: 0;
    }

    .component-desc-list li {
        list-style: none;
        position: relative;
        padding-left: 22px;
        margin-bottom: 14px;
    }

    .component-desc-list li::before {
        content: '';
        position: absolute;
        left: 0;
        top: 10px;
        width: 7px;
        height: 7px;
        background-color: #915098;
        border-radius: 50%;
        transition: transform 0.3s ease;
    }

    .component-card:hover .component-desc-list li::before {
        transform: scale(1.25);
        background-color: #be6aeb;
    }

    .component-desc-list li p {
        margin: 0;
        font-size: 0.98rem;
        line-height: 1.7;
        color: #4a5568;
        display: inline;
    }

    /* Sidebar overrides */
    .services-sidebar {
        border-radius: 20px !important;
        background: #ffffff !important;
        padding: 35px 30px !important;
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.04) !important;
        border: 1px solid rgba(0, 35, 90, 0.04) !important;
        margin-bottom: 35px !important;
        transition: all 0.3s ease;
    }

    .services-sidebar:hover {
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.07) !important;
    }

    .services-sidebar .services-title h2 {
        color: #00235a !important;
        font-size: 1.35rem !important;
        font-weight: 750 !important;
        border-bottom: 2px solid rgba(145, 80, 152, 0.15) !important;
        padding-bottom: 14px !important;
        margin-bottom: 22px !important;
        text-transform: uppercase;
        font-family: 'Exo', sans-serif;
    }

    .services-sidebar ul li {
        border-bottom: 1px solid rgba(0, 35, 90, 0.05) !important;
        padding: 14px 0 !important;
        transition: all 0.3s ease !important;
    }

    .services-sidebar ul li:last-child {
        border-bottom: none !important;
    }

    .services-sidebar ul li a {
        color: #4a5568 !important;
        font-weight: 600 !important;
        display: flex !important;
        align-items: center !important;
        transition: all 0.3s ease !important;
        text-decoration: none !important;
        font-size: 0.95rem;
    }

    .services-sidebar ul li a:hover {
        color: #915098 !important;
        transform: translateX(6px) !important;
    }

    .services-sidebar ul li img {
        filter: sepia(1) saturate(5) hue-rotate(240deg) brightness(0.8);
        /* Aligns standard icon color to theme purple */
        transition: all 0.3s ease;
        margin-right: 12px;
    }

    .services-sidebar ul li a:hover img {
        transform: scale(1.2);
    }

    .component-extra-content {
        display: none;
        animation: fadeIn 0.35s ease;
    }

    .component-extra-content.show {
        display: block;
    }

    .component-image {
        width: 100%;
        border-radius: 14px;
        margin: 20px 0;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }

    .btn-ver-mas {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 10px;
        padding: 10px 18px;
        border: none;
        border-radius: 50px;
        background: linear-gradient(135deg, #915098, #be6aeb);
        color: #fff;
        font-weight: 600;
        cursor: pointer;
        transition: all .3s ease;
    }

    .btn-ver-mas:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(145, 80, 152, .25);
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-8px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .video-card {
        position: relative;
        overflow: hidden;
        border-radius: 18px;
        cursor: pointer;
        box-shadow: 0 10px 35px rgba(0, 0, 0, .08);
        transition: all .35s ease;
    }

    .video-card img {
        width: 100%;
        height: 260px;
        object-fit: cover;
        object-position: center center;
        display: block;
    }

    .video-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px rgba(145, 80, 152, .20);
    }

    .video-card-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 35, 90, .55);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: white;
        transition: all .3s ease;
    }

    .video-card:hover .video-card-overlay {
        background: rgba(145, 80, 152, .65);
    }

    .video-card-overlay i {
        font-size: 4rem;
        margin-bottom: 12px;
    }

    .video-card-overlay span {
        font-size: 1rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .video-modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: rgba(0, 0, 0, .85);
        justify-content: center;
        align-items: center;
    }

    .video-modal-content {
        width: 90%;
        max-width: 1000px;
        position: relative;
    }

    .video-modal-content iframe {
        width: 100%;
        height: 560px;
        border: none;
        border-radius: 16px;
    }

    .video-close {
        position: absolute;
        top: -45px;
        right: 0;
        color: white;
        font-size: 40px;
        cursor: pointer;
    }

    .zoom-image {
        cursor: zoom-in;
        transition: all .3s ease;
    }

    .zoom-image:hover {
        transform: scale(1.02);
    }

    .image-viewer {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 99999;
        background: rgba(0, 0, 0, .9);
        justify-content: center;
        align-items: center;
        padding: 40px;
    }

    .image-viewer.show {
        display: flex;
    }

    .image-viewer img {
        max-width: 95%;
        max-height: 90vh;
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, .5);
    }

    .image-viewer-close {
        position: absolute;
        top: 25px;
        right: 35px;
        font-size: 42px;
        color: #fff;
        cursor: pointer;
        line-height: 1;
    }
</style>

<section class="brand-hero pt-160 pb-160" data-background="{{ url('web/img/portadas/banner-redes-tt.webp') }}">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="hero-glass-card text-center">
                    <span class="hero-subtitle">redes anticaidas</span>
                    <h1 class="hero-title">{{ $titulo_servicio }}</h1>
                    <nav aria-label="breadcrumb" class="hero-breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/') }}">Inicio</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $titulo_servicio }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- page title area end -->
<!-- services start -->
<section class="services-details pt-70 pb-40">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-8 pr-25">
                <div class="s-details-single">

                    <div class="s-details-text">
                        <div class="s-details-thumb mb-40">
                            <div class="img-modern-wrapper">
                                <span class="badge-safety">Norma EN 1263-1</span>
                                <img src="{{ url('web/img/sistemas/Sistema-T---mallas-anticaidas---redes-y-mallas-anticaidas---Mallas-y-redes-anticaidas---Mallas-de-seguridad--Mallas-y-redes-de-seguridad---Sistema-T-de-seguridad.jpg.webp') }}"
                                    alt="Sistema T redes anticaidas redes y mallas anticaidas Mallas y redes anticaidas Mallas de seguridad Mallas y redes de seguridad Sistema T de seguridad">
                            </div>
                        </div>

                        <h2 class="details-title">{{ $titulo_servicio }}</h2>

                        <p class="desc-p">
                            El Sistema T es un sistema de protección colectiva diseñado para brindar seguridad en
                            trabajos en altura mediante una red de seguridad horizontal sostenida por soportes metálicos
                            desarrollados para su instalación al borde de la estructura. Su configuración permite crear
                            una barrera de protección continua alrededor del perímetro de la obra, interrumpiendo de
                            caídas de personas, herramientas y materiales.
                        </p>




                        <div class="img-modern-wrapper" style="margin: 35px 0;">
                            <img src="{{ url('web/img/Banner-Redes-02.webp') }}"
                                alt="Sistema T redes anticaidas redes y mallas anticaidas Mallas y redes anticaidas Mallas de seguridad Mallas y redes de seguridad Sistema T de seguridad">
                        </div>

                        <p class="desc-p"> La red se instala sobre largueros metálicos que se acoplan a soportes tipo
                            "T", anclados de
                            forma segura a la estructura del edificio. Gracias a la resistencia, flexibilidad y
                            capacidad de absorción de energía de la red, el sistema actúa como una superficie de
                            retención capaz de amortiguar el impacto de una caída, disminuyendo las fuerzas transmitidas
                            al trabajador y evitando que sea proyectado fuera del área protegida.</p>

                        <p class="desc-p"> Por sus características técnicas, el Sistema T está especialmente indicado
                            para la
                            protección perimetral de edificaciones en proceso de construcción, proporcionando una
                            solución eficiente, reutilizable y alineada con los principios de seguridad colectiva
                            establecidos en la NOM-009-STPS y las mejores prácticas internacionales para trabajos en
                            altura.</p>

                        <!-- Panel de Especificaciones Destacadas -->
                        <div class="specs-container">
                            <div class="text-center mb-1">

                                <h2 class="details-title d-inline-block">
                                    Modalidades del Sistema T
                                </h2>

                                <p class="desc-p mt-4">
                                    Cada proyecto de construcción presenta condiciones únicas, por lo que el
                                    <strong>Sistema T</strong> cuenta con diferentes modalidades de instalación
                                    adaptadas a las características específicas de cada obra.
                                </p>

                                <p class="desc-p">
                                    La principal diferencia entre estas modalidades radica en el método de
                                    fijación a la estructura, mientras que el principio de funcionamiento,
                                    la capacidad de protección y el desempeño del sistema permanecen
                                    inalterables. Esto permite implementar soluciones seguras y eficientes
                                    en una amplia variedad de escenarios constructivos.
                                </p>

                                <p class="desc-p">
                                    En <strong>Redes Anticaídas</strong> analizamos cuidadosamente las
                                    condiciones de cada proyecto para seleccionar la configuración más
                                    adecuada, garantizando seguridad, funcionalidad y compatibilidad con
                                    el proceso constructivo.
                                </p>

                            </div>

                            <div class="row">

                                <div class="col-md-4 mb-4">
                                    <div class="video-card"
                                        onclick="openVideoModal('https://www.youtube.com/watch?v=n8eOl9l0a4s')">
                                        <img src="{{ url('/web/img/sistema-T/aaaa.jpeg') }}" alt="Video Sistema T">
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <div class="video-card"
                                        onclick="openVideoModal('https://www.youtube.com/embed/VIDEO_2')">
                                        <img src="{{ url('/web/img/videos/video-2.webp') }}" alt="Video Sistema T">
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <div class="video-card"
                                        onclick="openVideoModal('https://www.youtube.com/embed/VIDEO_3')">
                                        <img src="{{ url('/web/img/videos/video-3.webp') }}" alt="Video Sistema T">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h2 class="details-title">COMPONENTES DEL {{ $titulo_servicio }}</h2>
                        <p class="desc-p">Los componentes de las redes anticaídas del {{ $titulo_servicio }} se
                            clasifican de la siguiente manera:</p>

                        <div class="s-box-wrapper pt-20 pb-15">
                            <div class="row">

                                <!-- Elementos secundarios -->
                                <div class="col-md-6 mb-4">
                                    <div class="component-card">
                                        <div class="component-icon-box">
                                            <i class="fas fa-th"></i>
                                        </div>

                                        <h3 class="component-name">Elementos Secundarios de Conexión</h3>

                                        <ul class="component-desc-list">
                                            <li>
                                                <p>
                                                    Además de los componentes principales, el Sistema T incorpora
                                                    diversos elementos auxiliares que permiten su ensamblaje, ajuste y
                                                    aseguramiento estructural.
                                                </p>
                                            </li>

                                            <li>
                                                <p>
                                                    <strong>Tuercas de Presión:</strong> Elementos de fijación
                                                    utilizados
                                                    para asegurar las uniones mecánicas y permitir el ajuste de los
                                                    componentes estructurales durante la instalación.
                                                </p>
                                            </li>
                                        </ul>

                                        <img src="{{ url('/web/img/sistema-T/Accesorios_solo3.webp') }}"
                                            alt="Accesorios Sistema T" class="component-image zoom-image"
                                            onclick="openImageViewer(this.src)">

                                        <button class="btn-ver-mas" onclick="toggleAccesorios(this)">
                                            Ver más <i class="fas fa-chevron-down"></i>
                                        </button>

                                        <div class="component-extra-content">
                                            <ul class="component-desc-list">
                                                <li>
                                                    <p>
                                                        <strong>Pasadores tipo Birlos:</strong> Permiten unir los
                                                        distintos
                                                        elementos del sistema, facilitando tanto el montaje como el
                                                        desmontaje en obra.
                                                    </p>
                                                </li>

                                                <li>
                                                    <p>
                                                        <strong>Bisagras de Articulación:</strong> Componentes que
                                                        permiten
                                                        el plegado y la movilidad controlada del brazo durante las
                                                        maniobras
                                                        de instalación, transporte y almacenamiento.
                                                    </p>
                                                </li>

                                                <li>
                                                    <p>
                                                        <strong>Tornillo de Sujeción:</strong> Elemento mecánico
                                                        encargado de
                                                        generar la presión necesaria para el funcionamiento de la
                                                        mordaza,
                                                        garantizando una fijación firme sobre la estructura de concreto.
                                                    </p>
                                                </li>

                                                <li>
                                                    <p>
                                                        <strong>Herrajes y Accesorios de Montaje:</strong> Conjunto de
                                                        piezas
                                                        complementarias diseñadas para asegurar la correcta conexión
                                                        entre los
                                                        elementos estructurales, garantizando la estabilidad,
                                                        resistencia y
                                                        funcionalidad del Sistema T durante toda su operación.
                                                    </p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>


                                <!-- Base sujecion -->
                                <div class="col-md-6 mb-4">
                                    <div class="component-card">
                                        <div class="component-icon-box">
                                            <i class="fas fa-shield-alt"></i>
                                        </div>
                                        <h3 class="component-name">Base de Sujeción</h3>
                                        <ul class="component-desc-list">
                                            <li>
                                                <p>La base de sujeción es el componente estructural encargado de
                                                    transmitir las cargas generadas por el sistema hacia la estructura
                                                    del edificio. Está conformada por un bastidor metálico reforzado que
                                                    proporciona estabilidad al conjunto y sirve como punto de conexión
                                                    entre el brazo y la mordaza de anclaje.
                                                </p>
                                            </li>
                                            <li>
                                                <p>
                                                    Su geometría triangular permite distribuir los esfuerzos producidos
                                                    por el peso propio del sistema y por las cargas dinámicas derivadas
                                                    de una eventual caída. Este elemento es totalmente modulable
                                                    permitiendo sujetarse a la losa de trabajo sin importar la medida de
                                                    su espesor.

                                                </p>
                                            </li>
                                        </ul>
                                        <img src="{{ url('/web/img/sistema-T/Base_de_sugecion.webp') }}"
                                            alt="Base de Sujeción Sistema T" class="component-image zoom-image"
                                            onclick="openImageViewer(this.src)">
                                    </div>
                                </div>

                                <!-- Largueros -->
                                <div class="col-md-6 mb-4">
                                    <div class="component-card">
                                        <div class="component-icon-box">
                                            <i class="fas fa-border-all"></i>
                                        </div>
                                        <h3 class="component-name">Brazo o Larguero</h3>
                                        <ul class="component-desc-list">
                                            <li>
                                                <p> El brazo, también conocido como larguero, es el elemento estructural
                                                    horizontal que se proyecta hacia el exterior de la edificación. Su
                                                    función
                                                    principal es soportar la red de seguridad y generar el voladizo
                                                    necesario
                                                    para ampliar la zona de protección más allá del borde de la losa.
                                                </p>
                                            </li>
                                            <li>
                                                <p>Gracias a su diseño, este elemento girar sobre un plano perpendicular
                                                    a la
                                                    fachada y permite que la red cubra eficazmente el perímetro de
                                                    trabajo,
                                                    creando una superficie de retención capaz de interceptar caídas de
                                                    personas,
                                                    herramientas o materiales antes de que alcancen niveles inferiores.
                                                </p>
                                            </li>
                                        </ul>
                                        <img src="{{ url('/web/img/sistema-T/brazo_con_bisagra.webp') }}"
                                            alt="Brazo con Bisagra Sistema T" class="component-image zoom-image"
                                            onclick="openImageViewer(this.src)">
                                    </div>


                                </div>

                                <!-- Brazo -->
                                <div class="col-md-6 mb-4">
                                    <div class="component-card">
                                        <div class="component-icon-box">
                                            <i class="fas fa-project-diagram"></i>
                                        </div>
                                        <h3 class="component-name">Mordaza de Anclaje</h3>
                                        <ul class="component-desc-list">
                                            <li>
                                                <p>La mordaza es el dispositivo de fijación que conecta el Sistema T a
                                                    la estructura de concreto de la obra. Mediante un mecanismo de
                                                    presión mecánica, se sujeta firmemente al borde de la losa sin
                                                    necesidad de perforaciones permanentes.
                                                </p>
                                            </li>
                                            <li>
                                                <p>Este elemento conformando con un tornillo a modo de sargento es
                                                    fundamental para garantizar la estabilidad del sistema, ya que actúa
                                                    como punto de transferencia de cargas entre la estructura del
                                                    edificio y el conjunto de protección colectiva.</p>
                                            </li>
                                        </ul>
                                        <img src="{{ url('web/img/sistema-T/mordaza_sujecion_sistema_T.webp') }}"
                                            alt="Mordaza de Anclaje Sistema T" class="component-image zoom-image"
                                            onclick="openImageViewer(this.src)">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4">
                @include('web_redes.includes.aside_sisitemas')
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include('web_redes.includes.videos')
            </div>
        </div>
        <div class="row">
            @include('web_redes.includes.seguridad-en-redes')
        </div>
    </div>

    <div id="videoModal" class="video-modal">
        <div class="video-modal-content">

            <span class="video-close" onclick="closeVideoModal()">
                &times;
            </span>

            <iframe id="videoFrame" src="" allowfullscreen>
            </iframe>

        </div>
    </div>

    <div id="imageViewer" class="image-viewer">
        <span class="image-viewer-close" onclick="closeImageViewer()">
            &times;
        </span>

        <img id="imageViewerImg" src="" alt="">
    </div>
</section>
<!-- services end -->


<script>
    function toggleAccesorios(btn) {
        const content = btn.nextElementSibling;

        content.classList.toggle('show');

        btn.innerHTML = content.classList.contains('show') ?
            'Ver menos <i class="fas fa-chevron-up"></i>' :
            'Ver más <i class="fas fa-chevron-down"></i>';
    }

    function openVideoModal(videoUrl) {

        document.getElementById('videoModal').style.display = 'flex';

        document.getElementById('videoFrame').src =
            videoUrl + '?autoplay=1';
    }

    function closeVideoModal() {

        document.getElementById('videoModal').style.display = 'none';

        document.getElementById('videoFrame').src = '';
    }

    window.addEventListener('click', function(e) {

        const modal = document.getElementById('videoModal');

        if (e.target === modal) {
            closeVideoModal();
        }
    });

    function openImageViewer(imageSrc) {

        document.getElementById('imageViewerImg').src = imageSrc;

        document.getElementById('imageViewer')
            .classList.add('show');
    }

    function closeImageViewer() {

        document.getElementById('imageViewer')
            .classList.remove('show');
    }

    document.getElementById('imageViewer')
        .addEventListener('click', function(e) {

            if (e.target === this) {
                closeImageViewer();
            }
        });
</script>
