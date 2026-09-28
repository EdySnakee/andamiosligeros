<div class="social-whats-footer">
    <a href="https://api.whatsapp.com/send/?phone=525519484708&text=Hola,+quiero+recibir+informacion+sobre+Andamios+Ligeros&app_absent=0" id="whatsapp_widget" class="whatsapp_widget_big" style="width:80px; height:80px; " target="_blank">
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
