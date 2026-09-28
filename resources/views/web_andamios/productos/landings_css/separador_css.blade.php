<style>
    .section-separator {
        width: 100%;
        height: 66px;
        background: linear-gradient(145deg, #0e3384df 45%, #febf01d9 70%);
        position: relative;
        overflow: hidden;
        transform: skewY(-3deg);
        animation: gradientShift 5s ease-in-out infinite;
        background-size: 200% 200%;
    }

    /* Animación del gradiente */
    @keyframes gradientShift {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    /* Ajustes responsivos */
    @media (max-width: 767px) {
        .section-separator {
            height: 40px;
            /* Reduce la altura en pantallas pequeñas */
            transform: skewY(0deg);
            /* Elimina el efecto skew en móviles */
        }
    }
</style>
