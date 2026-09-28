<style>
    /* ESTILOS GENERALES HEADER */
    .andamios-header {
        position: sticky;
        top: 0;
        width: 100%;
        z-index: 99;
        background: none;
        padding: 10px 0;
        transition: background-color 0.3s ease;
        display: flex;
    }

    .andamios-header.scrolled {
        background-color: rgba(255, 255, 255, 1);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .andamios-nav {
        width: 100%;
        display: flex;
        gap: 5px;
        justify-content: space-around;
        align-items: center;
    }

    .nav-logo {
        width: 30%;
    }

    .nav-promociones {
        width: 40%;
    }

    .nav-opciones {
        width: 20%;
    }

    .nav-overlay-mobile {
        position: absolute;
        top: 0;
        right: 0;
        height: 100vh;
        width: 100%;
        z-index: 999;
        background: #00000059;
        backdrop-filter: blur(2px);
        display: none;
        opacity: 0;
        transition: 300ms;
    }

    .nav-overlay-mobile-active {
        display: block;
        opacity: 1;
    }

    .mobile {
        display: block;
    }

    /* TERMINAN ESTILOS GENERALES */

    /* ESTILOS ESPECÍFICOS LOGO */
    .nav-logo a img {
        width: 100%;
        max-width: 200px;
        height: auto;
    }

    /* ESTILOS ESPECÍFICOS PROMOCIONES */

    .cta {
        display: flex;
        padding: 7px 23px;
        text-decoration: none;
        font-family: "Poppins", sans-serif;
        font-size: 18px;
        font-weight: 600;
        color: white;
        background: #ffbb01;
        transition: 500ms;
        box-shadow:
            3px 3px 0px #8C8C8C,
            0px -3px 0px #1f66ff,
            0px 3px 0px #8C8C8C,
            3px -3px 0px #8C8C8C,
            -3px 3px 0px #1f66ff,
            -3px -3px 0px #1f66ff;
        transform: skewX(-15deg);
        border: none;
        cursor: pointer;
    }

    .cta:focus {
        outline: none;
    }

    .cta:hover {
        transition: 0.5s;
        box-shadow:
            10px 10px 0 #535353,
            -10px -10px 0 #0648d6;
    }

    .cta .second {
        transition: 0.5s;
        margin-right: 0px;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 20px;
        margin-left: 10px;
        position: relative;
    }

    .cta:hover .second {
        transition: 0.5s;
        margin-right: 15px;
    }

    .span {
        transform: skewX(15deg);
        color: white;
        font-weight: 500;
        letter-spacing: 1px;
    }

    .one {
        transition: 0.4s;
        transform: translateX(-60%);
    }

    .two {
        transition: 0.5s;
        transform: translateX(-30%);
    }

    .cta:hover .three {
        animation: color_anim 2s infinite 0.2s;
    }

    .cta:hover .one {
        transform: translateX(0%);
        animation: color_anim 2s infinite 0.6s;
    }

    .cta:hover .two {
        transform: translateX(0%);
        animation: color_anim 2s infinite 0.4s;
    }

    @keyframes color_anim {
        0% {
            fill: #fff;
        }

        50% {
            fill: #0648d6;
        }

        100% {
            fill: #fff;
        }
    }

    /* ESTILOS BOTÓN HAMBURGUESA */
    .nav-hamburger {
        display: block;
        font-size: 30px;
        cursor: pointer;
        color: #000;
        background: none;
        border: none;
        padding: 10px;
        z-index: 1001;
    }

    /* ESTILOS COMPARTIDOS MENÚ Y SUBMENÚ (SÚPERMENÚ) */
    .nav-opciones,
    .nav-opciones-supermenu {
        display: flex;
        align-items: center;
        text-align: center;
    }

    .nav-opciones-contenedor,
    .supermenu-categorias-contenedor {
        display: flex;
    }

    .nav-opcion,
    .supermenu-categoria {
        transition: 300ms;
        width: 100%;
        border-bottom: 1px solid #e0e0e0;
    }

    .nav-opcion,
    .supermenu-categoria a {
        text-transform: uppercase;
        color: black;
        font-weight: 600;
        font-size: 18px;
        cursor: pointer;
    }

    .mobile-menu-logo {
        width: min(60%, 300px);
        margin-top: 100px;
    }

    /* ESTILOS ESPECÍFICOS OPCIONES */
    .nav-opciones .cta {
        margin: 30px 0;
    }

    .nav-opcion {
        padding: 20px 0;
    }

    .nav-opcion:hover {
        color: #0648d6;
        transform: scale(1.05);
    }

    .nav-minicart-btn {
        border: none;
        background: white;
        padding: 10px 20px;
        box-shadow: 0px 8px 10px -5px #c8c8c8;
        border-radius: 10px;
        transition: 300ms;
        margin-top: 50px;
        margin-bottom: 60px;
        position: relative;
    }

    .nav-minicart-btn:hover {
        transform: scale(1.1);
    }

    .nav-minicart-btn .cont-carrito {
        background: #ffbb01;
        padding: 12px;
        top: -5px;
        right: -5px;

        .font-cart {
            font-size: 15px;
        }
    }

    /*---- ESTILOS ESPECÍFICOS SUPERMENU*/
    .supermenu-regresar {
        background: #ffbb01;
        color: white;
        position: absolute;
        top: 20px;
        left: 20px;
        padding: 5px 10px;
        border: none;
        font-size: 16px;
        font-weight: 600;
        border-radius: 5px;

        i {
            margin-right: 5px;
        }
    }

    .supermenu-titulo {
        font-size: 24px;
        font-weight: 600;
        margin: 30px 0;
    }

    .supermenu-categorias-contenedor {
        overflow: scroll;
        border-top: 1px solid #e0e0e0;
        box-shadow: inset -1px 20px 20px -20px #dcdcdc;
    }

    .supermenu-categoria {
        display: flex;
        flex-direction: column;
        padding: 15px 0;
    }

    .supermenu-categoria a {
        color: black;
        padding: 20px 0;
        font-weight: 400;

        i {
            color: #0648d6;
        }
    }

    .supermenu-categoria h3 {
        font-size: 20px;
        font-weight: 600;
    }

    .supermenu-categoria-chingones {
        background-color: black;
        border-radius: 10px;
        box-shadow: 0 0 30px -8px #cb6ce7;
    }

    .supermenu-categoria-chingones h3 {
        display: flex;
        flex-direction: column;
        gap: 5px;
        padding: 10px;
        margin-left: -10px;
        border-radius: 10px;
        align-items: center;
        color: white;
    }

    .supermenu-categoria-chingones a {
        color: white;
    }

    .categoria-ac {
        padding: 0;
    }

    .categoria-ac img {
        max-width: 230px;
    }

    /* ESTILOS HASTA MÓVIL */
    @media(max-width:499px) {

        /* ESTILOS GENERALES */
        .andamios-nav {
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 0 15px;
        }

        /* ESTILOS ESPECÍFICOS LOGO */
        .nav-logo {
            width: 40%;
        }

        .nav-logo.scrolled {
            display: none;
        }

        /* ESTILOS ESPECÍFICOS PROMOCIONES */
        .nav-promociones {
            width: 100%;
            order: 3;
            display: flex;
            justify-content: center;
            transition: 300ms;
        }

        .nav-promociones.scrolled {
            order: 1;
            width: 60%;
            margin: 0;
            justify-content: start;
        }

        .cta {
            padding: 8px 23px;
        }

        /* ESTILOS BOTÓN HAMBURGUESA */
        .nav-hamburger {
            order: 2;
        }
    }

    /* ESTILOS HASTA MÓVIL GRANDE */
    @media(max-width:768px) {}

    /* ESTILOS HASTA TABLET */
    @media(max-width: 1024px) {

        /* ESTILOS ESPECÍFICOS PROMOCIONES */
        .cta {
            max-width: 220px;
        }

        /* ESTILOS COMPARTIDOS MENÚ Y SUBMENÚ (SÚPERMENÚ) */
        .nav-opciones,
        .nav-opciones-supermenu {
            flex-direction: column;
            position: fixed;
            top: 0;
            right: -100%;
            transition: 300ms ease;
            height: 100vh;
            width: min(100%, 500px);
            backdrop-filter: blur(3px);
            background-color: #ffffffe8;
            z-index: 1000;
        }

        .nav-opciones-active,
        .nav-opciones-supermenu-active {
            right: 0;
        }

        .nav-opciones-contenedor,
        .supermenu-categorias-contenedor {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        /* ESTILOS ESPECÍFICOS OPCIONES */
        .nav-opciones {
            overflow: scroll;
        }

        /* ESTILOS ESPECÍFICOS SUBMENÚ (SUPERMENÚ) */
        .nav-opciones-supermenu {
            z-index: 1002;
        }
    }

    /* ESTILOS ESCRITORIO */
    @media(min-width:1025px) {

        /* ESTILOS GENERALES */
        .andamios-header {
            position: fixed;
            padding: 0px 25px;
            min-height: 100px;
            max-height: 100px;
        }

        .andamios-nav {
            display: flex;
            max-height: 120px;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }

        .mobile {
            display: none;
        }

        .nav-logo {
            width: 20%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-promociones {
            width: 15%;
            display: flex;
            justify-content: center;
        }

        /* ESTILOS BOTÓN HAMBURGUESA */
        .nav-hamburger {
            display: none;
        }

        .mobile-menu-logo {
            display: none;
        }

        /* ESTILOS ESPECÍFICOS OPCIONES */
        .nav-opciones {
            width: 55%;
            display: flex;
            flex-direction: row;
            position: static;
            height: 100%;
        }

        .nav-opciones-contenedor {
            height: 100%;
        }
        
        .nav-opcion {
            padding: 20px 10px;
            border: none;
            display: flex;
            align-items: center;
        }

        .nav-minicart-btn {
            cursor: pointer;
            padding: 0px 20px;
            box-shadow: none;
            border-radius: 0;
            margin: 0;
            background: none;
        }

        .nav-minicart-btn .cont-carrito {
            padding: 10px;
            top: -10px;
            right: 5px;

            .font-cart {
                font-size: 14px;
            }
        }

        /* ESTILOS ESPECÍFICOS SUBMENÚ (SÚPERMENÚ) */
        .nav-opciones-supermenu {
            position: absolute;
            right: -120%;
            top: 90px;
            background-color: white;
            padding: 20px;
            transition: 200ms ease-in;
            width: 100%;
            display: flex;
            flex-direction: column;
            border: 2px solid #0648d6;
            box-shadow: 10px 10px 0px 0px #0648d6,
                20px 20px 20px 5px #0648d64d;
        }

        .nav-opciones-supermenu:hover {
            right: 0;
        }

        .nav-opciones-supermenu-active {
            right: 0;
        }

        .supermenu-titulo {
            display: none;
        }

        .supermenu-categorias-contenedor {
            width: 100%;
            padding: 10px;
            border: none;
            box-shadow: none;
            justify-content: space-around;
        }

        .supermenu-categoria {
            display: flex;
            flex-direction: column;
            padding: 0 20px 15px 20px;
            border-bottom: 0;
            width: fit-content;
            max-width: 300px;
        }

        .supermenu-categoria h3 {
            text-align: start;
        }

        .supermenu-categoria a {
            text-align: start;
            text-transform: none;
            padding: 10px 0;
            font-size: 14px;
            transition: 300ms;
        }

        .supermenu-categoria a:hover,
        .supermenu-categoria a h3:hover {
            color: #0648d6;
            transform: translateX(17px) scale(1.1);
            font-weight: 600;
        }

        .supermenu-categoria-chingones a:hover {
            color: #cb6ce7;
        }

        .supermenu-categoria-chingones .categoria-ac:hover {
            transform: scale(1.1);
        }

        .categoria-ac img {
            max-width: 140px;
        }
    }
</style>
