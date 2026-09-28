<style>
    body,
    main {
        background: white;
    }


    .panel-paquetexpress {
        width: 100%;
    }

    .rastreo-paquetexpress {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        margin: 50px 0;
        gap: 10px;
        padding: 0px 15px;
    }

    .rastreo-input {
        width: 100%;
        max-width: 500px;
        padding: 15px 10px;
        border: 1px solid #cecccc;
        border-radius: 10px;
        font-size: 18px;
        color: #fc4044 !important;
        font-weight: 600;
        transition: 300ms;
    }

    .rastreo-input::placeholder {
        font-weight: 500;
    }

    .rastreo-input:focus {
        border: 1px solid #fc4044;
        outline: #fc4044;
        color: #333;
    }

    .rastreo-btn {
        color: white;
        font-weight: 600;
        font-size: 22px;
        background-color: #fc4044;
        border: none;
        border-radius: 10px;
        padding: 15px;
        width: 100%;
        max-width: 500px;
        text-align: center;
        box-shadow: 0px 5px 20px -5px #fc4044;
        transition: 300ms;
        outline: transparent;
        cursor: pointer;
    }

    .rastreo-btn:hover {
        box-shadow: 0px 10px 20px -5px #fc4044;
        outline: transparent;
    }

    .rastreo-texto {
        margin-top: 20px;
    }

    .reporte-guias {
        margin: 80px 0;
        overflow: scroll;
    }

    .reporte-guias-tabla {
        max-height: 500px;
    }

    .reporte-guias-header {
        width: 100%;
    }

    .reporte-tabla-header,
    .reporte-tabla-img {
        width: 100%;
        min-width: 1400px;
    }

    .reporte-guias-tabla {
        position: relative;
        z-index: 2;
        width: 100%;
        overflow: scroll;
        border-bottom: 1px solid rgb(197, 194, 194);
    }

    .reporte-tabla-header {
        position: sticky;
        top: 0;
        left: 0;
    }

    .cobertura-paqexpress {
        margin-bottom: 80px;
    }

    .cobertura-img img {
        width: 100%
    }

    .mobile {
        display: block;
    }

    .desktop {
        display: none;
    }

    @media(min-width:768px) {
        .reporte-guias {
            margin: 0 0 80px 0;
        }

        .mobile {
            display: none;
        }

        .desktop {
            display: block;
        }
    }

    @media(min-width: 1024px) {
        .panel {
        margin-top: 100px;
    }
    }
</style>
