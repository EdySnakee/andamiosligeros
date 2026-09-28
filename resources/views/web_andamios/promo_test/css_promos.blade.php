<style>
.text-vencido h2 {
    color: black;
}
ul.list-botonera li {
    display: inline-block;
}
.text-vencido {
    position: absolute;
    z-index: 1;
    text-align: center;
}
.cont-btn {
    position: relative;
}
    .eti-vencida {
    position: absolute;
    top: 6vw;
    right: 0;
    z-index: 1;
    background: #c10101;
    padding: 5px 10px;
    border-radius: 10px;
}
.eti-vencida h2 {
    color: white;
}
.float-left {
    float: left;
}
    .promo-inactiva{
        opacity: 0.5;
        filter: blur(4px);
    }
    .equipos {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .equipos li {
        display: inline-block;
        padding: 0 1vw;
    }
    .equipos p {
        font-size: 1rem;
    }
    header#navbar {
        display: none;
    }
    .form-promo {
        border: 0;
        box-shadow: 0px 0px 3px #333;
        padding: 1vw;
        width: 90px;
        border-radius: 5px;
    }
    .img-promo {
        width: 100%;
    }
    .promo-comic{
        background: url({{url('web/prom/bg-comic.jpg')}}) white;
        background-position: center;
        padding: 8vw 0 !important;
        background-size: 170%;
        background-repeat: no-repeat;
    }
    .promo{
        background: url({{url('web/prom/bg-promo-buen-fin.jpg')}}) white;
        background-position: center;
        padding: 8vw 0 !important;
        background-size: 170%;
        background-repeat: no-repeat;
    }
    .promo2{
        background: url({{url('web/prom/bg-promo-paquete.jpg')}}) white;
        background-position: center;
        padding: 8vw 0 !important;
        background-repeat: no-repeat;
    }
    :root {
        --animate-duration: 4s;
        --animate-delay: 4s;
        --animate-repeat: 1
    }

    .animate__animated {
        -webkit-animation-duration: 4s;
        animation-duration: 4s;
        -webkit-animation-duration: var(--animate-duration);
        animation-duration: var(--animate-duration);
        -webkit-animation-fill-mode: both;
        animation-fill-mode: both
    }
    @-webkit-keyframes heartBeat {
        0% {
            -webkit-transform: scale(1);
            transform: scale(1)
        }

        14% {
            -webkit-transform: scale(1.3);
            transform: scale(1.3)
        }

        28% {
            -webkit-transform: scale(1);
            transform: scale(1)
        }

        42% {
            -webkit-transform: scale(1.3);
            transform: scale(1.3)
        }

        70% {
            -webkit-transform: scale(1);
            transform: scale(1)
        }
    }

    @keyframes heartBeat {
        0% {
            -webkit-transform: scale(1);
            transform: scale(1)
        }

        14% {
            -webkit-transform: scale(1.3);
            transform: scale(1.3)
        }

        28% {
            -webkit-transform: scale(1);
            transform: scale(1)
        }

        42% {
            -webkit-transform: scale(1.3);
            transform: scale(1.3)
        }

        70% {
            -webkit-transform: scale(1);
            transform: scale(1)
        }
    }

    .animate__heartBeat {
        -webkit-animation-duration: 1.3s;
        animation-duration: 1.3s;
        -webkit-animation-duration: calc(var(--animate-duration)*1.3);
        animation-duration: calc(var(--animate-duration)*1.3);
        -webkit-animation-name: heartBeat;
        animation-name: heartBeat;
        -webkit-animation-timing-function: ease-in-out;
        animation-timing-function: ease-in-out
    }
    .animate__animated.animate__infinite {
        -webkit-animation-iteration-count: infinite;
        animation-iteration-count: infinite
    }
    @media (max-width: 767px){
        .txt-top p {
            font-size: 0.6em;
        }
        .tit-promo {
            position: relative !important;
            top: 9.5rem !important;
            right: initial !important;
            transform: initial !important;
            width: 80vw !important;
            margin: 0 auto;
        }
        .botonera-mp {
            position: fixed !important;
            right: 0 !important;
            top: initial !important;
            bottom: 5%;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .cont-botones {
            -moz-transform: initial !important;
            -webkit-transform: initial !important;
            -o-transform: initial !important;
            -ms-transform: initial !important;
            transform: initial !important;
        }
        .cont-secciones-cotizaciones{
            overflow: hidden;
        }
        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .cont-plantilla img {
            width: 100%;
        }
        .flex-content {
            display: inline-grid !important;
        }
        .bg-white {
            width: 200px;
            margin: 0 auto !important;
        }
        .cont-cotizacion {
            width: 90vw !important;
        }
        .nav-top .andes-badge__content {
            font-size: 0.6em !important;
        }
        .nav-top{
            font-size: 1rem;
            
        }
        .txt-top {
            margin-bottom: 0.4rem;
        }
        .logo-mp {
            margin-top: 0.4rem;
        }
        .txt-pago {
        padding: 0em !important;
        }
        .badgespan-seguro {
            padding: 0.2em 0.2em 0.2em !important;
        }
        .status-coti {
            margin-top: 7em !important;
        }
        .cont-pago {
            width: 100vw !important;
            right: -100vw !important;
        }
        .muestra-p {
            right: 0vw !important;
        }
        .detallepago {
            background: #f5f5f5 !important;
            width: 100% !important;
            align-items: start !important;
            
            height: auto !important;
        }
        .img-pasarela{
            width: 100% !important;
        }
        .cont-f-pasarela {
            display: grid !important;
        }
        .col-md {
            width: 100vw !important;
        }
        .tabla-resumen {
            height: 55vw !important;
            margin-bottom: 1em !important;
            margin-top: 1em !important;
        }
        .info-resumen br {
            display: none;
        }
    }
    .row-flex {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .cont-cotizacion {
        width: 70vw;
        padding: 2vw;
    }
    .cont-pago {
        width: 100vw;
        position: absolute;
        z-index: 9999999;
        top: 0;
        right: -100vw;
        -webkit-transition: all 0.5s ease;
        -moz-transition: all 0.5s ease;
        -ms-transition: all 0.5s ease;
        -o-transition: all 0.5s ease;
        transition: all 0.5s ease;
    }
    .img-pasarela{
        width: 100%;
    }
    .detallepago {
        background: #f5f5f5;
        
        width: 100vw;
        height: 100%;
        display: flex;
    }
    .cont-img-res {
        width: 50px;
        height: 50px;
        border: 1px #9f9d9d solid;
        padding: 5px;
        border-radius: 5px;
    }
    .cont-img-res img{
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .separado {
        letter-spacing: 5px;
    }
    .badgespan-seguro {
        background: rgba(0,166,80,.1);
        border: 0;
    }
    .badgespan-seguro .andes-badge__content {
        color: #00a650;
    }
    .badgespan-seguro {
        margin-left: 1em;
        padding: 0.25em 0.375em 0.5em;
    }
    .badgespan-seguro {
        -webkit-border-radius: 8px;
        border-radius: 8px;
        height: 19px;
    }
    .title-h2 {
        font-size: 1em;
        font-weight: 600;
        line-height: 1.3;
        margin-bottom: 1em;
    }
    .andes-badge__content {
        font-size: 11px;
        line-height: 4px;
        
    }
    .title-h2 {
        margin-top: 0;
        margin-bottom: 0.5em;
    }

    .andes-badge__content {
        font-weight: 700;
        padding: 0;
    }
    .andes-badge--small {
        line-height: 4px;
    }

    .badgespan-seguro {
        color: #fff;
        font-size: .875em;
    }
    .andes-badge__content {
        margin: 0;
    }
    .txt-pago {
        width: 100%;
        padding: 2em;
        position: relative;
    }
    .tabla-resumen {
        margin-bottom: 2em;
    }
    .nav-top{
        background: rgb(10,132,255); /* Old browsers */
        background: -moz-linear-gradient(top,  rgba(10,132,255,1) 0%, rgba(1,40,97,1) 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top,  rgba(10,132,255,1) 0%,rgba(1,40,97,1) 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom,  rgba(10,132,255,1) 0%,rgba(1,40,97,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#0a84ff', endColorstr='#012861',GradientType=0 ); /* IE6-9 */
    }
    .nav-top {
        color: white;
        font-weight: bold;
        padding: 0.5em;
        z-index: 99999;
        position: relative;
        width: 100vw;
        top: 0;
    }
    .flex-content {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .bg-white {
        background: white;
        margin-right: 1em;
    }
    .status-coti {
        margin-top: 4em;
    }
    .status-coti {
        margin-top: 4em;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .cont-status {
        width: 68vw;
        padding: 1em;
        border-radius: 0.5em;
        color: white;
        font-weight: bold;
    }
    .cont-status p {
        margin: 0;
    }
    .st-pendiente{
        background: #ffb800;
    }
    .st-apro{
        background: #1cc88a;
    }
    .muestra-p{
        right: 0;
    }
    .botonera-mp {
        position: fixed;
        right: -6em;
        top: 50%;
        z-index: 9;
        
    }
    .cont-botones{
        -moz-transform: rotate(270deg);
        -webkit-transform: rotate(270deg);
        -o-transform: rotate(270deg);
        -ms-transform: rotate(270deg);
        transform: rotate(270deg);
    }
    .cont-botones ul {
        margin: 0;
        padding: 0;
        list-style: none;
    }
    .cont-botones a {
        background: #009ee3;
        padding: 1em;
        color: white;
        font-weight: bold;
    }
    .cont-botones a:focus {
        text-decoration: none;
    }

    .cont-botones a:hover {
        text-decoration: none;
    }
    a#cerrar-pago {
        position: absolute;
        top: 1em;
        right: 1em;
        width: 30px;
        height: 30px;
        background: #009ee3;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
    @media (max-width: 767px){
        .promo{
            background-size: 200%;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 35vw;
        }
        .promo2{
            background-size: 225%;
            background-repeat: no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 35vw;
        }
        .nav-top{
            position: relative;;
        }
    }
    .display-none {
        display: none;
    }
    .btn{
        cursor: pointer;
    }
    .btn-success {
        color: #fff;
        background-color: #28a745;
        border-color: #28a745;
        
    }
    .btn-danger {
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
    }
    .disabled {
        opacity: 0.7;
        cursor: no-drop;
    }
    .cont-flex {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .cont-f-pasarela{
        display: flex;
        justify-content: center;
    }
    .col6 {
        width: 50%;
        padding: 0.5em;
    }
    .form-c {
        width: 100%;
        border: 0;
        padding: 0.7em 1em;
        border-radius: 3px;
        box-shadow: 0 0 3px #b5b4b4;
    }
    .col12 {
        width: 100%;
        padding: 0.5em;
    }
    .col-md {
        width: 40vw;
        padding: 0 2vw;
    }
    .tit-promo {
        position: absolute;
        top: 12.5rem;
        right: 20%;
        transform: translateX(-50%) translateY(-50%);
        z-index: 1;
        width: 50vw;
    }
    .tit-promo img {
        width: 100%;
    }
    main.page-normal {
        background: white;
    }
    .quantity.quantity-lg {
			height: 45px;
		}
		.quantity {
			margin: 0 15px 25px 0;
			overflow: hidden;
			position: relative;
			width: 125px;
			height: 40px;
			float: left;
		}
		.quantity.quantity-lg .minus {
			height: 45px;
			width: 45px;
		}
        .quantity.quantity-lg .plus {
			height: 45px;
			width: 45px;
		}

		.quantity .minus {
			background: 0 0;
			border: 1px solid #f0f0f0;
			border-radius: 2px;
			box-shadow: none;
			color: #5e5e5e;
			cursor: pointer;
			display: block;
			font-size: 12px;
			font-weight: 700;
			height: 40px;
			line-height: 13px;
			margin: 0;
			overflow: visible;
			outline: 0;
			padding: 0;
			position: absolute;
			text-align: center;
			text-decoration: none;
			vertical-align: text-top;
			width: 40px;
			border-radius: 0.25rem 0 0 0.25rem;
		}
		.quantity .plus {
			background: 0 0;
			border: 1px solid #f0f0f0;
			border-radius: 2px;
			box-shadow: none;
			color: #5e5e5e;
			cursor: pointer;
			display: block;
			font-size: 12px;
			font-weight: 700;
			height: 40px;
			line-height: 13px;
			margin: 0;
			overflow: visible;
			outline: 0;
			padding: 0;
			position: absolute;
			text-align: center;
			text-decoration: none;
			vertical-align: text-top;
			width: 40px;
			border-radius: 0 0.25rem 0.25rem 0;
			right: 0;
			top: 0;
		}
		.quantity.quantity-lg .qty {
			height: 45px;
		}

		.quantity .qty {
			border: 1px solid #f0f0f0;
			box-shadow: none;
			float: left;
			height: 40px;
			padding: 0 39px;
			text-align: center;
			width: 125px;
			font-weight: 700;
			font-size: 1em;
			outline: 0;
			border-radius: 0.25rem;
		}

        .text-vencido {
    position: absolute;
    z-index: 1;
    text-align: center;
    width: 50vw;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    margin: 0 auto;
    height: 82vh;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>