<style>
    .social-whats-footer {
        position: fixed;
        right: 22px;
        bottom: 22px;
        z-index: 98;
        display: flex;
        align-items: center;
        gap: 10px;
        font-family: "Poppins", sans-serif;
    }

    .al-wa-promo-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }

    .al-wa-promo-WrapHidden {
        display: none !important;
    }

    .al-wa-promo-bubble {
        background: #ffffff;
        color: #111827 !important;
        text-decoration: none !important;
        border: 2px solid #25d366;
        border-radius: 14px;
        padding: 8px 26px 8px 12px;
        box-shadow: 0 8px 22px rgba(15, 23, 42, 0.25);
        display: flex;
        flex-direction: column;
        line-height: 1.2;
        max-width: 235px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .al-wa-promo-bubble:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 26px rgba(15, 23, 42, 0.32);
        color: #111827 !important;
        text-decoration: none !important;
    }

    .al-wa-promo-bubble__title {
        font-size: 12.5px;
        font-weight: 800;
        color: #0b2e6b;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .al-wa-promo-bubble__sub {
        font-size: 11px;
        font-weight: 600;
        color: #15803d;
        margin-top: 2px;
    }

    .al-wa-promo-close {
        position: absolute;
        top: 4px;
        right: 6px;
        background: none;
        border: none;
        color: #64748b;
        font-size: 14px;
        font-weight: 700;
        line-height: 1;
        padding: 2px 4px;
        cursor: pointer;
    }

    .al-wa-promo-close:hover {
        color: #111827;
    }

    @media (max-width: 599px) {
        .social-whats-footer {
            right: 12px;
            bottom: 14px;
            gap: 8px;
        }
        .al-wa-promo-bubble {
            max-width: 190px;
            padding: 6px 22px 6px 10px;
        }
        .al-wa-promo-bubble__title {
            font-size: 11.5px;
        }
        .al-wa-promo-bubble__sub {
            font-size: 10px;
        }
    }
</style>

<div class="social-whats-footer">
    <div class="al-wa-promo-wrap" id="alWaPromoWrap">
        <a href="https://api.whatsapp.com/send/?phone=525519484708&text=Hola,+vengo+de+la+p%C3%A1gina+web+de+Andamios+Ligeros+y+me+interesa+la+promoci%C3%B3n+de+env%C3%ADo+gratis.&app_absent=0"
           target="_blank" rel="noopener" class="al-wa-promo-bubble">
            <span class="al-wa-promo-bubble__title">&#128666; ¡Envío GRATIS por promo!</span>
            <span class="al-wa-promo-bubble__sub"><i class="fa fa-whatsapp" aria-hidden="true"></i> Solicítalo aquí por WhatsApp</span>
        </a>
        <button type="button" class="al-wa-promo-close" aria-label="Minimizar aviso"
                onclick="document.getElementById('alWaPromoWrap').className='al-wa-promo-wrap al-wa-promo-WrapHidden';">&times;</button>
    </div>

    <a href="https://api.whatsapp.com/send/?phone=525519484708&text=Hola,+vengo+de+la+p%C3%A1gina+web+de+Andamios+Ligeros+y+me+interesa+la+promoci%C3%B3n+de+env%C3%ADo+gratis.&app_absent=0"
       id="whatsapp_widget" class="whatsapp_widget_big" style="width:80px; height:80px;" target="_blank" rel="noopener"
       title="Solicitar promoción de envío gratis por WhatsApp">
        <img src="{{url('web/img/icon_whatsApp.png')}}" alt="whatsapp icon" id="icon_whatsapp_widget">
    </a>
</div>

<div id="modal-andamios" class="cont-form-cotiza cerrado">
	<a class="cerrar" href="#" id="cerrar"><i class="fa fa-close"></i> Cerrar</a>
	<form id="cotizaForm" name="sentMessage" novalidate="novalidate" enctype="multipart/form-data">
		<div class="row">
			<h1><span class="border-title-secc">Cotiza</span> <br>andamios ligeros</h1>
			<div class="twelve columns">
			    <div class="form-group">
			        <input autocomplete="off" class="form-control" id="nombre" type="text" placeholder="Tu nombre *" required="required" data-validation-required-message="Necesitamos tu nombre.">
			        <p class="help-block text-danger"></p>
			    </div>
			    <div class="form-group">
			        <input autocomplete="off" class="form-control" id="andamio_interes" type="text" placeholder="Andamio de interes" required="required" data-validation-required-message="Selecciona un producto.">
			    	<p class="help-block text-danger"></p>
			    </div>
			    <div class="form-group">
			        <input autocomplete="off" class="form-control" id="correo" type="email" placeholder="Tu email *" required="required" data-validation-required-message="Necesitamos tu correo.">
			        <p class="help-block text-danger"></p>
			    </div>
			    <div class="form-group">
			        <input autocomplete="off" class="form-control" id="celular_cli" type="number" placeholder="Tu celular *" maxlength="10" minlength="10" required="required" data-validation-required-message="Necesitamos tu numero de celular.">
			        <p class="help-block text-danger"></p>
			    </div>
			    <div class="form-group">
			        <textarea class="form-control" id="mensaje" placeholder="Mensaje "></textarea>
			        <p class="help-block text-danger"></p>
			    </div>
			</div>
			<div class="twelve columns text-center">
			 	<div id="success_cli"></div>
			 	<button id="sendMessageButtonCotiza" class="btn-send-coti" type="submit">Enviar mensaje</button>
			</div>
		</div>
	</form>
</div>



<?php /*
*/ ?>
<div id="modal-andamios2" class="cont-form-ficha cerrado2">
	<div class="body-form">
		<a class="cerrar" href="#" id="cerrar2"><i class="fa fa-close"></i> Cerrar</a>
		<form id="enviaFicha" name="sentMessage" novalidate="novalidate" enctype="multipart/form-data">
			<div>
				<h2 class="modal2-titulo">Descarga <br> Ficha técnica</h2>
				<div class="twelve columns">
				    <div class="form-group">
				        <input autocomplete="off" class="form-control black" id="nombre_descarga" type="text" placeholder="Tu nombre *" required="required" data-validation-required-message="Necesitamos tu nombre.">
				        <p class="help-block text-danger"></p>
				    </div>
				    <div class="form-group">
				        <input autocomplete="off" class="form-control black" id="correo_descarga" type="email" placeholder="Tu email *" required="required" data-validation-required-message="Necesitamos tu correo.">
				        <p class="help-block text-danger"></p>
				    </div>
				    <div class="form-group">
				        <input autocomplete="off" class="form-control black" id="celular_cli_descarga" type="number" placeholder="Tu celular *" maxlength="10" minlength="10" required="required" data-validation-required-message="Necesitamos tu numero de celular.">
				        <p class="help-block text-danger"></p>
				    </div>
				</div>
				<div class="twelve columns text-center">
				 	<div id="success_cli"></div>
				 	<input autocomplete="off" class="form-control" id="ficha_andamio" value="" type="hidden">
				 	<button id="sendMessageButtonDescarga" class="btn-send-coti" type="submit">Descargar</button>
				</div>
			</div>
		</form>
	</div>
</div>
