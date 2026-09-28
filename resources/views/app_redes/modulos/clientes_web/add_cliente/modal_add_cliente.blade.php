<div class="modal-dialog modal-xl">
	<div class="modal-content">
		<div class="modal-header">
			@if($accion == "agregar")
				<h5 class="modal-title">Agregar Cliente</h5>
			@else
				<h5 class="modal-title">Editar Cliente</h5>
			@endif
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
					    <label for="nombres_cliente">Nombre Completo:</label>
					    <input type="text" class="form-control" id="nombres_cliente" name="nombres_cliente" placeholder="Nombre y Apellidos" autocomplete="nope" value="{{(!empty($info_cliente->nombrecl))?$info_cliente->nombrecl : ''}}">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
					    <label for="numero_lead"><b>Número de Lead:</b></label>
					    <input type="number" class="form-control" id="numero_lead" name="numero_lead" placeholder="####" autocomplete="nope" value="{{(!empty($info_cliente->lead))?$info_cliente->lead : ''}}">
					</div>
				</div>
				<?php /*
				<div class="col-md-4">
						<div class="form-group">
							<label for="a_paterno">Apellido paterno:</label>
							<input type="text" class="form-control" id="a_paterno" name="a_paterno" placeholder="Apellido paterno" autocomplete="nope">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="a_materno">Apellido materno:</label>
							<input type="text" class="form-control" id="a_materno" name="a_materno" placeholder="Apellido materno" autocomplete="nope">
						</div>
					</div>
				*/ ?>
			</div>

			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label for="telefono">Teléfono:</label>
						<input type="number" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" autocomplete="nope" value="{{(!empty($info_cliente->telefonocl))?$info_cliente->telefonocl : ''}}">
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="celular">Celular:</label>
						<input type="number" class="form-control" id="celular" name="celular" placeholder="Celular" autocomplete="nope" value="{{(!empty($info_cliente->celularcl))?$info_cliente->celularcl : ''}}">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="email">Correo electrónico:</label>
						<input type="email" class="form-control" id="email" name="email" placeholder="Correo electrónico" autocomplete="off" value="{{(!empty($info_cliente->emailcl))?$info_cliente->emailcl : ''}}">
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label for="rfc">RFC:</label>
						<input type="text" class="form-control" id="rfc" name="rfc" placeholder="RFC" autocomplete="off" value="{{(!empty($info_cliente->rfccl))?$info_cliente->rfccl : ''}}">
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="cp">Código postal:</label>
						<input type="number" class="form-control" id="cp" name="cp" placeholder="Código postal" autocomplete="off" value="{{(!empty($info_cliente->cpcl))?$info_cliente->cpcl : ''}}">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="direccion">Dirección:</label>
						<input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección" autocomplete="off" value="{{(!empty($info_cliente->direccioncl))?$info_cliente->direccioncl : ''}}">
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label for="estado">Estado:</label>
						<select class="form-control" id="estado" name="estado">
						<option disabled selected>Seleccione un estado</option>
							@foreach($catalogo_estados as $catestado)
								<option value="{{$catestado->idestado}}" data-estado="{{$catestado->estado}}">{{$catestado->estado}}</option>
							@endforeach
						</select>
						@if($accion=="editar")
							<div class="ciudafct">
								Lugar Actual:<b>{{($info_cliente->lugarcl == "|" OR $info_cliente->lugarcl != " | ")?$info_cliente->lugarcl : ''}}</b>
								<input type="hidden" value="{{$info_cliente->lugarcl}}" id="lugarcl">
							</div>
						@endif
					</div>
					
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="ciudad_p">Ciudad:</label>
						<select autocomplete="on" name="ciudad_p" id="ciudad_p" class="form-control" aria-invalid="false">
							<option value="none" disabled selected >Seleccione una opción</option>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="comentarios">Comentarios</label>
						<textarea class="form-control" id="comentarios" rows="1"></textarea>
					</div>
				</div>
			</div>
			
			

			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="checkbox-toggle">
		                  @if($accion == "agregar")
		                    <input type="checkbox" name="iva" id="activa_empresa" value="empresa">
		                    <i></i>
		                    Es Empresa
		                  @elseif($accion == "editar")
		                  	@if(!empty($objEmpresa))
			                  	<input type="checkbox" name="iva" id="activa_empresa" value="empresa" checked>
			                    <i></i>
			                    Es Empresa
		                  	@else
			                    <input type="checkbox" name="iva" id="activa_empresa" value="empresa">
			                    <i></i>
			                    Es Empresa
		                    @endif
		                  @endif
		                </label>
					</div>
				</div>
			</div>

			@if($accion == "agregar")
			<div id="info_empresa" class="row">
			</div>
			@else
			<div id="info_empresa" class="row">
				@if(!empty($objEmpresa))
					
					@include('app_redes.modulos.extras.options_empresas')
					
				@else
			</div>
				@endif
			@endif

		</div>
		<div class="modal-footer">
			@if($accion == "agregar")
			<button type="button" class="btn btn-primary" id="add_cliente">Guardar cliente</button>
			@else
			<input type="hidden" id="id_cliente" value="{{(!empty($info_cliente->idcl))?$info_cliente->idcl : ''}}">
			<button type="button" class="btn btn-primary" id="edit_cliente">Editar cliente</button>
			@endif
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
		</div>
	</div>
</div>
    

  
