<style>
    .hero-section {
        display: flex;
        flex-wrap: wrap;
        padding: 50px 0px 20px 0px;
    }

    .hero-izquierda {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 0 20px;
    }

    .hero-producto-img,
    .hero-titulo,
    .hero-btn {
        width: 100%;
    }

    .hero-producto-img {
        z-index: 2;
        position: relative;
    }

    .hero-btn {
        color: #ffbb01;
        border-radius: 15px;
        font-size: 22px;
        font-weight: 700;
        box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.46);
        animation: btnhero 1.5s ease-out infinite;
        width: min(80%, 400px);
        padding: 10px 0px;
        text-align: center;
    }

    .hero-img-bg {
        position: relative;
        text-align: center;
    }

    .hero-img-bg::after {
        position: absolute;
        content: "";
        width: 13vw;
        height: 13vw;
        background: rgba(206, 178, 17, 0.1);
        top: 50%;
        left: 50%;
        border-radius: 50%;
        transform: translate(-50%, -50%);
        z-index: 1;
        animation: b-shadow-hero 2s ease-in-out infinite;
    }

    .mobile {
        display: flex;
    }

    .desktop {
        display: none
    }

    @-webkit-keyframes btnhero {
        0% {
            box-shadow: 0 0 8px 6px rgba(207, 8, 8, 0), 0 0 0 0 transparent, 0 0 0 0 rgba(207, 8, 8, 0)
        }

        10% {
            box-shadow: 0 0 8px 6px, 0 0 12px 10px transparent, 0 0 12px 14px
        }

        100% {
            box-shadow: 0 0 8px 6px rgba(207, 8, 8, 0), 0 0 0 40px transparent, 0 0 0 40px rgba(207, 8, 8, 0)
        }
    }

    @keyframes b-shadow-hero {

        0%,
        100% {
            box-shadow: 0 0 0 12px rgba(255, 187, 0, 0.736),
                0 0 0 25px rgba(255, 187, 0, 0.666),
                0 0 0 40px rgba(255, 187, 0, 0.395),
                0 0 0 60px rgba(255, 187, 0, 0.45),
                0 0 0 100px rgba(255, 187, 0, 0.362);
        }

        50% {
            box-shadow: 0 0 0 30px rgba(255, 187, 0, 0.7),
                0 0 0 50px rgba(255, 187, 0, 0.5),
                0 0 0 100px rgba(255, 187, 0, 0.3),
                0 0 0 120px rgba(255, 187, 0, 0.22),
                0 0 0 180px rgba(255, 187, 0, 0.115);
        }
    }

    @media (min-width: 768px) {

        .hero-izquierda,
        .hero-derecha {
            max-width: 50%;
        }

        .mobile {
            display: none;
        }

        .desktop {
            display: flex;
        }

        .hero-btn {
            font-size: 30px;
        }
    }
</style>

<section class="hero-section">
    <div class="hero-izquierda" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1500">
        <img class="hero-producto-img mobile" src="{{ url('web/img/andamios/psvgs/andamio01-tradicional-STP1.png') }}">
        <img class="hero-titulo" src="{{ url('web/img/andamios/stp/tradicionales_STP-1.png') }}" alt="">
        {{-- <a class="hero-btn" href="{{ url('tienda/andamio-plegable-galvanizado-multiusos-sbt-6') }}">
            COMPRAR AHORA</a> --}}
        <a  id="cotizar" href="#" class="hero-btn" data-product="Andamios Ligeros Tradicionales STP1">
            COTIZAR AHORA</a>
    </div>
    <div class="hero-derecha desktop">
        <div class="hero-img-bg" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1500">
            <img class="hero-producto-img" src="{{ url('web/img/andamios/psvgs/andamio01-tradicional-STP1.png') }}"
                alt="">
        </div>
    </div>
</section>
