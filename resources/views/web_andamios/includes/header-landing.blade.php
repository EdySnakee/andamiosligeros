@include('web_redes.includes.menu-top')
<div class="c-header" id="menu-principal">
    <div class="o-container-fluid">
        <div class="row">
            <div class="twelve columns">
                <div class="row">
                    <div class="c-bg-color u-bg-color-white"></div>
                    <div class="auto column non-responsive u-align-column-center">
                        <div class="c-header-brand"><a class="c-header-brand-link" href="{{ url('/inicio') }}"></a><img class="c-header-brand-img" src="{{url('web/imagenes/originales/redes-anticaidas-logotipo-largo.svg')}}" /></div>
                    </div>
                    <div class="auto column non-responsive u-align-column-center">
                        <div class="c-navigation-primary u-display-flex u-justify-content-end">
                            <ul id="menu-menu-principal" class="c-navigation-primary-items">
                                <li id="menu-item-823" class="menu-item menu-item-type-post_type menu-item-object-page level-1 menu-item-823">
                                    <a href="{{ url('/inicio') }}">INICIO <div class="cinetic-nav-line"></div>
                                    </a>
                                </li>
                                <li id="menu-item-112" class="menu-item menu-item-type-post_type menu-item-object-page level-1 menu-item-112 text-center">
                                    <a href="#proyectos">PROYECTOS <div class="cinetic-nav-line"></div>
                                    </a>
                                </li>
                                <li id="menu-item-110" class="menu-item menu-item-type-post_type menu-item-object-page level-1 menu-item-110 text-center">
                                    <a href="#galerias">GALERIAS<div class="cinetic-nav-line"></div>
                                    </a>
                                </li>
                                <li id="menu-item-109" class="menu-item menu-item-type-post_type menu-item-object-page level-1 menu-item-109 text-center">
                                    <a href="#nosotros">NOSOTROS <div class="cinetic-nav-line"></div>
                                    </a>
                                </li>
                                <li id="menu-item-109" class="menu-item menu-item-type-post_type menu-item-object-page level-1 menu-item-109">
                                    <a href="#servicios">SERVICIOS<div class="cinetic-nav-line"></div>
                                    </a>
                                </li>
                                <li id="menu-item-109" class="menu-item menu-item-type-post_type menu-item-object-page level-1 menu-item-109">
                                    <a href="#contactanos">CONTACTANOS<div class="cinetic-nav-line"></div>
                                    </a>
                                </li>
                            </ul>
                            <div class="c-navigation-off-canvas-toggler-wrapper u-display-flex u-align-self-center">
                                <div class="c-navigation-off-canvas-toggler u-layer-2"><span class="c-navigation-off-canvas-toggler-icon"></span><span class="c-navigation-off-canvas-toggler-icon"></span><span class="c-navigation-off-canvas-toggler-icon"></span></div>
                                <div class="c-toggler-hover u-layer-1"></div>
                                <div class="c-toggler-open u-layer-1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="c-header-mobile">
    <div class="cinetic-divider-large"></div>
    <div class="o-container-fluid">
        <div class="row">
            <div class="four columns offset-by-one">
                <div class="c-navigation-primary-mobile">
                    <ul id="menu-menu-off-canvas-colonne-1" class="c-navigation-primary-mobile-items">
                        <li class="menu-item menu-item-type-post_type menu-item-object-page level-1">
                            <a href="{{ url('/inicio') }}">INICIO <div class="cinetic-nav-line"></div></a>
                        </li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page level-1">
                            <a href="#redes-anticaidas">REDES ANTICAIDAS <div class="cinetic-nav-line"></div></a>
                        </li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page level-1">
                            <a href="#mallas-antiescombros">MALLAS ANTIESCOMBRO<div class="cinetic-nav-line"></div></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="four columns offset-by-one">
                <div class="c-navigation-primary-mobile">
                    <ul id="menu-menu-off-canvas-colonne-2" class="c-navigation-primary-mobile-items">
                        <li class="menu-item menu-item-type-post_type menu-item-object-page level-1">
                            <a href="#proyectos">PROYECTOS Y CLIENTES <div class="cinetic-nav-line"></div></a>
                        </li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page level-1">
                            <a href="#contacto">CONTACTANOS <div class="cinetic-nav-line"></div></a>
                        </li>
                    </ul>
                    <div class="c-lang-switcher-mobile"><a href="https://wa.me/5219996461314" target="_blank"><svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="whatsapp" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                <path fill="currentColor" d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z" class="svgwhatsapp"></path>
                            </svg></a></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="eight columns offset-by-two">
                <div class="cinetic-divider-large"></div>
                <div class="cinetic-divider-line-full u-bg-color-white"></div>
                <div class="cinetic-divider-large"></div>
            </div>
        </div>
        <div class="row contact-menu">
            <div class="eight columns offset-by-two">
                <div class="row">
                    <div class="auto columns u-color-white">
                        <div class="o-text-wrapper-mobile">
                            <h2 class="u-h6">Redesanticaidas.mx Merida</h2>
                            <p> Avenida Canek, Calle 59a x 60 #263, Colonia Las Vigas, Locales 3 y 4, Planta baja, Mérida, Yucatan, México, CP 97227 </p>
                        </div>
                    </div>
                    <div class="auto columns u-color-white">
                        <div class="o-text-wrapper-mobile">
                            <h2 class="u-h6">Redesanticaidas.mx Monterrey</h2>
                            <p> Torres moradas, Blvd. Diaz Ordaz No. 140 Piso 20 Col. Sant Maria, Monterrey, Nuevo Leon, México, CP 64650 </p>
                        </div>
                    </div>
                    <div class="auto columns u-color-white">
                        <div class="o-text-wrapper-mobile">
                            <h2 class="u-h6">Redesanticaidas.mx Puebla</h2>
                            <p> Triangulo Las Animas, Call 39 poniente No. 3515 piso 5, Puebla, Puebla, México, CP 72400 </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="cinetic-divider-large"></div>
