<div class="modal-dialog modal-lg modal-dialog-centered">
	<div class="modal-content">
		<div class="modal-header">
			@if($accion == "Iniciar")
				<h5 class="modal-title">Iniciar proyecto {{$data_post->nom_cotizacion}}</h5>
			@else
				<h5 class="modal-title">Editar proyecto</h5>
			@endif
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
					    <label for="titulo_trabajo">Titulo de Trabajo *:</label>
					</div>
				</div>
				<div class="col-md-8">
					<div class="form-group">
					    <input type="text" class="form-control" id="titulo_trabajo" name="titulo_trabajo" placeholder="Titulo de Trabajo" autocomplete="off" value="">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
					    <label for="personal_labora">Personal responsable *:</label>
					</div>
				</div>
				<div class="col-md-8">
					<div class="form-group">
					    <input type="text" class="form-control" id="personal_labora" name="personal_labora" placeholder="Nombre personal responsable" autocomplete="off" value="">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
					    <label for="fecha_elaboracion">Fecha de elaboración:</label>
					</div>
				</div>
				<div class="col-md-8">
					<div class="form-group">
					    <input type="date" value="{{date('Y-m-d')}}" class="form-control" id="fecha_elaboracion" name="fecha_elaboracion" placeholder="Fecha de elaboración" autocomplete="off">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
					    <label for="comentario">Comentarios:</label>
					</div>
				</div>
				<div class="col-md-8">
					<div class="form-group">
					    <textarea class="form-control" id="comentario" name="comentario" placeholder="Comentarios" id="" cols="30" rows="10"></textarea>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			@if($accion == "Iniciar")
			<button type="button" class="btn btn-primary" id="add_proyecto" data-id-coti="{{$data_post->id_cotizacion}}" >Guardar proyecto</button>
			@else
			<button type="button" class="btn btn-primary" id="edit_usuario" data-id-usuario="">Editar proyecto</button>
			@endif
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
		</div>
	</div>
</div>
    

  
