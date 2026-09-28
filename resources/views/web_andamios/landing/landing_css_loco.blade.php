<style>
    /* Genéricos */
    main {
        overflow: hidden;
    }

    .cta-button {
        display: block;
        max-width: 300px;
        border-radius: 5px;
        background-color: #ffbb01;
        padding: 12px 40px;
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        text-align: center;
        transition: transform 0.5s, background-color 0.6s, box-shadow 0.7s;
        border: none
    }

    .cta-button:hover {
        background-color: #ffaa01;
        box-shadow: -1px 10px 20px 0px #dddddd;
        transform: scale(1.01);
    }

    h2 {
        font-size: 28px;
        margin-bottom: 20px;
        font-weight: bold;
        line-height: 1.2;
        text-align: center;
        text-transform: uppercase;
    }

    p,
    li,
    a {
        font-family: Montserrat, sans-serif;
        font-size: 18px;
        line-height: 1.5;
    }

    section {
        background-color: white;
    }

    .content {
        padding: 70px 20px;
        max-width: 1120px;
        margin: 0 auto;
    }

    /* Estilos para el CTA con Cronómetro */
    .cta-cronometro {
        position: fixed;
        top: 20px;
        left: 20px;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        /* background: #fd01b8; */
        /* background: radial-gradient(circle, rgba(253,1,184,1) 0%, rgba(253,1,184,0.5) 100%); */
        background: radial-gradient(circle, rgba(253, 1, 184, 1) 0%, rgba(255, 116, 217, 0.4976584383753502) 100%);
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        border: 2px solid #f7f7f7;
        font-size: 24px;
        color: #fff;
        font-weight: bold;
        text-align: center;
        z-index: 1000;
        overflow: hidden;
        transition: width 300ms, height 300ms, border-radius 300ms;
    }

    .oferta-terminada {
        width: auto;
        height: 80px;
        padding: 10px;
        border-radius: 5px;
    }

    .urgente {
        animation: pulse2 1s infinite;
    }

    /* Estilos --- Sección Hero */
    .hero-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 120px 20px;
    }

    .hero-section h1 {
        font-size: 34px;
        line-height: 1.2;
        margin-bottom: 20px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        text-align: center;
        text-transform: uppercase;
    }

    .hero-subtitle {
        font-size: 22px;
        margin-bottom: 40px;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
        text-align: center
    }

    .hero-video {
        width: min(100%, 700px);
    }

    .hero-video iframe {
        width: 100%;
    }

    @media(min-width: 768px) {
        .hero-section h1 {
            font-size: 48px;
        }
    }

    /* Estilos --- Sección de Producto */
    .producto-section {
        /* background: linear-gradient(90deg, rgba(249,93,208,1) 0%, rgba(249,93,208,0.5) 50%, rgba(249,93,208,1) 100%); */
    }

    .producto-content {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 30px;
        justify-content: center;
    }

    .producto-texto {
        width: min(100%, 600px);
    }

    .producto-texto p {
        margin-bottom: 20px;
    }

    .producto-texto ul {
        list-style-type: disc;
        margin: 20px 0;
        padding-left: 20px;
    }

    .producto-imagen {
        width: min(100%, 600px);
    }

    .producto-imagen img {
        width: 100%;
        height: auto;
        filter: drop-shadow(0px 0px 15px rgba(249, 93, 208, 0.5));
    }

    @media(min-width: 768px) {
        .producto-texto h2 {
            font-size: 40px
        }
    }

    @media(min-width: 969px) {

        .producto-texto,
        .producto-imagen {
            width: min(100%, 450px);
        }
    }

    /* Estilos --- Sección CTA con Cronómetro */
    @keyframes pulse2 {

        0%,
        100%,
        {
        transfrom: scale(1)
    }

    50% {
        transform: scale(1.2)
    }
    }

    .cta-cron-section {
        background: linear-gradient(90deg, rgba(249, 93, 208, 1) 0%, rgba(249, 93, 208, 0.5) 50%, rgba(249, 93, 208, 1) 100%);
        color: #fff;
    }

    .cta-cron-content {
        display: flex;
        justify-content: center;
    }

    .cta-cron-left .mobile {
        display: block;
    }

    .cta-cron-right {
        display: none;
        align-items: center;
        justify-content: center;
        flex-direction: column
    }

    .cta-cron-content h2,
    .cta-cron-content h3,
    .cta-cron-content p {
        text-align: center;
        color: white;
        text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.474);
    }

    .cta-cron-content .counter {
        transition: all 0.5s ease-in-out;
        font-size: 100px;
    }

    .cta-cron-content .precio-original,
    .cta-cron-content .precio-descuento,
    .precio-original-container {
        position: relative;
        width: fit-content;
        margin: 0 auto;
    }

    .cta-cron-content .precio-original {
        font-size: 40px;
    }

    .cta-cron-content .linea {
        width: 100%;
        height: 5px;
        background: rgb(255 0 0);
        position: absolute;
        top: 0;
        left: 0;
        box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.474);
    }

    .cta-cron-content .precio-descuento {
        font-size: 80px;
        margin-top: -18px;
        animation: pulse2 2s infinite;
    }

    .cta-cron-content .precio-descuento::before {
        content: '40% OFF';
        background-color: rgb(255 0 0);
        transform: rotate(356deg);
        position: absolute;
        top: -45px;
        left: -60px;
        width: 90px;
        height: 90px;
        border-radius: 50%;
        font-size: 25px;
        display: flex;
        align-items: center;
        box-shadow: 0px 0px 20px 4px #ff4e6d;
        line-height: 1;
    }

    .cta-cron-section .cta-button {
        margin: 0 auto;
        background-color: white;
        color: #f95dd0;
        cursor: pointer;
        box-shadow: 0px 0px 20px 3px #ff70d5;
        font-size: 18px;
    }

    .cta-cron-section .cta-button:hover {
        background-color: white;
        box-shadow: 0px 0px 20px 3px #ffddf5;
    }

    @media (min-width:768px) {
        .cta-cron-right {
            display: flex;
        }

        .cta-cron-left,
        .cta-cron-right {
            width: 45%;
        }

        .cta-cron-left .mobile {
            display: none
        }
    }

    /* Estilos - Sección Mockups */
    .mockups-producto-section {
        /* background: linear-gradient(135deg, #f7f8f9 0%, #e4e5e6 100%); */
    }

    .mockups-producto-content h2 {
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
    }

    .slider-container {
        width: 100%;
        overflow: hidden;
        position: relative;
    }

    .slider {
        display: flex;
        transition: transform 0.2s ease-in-out;
    }

    .slide {
        flex: 0 0 100%;
    }

    .slide img {
        width: 100%;
        height: auto;
    }

    @media (min-width: 768px) {
        .slide {
            flex: 0 0 50%;
        }
    }

    @media (min-width: 1024px) {
        .slide {
            flex: 0 0 25%;
        }
    }

    .nav-button {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.5);
        color: white;
        padding: 10px;
        text-decoration: none;
    }

    .prev {
        left: 10px;
    }

    .next {
        right: 10px;
    }

    /* --- */


    /* Estilos - Sección de Ofertas Especiales y Descuentos */
    .ofertas-section {
        /* background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%); */
    }

    .ofertas-section h2 {
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    }

    .ofertas-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        justify-content: center;
    }

    .oferta-item {
        background: #fffdfe;
        border: 1px solid #ff81d3;
        border-radius: 8px;
        padding: 20px;
        max-width: 300px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .oferta-item h3 {
        font-size: 22px;
        margin-top: 20px;
        margin-bottom: 15px;
        color: black;
        line-height: 1.2;
        text-align: center
    }

    .oferta-item p {
        text-align: center;
    }

    .icono-oferta {
        font-size: 48px;
        /* color: #ff6f61; */
        color: #fd01b8;
        background: white;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        box-shadow: 0 4px 10px #ffb1ba;
        /* box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); */
    }

    .icono-oferta i,
    .icono-oferta img {
        animation: bounce 1s infinite;
    }

    .icono-oferta img {
        max-width: 60px;
    }

    /* Animación de rebote para el icono */
    @keyframes bounce {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    .cta-cron-section {
        background: linear-gradient(90deg, rgba(249, 93, 208, 1) 0%, rgba(249, 93, 208, 0.5) 50%, rgba(249, 93, 208, 1) 100%);
        color: #fff;
    }

    .cta-cron-content {
        display: flex;
        justify-content: center;
    }

    .cta-cron-left .mobile {
        display: block;
    }

    .cta-cron-right {
        display: none;
        align-items: center;
        justify-content: center;
        flex-direction: column
    }

    .cta-cron-content h2,
    .cta-cron-content h3,
    .cta-cron-content p {
        text-align: center;
        color: white;
        text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.474);
    }

    .cta-cron-content .counter {
        transition: all 0.5s ease-in-out;
        font-size: 100px;
    }

    .cta-cron-content .precio-original,
    .cta-cron-content .precio-descuento,
    .precio-original-container {
        position: relative;
        width: fit-content;
        margin: 0 auto;
    }

    .cta-cron-content .precio-original {
        font-size: 40px;
    }

    .cta-cron-content .linea {
        width: 100%;
        height: 5px;
        background: rgb(255 0 0);
        position: absolute;
        top: 0;
        left: 0;
        box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.474);
    }

    .cta-cron-content .precio-descuento {
        font-size: 80px;
        margin-top: -18px;
        animation: pulse2 2s infinite;
    }

    .cta-cron-content .precio-descuento::before {
        content: '40% OFF';
        background-color: rgb(255 0 0);
        transform: rotate(356deg);
        position: absolute;
        top: -45px;
        left: -60px;
        width: 90px;
        height: 90px;
        border-radius: 50%;
        font-size: 25px;
        display: flex;
        align-items: center;
        box-shadow: 0px 0px 20px 4px #ff4e6d;
        line-height: 1;
    }

    .cta-cron-section .cta-button {
        margin: 0 auto;
        background-color: white;
        color: #f95dd0;
        cursor: pointer;
        box-shadow: 0px 0px 20px 3px #ff70d5;
        font-size: 18px;
    }

    .cta-cron-section .cta-button:hover {
        background-color: white;
        box-shadow: 0px 0px 20px 3px #ffddf5;
    }

    @media (min-width:768px) {
        .cta-cron-right {
            display: flex;
        }

        .cta-cron-left,
        .cta-cron-right {
            width: 45%;
        }

        .cta-cron-left .mobile {
            display: none
        }
    }

    /* Estilos para la Sección de Llamada a la Acción (CTA) */
    .cta-section {
        background: linear-gradient(90deg, rgba(249, 93, 208, 1) 0%, rgba(249, 93, 208, 0.4976584383753502) 50%, rgba(249, 93, 208, 1) 100%);
        padding: 50px 0;
    }

    .cta-background {
        background: rgba(72, 71, 66, 0.229);
        border-top: 3px solid #f9f9f9;
        border-bottom: 3px solid #f9f9f9;
    }

    .cta-content {
        display: flex;
        flex-direction: column;
        max-width: 1200px;
        gap: 30px;
        justify-content: center
    }

    .cta-text {
        text-align: center;
    }

    .cta-text h2 {
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        text-transform: uppercase;
        color: white;
        margin: 0;
    }

    .cta-text p {
        color: white;
    }

    .cta-buttons {
        display: flex;
        justify-content: center;
    }

    .cta-buttons .cta-button {
        margin: auto 0;
        background-color: #f95dd0;
        color: white;
        border: 1px solid white;
        box-shadow: 5px 5px 10px 0px #00000040;
        /* box-shadow: 5px 5px 0px 0px #f9f9f9; */
    }

    .cta-buttons .cta-button:hover {
        background-color: white;
        color: #f95dd0;
    }

    @media(min-width:768px) {
        .cta-content {
            flex-direction: row;
            gap: 50px
        }

        .cta-text {
            max-width: 65%;
        }

        .cta-buttons {
            max-width: 35%;
        }
    }

    /* Estilos - Sección de Testimonios */
    .grid-testimonios {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
    }

    .testimonio {
        background: #fffdfe;
        border: 1px solid #ff81d3;
        border-radius: 8px;
        padding: 20px;
        max-width: 300px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .testimonio img {
        border-radius: 50%;
        width: 100px;
        height: 100px;
        object-fit: cover;
        margin-bottom: 15px;
    }

    .testimonio .nombre {
        font-size: 19px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .testimonio .comentario {
        color: #666;
    }

    /* Estilos - Sección de Medidas */
    .medidas-content {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .medidas-img-container {
        max-width: 600px;
        overflow: hidden;
        display: flex;
    }

    .medidas-btn-container {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .medidas-btn {
        color: white;
        background-color: #f95dd0;
        text-transform: uppercase;
        font-weight: 500;
        padding: 10px;
        border-radius: 5px;
        text-decoration: none;
    }

    .medidas-btn.active {
        background-color: #d140a8;
        box-shadow: 0 0 10px 1px #d140a8
    }

    .medidas-img-container img {
        width: 100%;
    }

    /* Estilos - Sección de Preguntas Frecuentes */
    .faq-item {
        margin-bottom: 15px;
        border-bottom: 1px solid #ddd;
    }

    .faq-question {
        width: 100%;
        padding: 15px;
        text-align: left;
        background: #f7f7f7;
        border: none;
        cursor: pointer;
        font-size: 19px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: background 0.3s ease;
    }

    .faq-question:hover {
        background: #fdedf7;
    }

    .faq-question.active {
        background: #f4ddeb;
    }

    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
        background: white;
        padding: 0 15px;
    }

    .faq-answer p {
        margin: 15px 0;
        color: #666;
    }

    /* <!-- Estilos - Sección Garantías y Políticas de Devolución --> */
    .garantias-content {
        display: flex;
        flex-direction: column;
        gap: 50px;
    }

    .garantia-item {
        padding: 20px;
        background: #fffdfe;
        border-radius: 8px;
        box-shadow: rgb(240 46 170 / 30%) 5px 5px 0px 0px, rgb(240 46 170 / 20%) 10px 10px 0px 0px, rgb(240 46 170 / 10%) 15px 15px 0px 0px, rgb(240 46 170 / 5%) 20px 20px 0px 0px, rgba(240, 46, 170, 0.01) 25px 25px 0px 0px;
        transition: transform 0.3s ease;
        border: 1px solid #ff81d3;
    }

    .garantia-item:hover {
        transform: scale(1.05);
    }

    /* Estilos para la Sección Comparaciones */
    .comparaciones-tabla {
        border-collapse: collapse;
        margin: 20px auto 40px auto;
        overflow-x: scroll;
        display: flex;
        flex-direction: column;
    }

    .tabla-header {
        background: #f95dd0;
        color: #fff;
        font-weight: bold;
        display: flex;
    }

    .tabla-row {
        display: flex;
    }

    .tabla-titulo,
    .tabla-item {
        padding: 15px;
        text-align: center;
        border: 1px solid #ddd;
        width: 25%;
        min-width: 150px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .tabla-header {
        background: #f95dd0;
        color: #fff;
        font-weight: bold;
    }

    .tabla-row:nth-child(odd) {
        background: #f4ddeb;
    }

    .comparaciones-razones ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .comparaciones-razones ul li {
        margin: 10px 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .comparaciones-razones ul li i {
        color: #f95dd0;
        font-size: 20px;
    }

    /* Estilos para la Sección de Garantía */
    .garantia-content {
        /* padding: 0; */
        padding-bottom: 100px
    }

    .garantia-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        border-radius: 10px;
        padding: 45px 20px;
        box-shadow: 5px 5px 8px 4px rgb(16 0 72 / 10%);
        max-width: 800px;
        width: 100%;
        margin: 0 auto;
        transition: transform 0.3s ease;
        position: relative;
        text-align: center
    }

    .garantia-box:hover {
        transform: scale(1.02);
    }

    .garantia-logo {
        max-width: 200px;
        left: -30px;
        top: -50px;
    }

    .garantia-logo img {
        width: 100%;
    }

    .garantia-text h3 {
        font-size: 22px;
    }

    @media(min-width:768px) {
        .garantia-box {
            flex-direction: row;
            padding: 45px 20px 10px 170px;
            text-align: start;
        }

        .garantia-logo {
            position: absolute;
        }
    }
</style>