</div>
<div class="c-header-mobile-close-trigger"></div>
<div class="c-social">
    <div class="c-social-wrapper">
        <div class="c-social-icon">
            <div class="social-hover"></div><svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="youtube" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                <path fill="currentColor" d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z" class="svgicon"></path>
            </svg><svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="youtube" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="c-social-menu-open">
                <path fill="currentColor" d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z" class="svgicon-alt"></path>
            </svg><a href="https://www.youtube.com/user/scoregol" target="_blank"></a>
        </div>
    </div>
    <div class="c-social-wrapper">
        <div class="c-social-icon">
            <div class="social-hover"></div><svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="facebook-f" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                <path fill="currentColor" d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z" class="svgicon"></path>
            </svg><svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="facebook-f" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="c-social-menu-open">
                <path fill="currentColor" d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z" class="svgicon"></path>
            </svg><a href="https://www.facebook.com/scoregol" target="_blank"></a>
        </div>
    </div>
    <div class="c-social-wrapper">
        <div class="c-social-icon">
            <div class="social-hover"></div><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="">
                <path fill="currentColor" d="M464 64H48C21.49 64 0 85.49 0 112v288c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V112c0-26.51-21.49-48-48-48zm0 48v40.805c-22.422 18.259-58.168 46.651-134.587 106.49-16.841 13.247-50.201 45.072-73.413 44.701-23.208.375-56.579-31.459-73.413-44.701C106.18 199.465 70.425 171.067 48 152.805V112h416zM48 400V214.398c22.914 18.251 55.409 43.862 104.938 82.646 21.857 17.205 60.134 55.186 103.062 54.955 42.717.231 80.509-37.199 103.053-54.947 49.528-38.783 82.032-64.401 104.947-82.653V400H48z" class="svgicon"></path>
            </svg><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="c-social-menu-open">
                <path fill="currentColor" d="M464 64H48C21.49 64 0 85.49 0 112v288c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V112c0-26.51-21.49-48-48-48zm0 48v40.805c-22.422 18.259-58.168 46.651-134.587 106.49-16.841 13.247-50.201 45.072-73.413 44.701-23.208.375-56.579-31.459-73.413-44.701C106.18 199.465 70.425 171.067 48 152.805V112h416zM48 400V214.398c22.914 18.251 55.409 43.862 104.938 82.646 21.857 17.205 60.134 55.186 103.062 54.955 42.717.231 80.509-37.199 103.053-54.947 49.528-38.783 82.032-64.401 104.947-82.653V400H48z" class="svgicon-alt"></path>
            </svg><a href="mailto:ventas@redesanticaidas.mx"></a>
        </div>
    </div>
</div>
<div class="c-lang-switcher"><a href="https://wa.me/5219996461314" target="_blank"><svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="whatsapp" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
            <path fill="currentColor" d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z" class="svgwhatsapp"></path>
        </svg></a>
    <div class="lang-switcher-hover"></div>
</div>