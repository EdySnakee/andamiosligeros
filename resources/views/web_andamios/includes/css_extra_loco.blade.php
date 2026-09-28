<style>
    .cont-confirm-pedido {
        border: 1px #1a1a1a solid;
        border-radius: 5px;
        padding: 1em 0.5em;
    }

    .cont-confirm-pedido p {
        font-size: 13px;
    }

    .cont-img-res {
        width: 50px;
        height: 50px;
        border: 1px #9f9d9d solid;
        padding: 5px;
        border-radius: 5px;
    }

    .cont-pie-pedido {
        position: relative;
    }

    .cont-pie-pedido .btn-danger {
        font-size: 15px !important;
    }

    .info_mp {
        position: absolute;
        top: 0;
        right: 0;
    }

    .cont-img-res img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    div#list-products a:hover {
        text-decoration: none;
    }

    .cont-princ-product {
        background: white;
        margin-top: 6em;
        margin-bottom: 8em;
        padding-top: 3em;
        padding-bottom: 3em;
        border-radius: 1em;
    }

    /* ESTILOS CARRITO  */
    .carrito-padre {
        background: none;
        max-width: 1200px;
        padding: 100px 20px;
        margin: 0 auto;
    }

    .cart {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .cart-container {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;

    }

    .cart-left-side,
    .cart-right-side {
        width: 100%
    }

    .cart-contador {
        margin-bottom: 10px;
        font-size: 24px;
    }


    .cart-producto {
        position: relative;
    }

    .cart-producto-container {
        display: flex;
        overflow: hidden;
        display: flex;
        gap: 10px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 8px 12px -5px rgb(211, 211, 211);
        background: white;
    }

    .cart-producto-img-container {
        width: 20%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding-left: 3px;
    }

    .cart-producto-img {
        width: 100%;
        height: 100px;
        object-fit: contain;
    }

    .cart-producto-info {
        width: 70%;
        padding: 10px;
        display: flex;
        flex-direction: column;
        justify-content: center;

        h3 {
            font-size: 20px;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: pointer;
        }

        p {
            font-size: 18px;
            margin: 0;
        }
    }

    .cart-cantidad {
        display: flex;
        gap: 10px;
        align-items: center
    }

    .cantidad-container {
        display: flex;
        align-items: center;
    }

    .cantidad-control,
    .cantidad-valor {
        border: none;
        padding: 7px 15px;
        outline: none;
        font-weight: 600;
    }

    .cantidad-control {
        border-radius: 50%;
        transition: 300ms;
    }

    .cantidad-control:hover {
        color: white;
    }

    .cantidad-disminuir:hover {
        background-color: #0648d6;
    }

    .cantidad-aumentar:hover {
        background-color: #ffbb01;
    }

    .cart-producto-tooltip {
        background: rgba(0, 0, 0, 0.6);
        padding: 10px;
        color: white;
        position: absolute;
        top: -40px;
        border-radius: 10px;
        visibility: hidden;
        opacity: 0;
        transition: 300ms;
        font-weight: 600;
    }

    .cart-producto-titulo:hover+.cart-producto-tooltip {
        opacity: 1;
        visibility: visible
    }

    .cart-producto-tooltip:hover {
        opacity: 1;
        visibility: visible;
    }

    .cart-producto-remove {
        width: 10%;
        display: flex;
        justify-content: center;
        align-items: center
    }

    .cart-producto-remove button,
    .cart-producto-remove button:hover,
    .cart-producto-remove button:focus,
    .cart-producto-remove button:active {
        background: none;
        background-color: transparent;
        border: none;
        outline: none;
    }


    .cart-producto-remove i {
        font-size: 28px;
        color: grey;
        transition: color 300ms;
    }

    .cart-producto-remove i:hover {
        color: #dc3545;
    }

    .clear-cart {
        display: flex;
        justify-content: end;
    }

    .cart-vaciar-btn {
        background-color: grey;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        padding: 3px 10px;
        transition: background-color 300ms;
    }

    .cart-vaciar-btn:hover {
        background-color: #dc3545;
    }

    .cart-datos-titulo {
        margin-bottom: 30px;
    }

    .cart-resumen {
        box-shadow: 0 8px 12px -5px rgb(211, 211, 211);
        border-radius: 10px;
        overflow: hidden;

        li {
            border: none;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }
    }

    .cart-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 30px;
    }

    .continuar-compra,
    .cart-confirmar {
        font-size: 20px;
        border: none;
        border-radius: 5px;
        padding: 15px 10px;
        color: white;
        font-weight: 600;
        transition: 300ms;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        width: 100%;
        text-align: center;
    }

    .continuar-compra {
        background-color: #0648d6;
    }

    .cart-confirmar {
        background-color: #ffbb01;
    }

    .continuar-compra:hover {
        box-shadow: 0px 10px 20px -5px #709dff;
        color: white;
    }

    .cart-confirmar:hover {
        box-shadow: 0px 10px 20px -5px #ffce48;
    }

    @media(min-width:768px) {

        .cart-left-side,
        .cart-right-side {
            width: 48%;
        }

        .cart-producto-info h3 {
            font-size: 22px;
        }

        .cart-producto-tooltip {
            top: -30px;
        }

        .cart-producto-img-container {
            padding: 10px;
        }

        .cart-buttons {
            justify-content: space-between;
        }

        .continuar-compra,
        .cart-confirmar {
            padding: 10px;
            font-size: 18px
        }

        .continuar-compra {
            order: 1;
            width: 50%;
        }

        .cart-confirmar {
            order: 2;
            width: 45%;
        }
    }

    /* FIN ESTILOS CARRITO */

    /* DETALLE PRODUCTO TIENDA */
    .video-card {
        max-width: 80%;
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 6px 24px rgba(0, 0, 0, .08);
        padding: 7px;
        transition: transform .18s ease, box-shadow .18s ease;
        border: 1px solid rgba(248, 240, 21, 0.12);
    }

    .video-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(0, 0, 0, .12);
    }

    .video-vertical {
        position: relative;
        width: 100%;
        border-radius: 12px;
        overflow: hidden;
        background: linear-gradient(180deg, rgba(152, 139, 63, 0.08), rgba(152, 146, 63, 0.02));
        border: 3px solid rgba(151, 144, 62, 0.2);
    }

    .video-vertical::before {
        content: "";
        display: block;
        padding-top: 177.78%;
    }

    .video-vertical__media {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    @media (max-width: 575.98px) {

        .video-card {
            max-width: 100%;
        }

        .ra-videos .section-title {
            font-size: 1.4rem;
        }

        .video-card {
            padding: 12px;
        }
    }

    /* FIN */

    .cont-img-activa {
        width: 100%;
        padding: 1em 10em;
    }

    .cont-img-product {
        display: flex;
    }

    .cur-pointer {
        cursor: pointer;
    }

    .thumb-gallery-wrapper .thumb-gallery-thumbs .owl-item:hover,
    .thumb-gallery-wrapper .thumb-gallery-thumbs .owl-item.selected {
        border: 2px solid #212121;
    }

    .thumb-gallery-wrapper .thumb-gallery-thumbs .owl-item {
        border: 2px solid #f7f7f7;
        transition: ease all 300ms;
    }

    .price .sale+.amount {
        font-size: .7em;
        font-weight: 500;
        margin-right: 4px;
        text-decoration: line-through;
    }

    .price .sale {
        order: 2;
        font-size: 28px;
        font-weight: 600;
    }

    .shop .summary .price {
        color: #444;
        font-size: 2em;
        letter-spacing: -1px;
        line-height: 30px;
        margin-top: 10px;
        clear: both;
    }

    .price {
        display: flex;
        align-items: center;
        min-height: 28px;
    }

    /*
//ESTILOS PARA ROTAR LOS ITEMS
.thumb-gallery-thumbs {
  transform: rotate(90deg);
  width: 270px;
  margin-top: 100px;
  z-index: 2;
}

.item {
  transform: rotate(-90deg);
}

.thumb-gallery-thumbs .owl-nav {
  display: flex;
  justify-content: space-between;
  position: absolute;
  width: 100%;
}
.thumb-gallery-thumbs img{
    transform: rotate(270deg);
}
.thumb-gallery-detail {
    position: absolute;
    top: 0;
    width: 100%;
    
}
*/
    .mt-3em {
        margin-top: 3em;
    }

    .cur-pointer img {
        width: 100px !important;
        height: 15vh;
        object-fit: contain;
    }

    .summary {
        margin-top: 3em;
    }

    .thumb-gallery-detail .owl-item img {
        object-fit: contain;
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

    .badge-estrella {
        color: #fff;
        background-color: #ffbb01;
    }

    .img-item-product .badge {
        position: absolute;
        top: 10px;
        left: 10px;
    }

    .img-item-product {
        position: relative;
        text-align: center;
    }

    .rounded-5 {
        border-radius: 0.5rem !important;
    }

    .img-item-product img {
        padding: 10px;
        height: 330px;
        object-fit: cover;
        border-radius: 17px;
    }

    .info-item-product {
        padding: 1em;
    }

    .cart-tienda .quantity {
        display: none;
    }

    .btn-atc {
        width: 100%;
        background-color: #ffbb01;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 5px;
        font-weight: 600;
        transition: box-shadow 300ms;
    }

    .btn-atc:hover {
        box-shadow: 5px 5px 8px -5px #878787;
    }

    .btn-atc i {
        font-size: 20px;
        margin-right: 5px
    }

    .font-cate {
        font-size: 1em !important;
    }

    ul.listado-items {
        padding-left: 1em;
    }

    ul.listado-items li {
        margin-bottom: 0.3em;
    }

    .badge.activo {
        background-color: #0648d6;
        color: white;
    }

    /* CART DE PRODUCTO */
    @keyframes pulse {
        0% {
            transform: scale(1);
            box-shadow: 0 0 5px rgba(255, 0, 0, 0.5);
        }

        50% {
            transform: scale(1.1);
            box-shadow: 0 0 10px rgba(255, 0, 0, 0.7);
        }

        100% {
            transform: scale(1);
            box-shadow: 0 0 5px rgba(255, 0, 0, 0.5);
        }
    }

    .pulse {
        animation: pulse 1s infinite;
        display: inline-block;
        padding: 0.5em 1em;
        border-radius: 13px;
        color: #fff;
        background-color: #e74d3c89;
        font-weight: bold;
        text-align: center;
    }

    .badge-danger {
        background-color: #e74c3c;
        color: #fff;
    }

    .p-right {
        margin-left: 1em;
        margin-bottom: 1em;
    }
</style>
