<div class="modal-dialog modal-dialog-centered">
	<div class="modal-content">
		<div class="modal-header">
			@if($accion == "agregar")
				<h5 class="modal-title">Agregar Usuario</h5>
			@else
				<h5 class="modal-title">Editar Usuario</h5>
			@endif
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
					    <label for="nombre_usuario">Nombre Usuario:</label>
					</div>
				</div>
				<div class="col-md-8">
					<div class="form-group">
					    <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" placeholder="Nombre completo" autocomplete="nope" value="{{$objUsuarios->name}}">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
					    <label for="email_usr">Email:</label>
					</div>
				</div>
				<div class="col-md-8">
					<div class="form-group">
					    <input type="text" class="form-control" id="email_usr" name="email_usr" placeholder="Email" autocomplete="nope" value="{{$objUsuarios->email}}">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
					    <label for="pass_usr">Password:</label>
					</div>
				</div>
				<div class="col-md-8">
					<div class="form-group">
					    <input type="password" class="form-control" id="pass_usr" name="pass_usr" placeholder="Password" autocomplete="nope">
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			@if($accion == "agregar")
			<button type="button" class="btn btn-primary" id="add_usuario">Guardar usuario</button>
			@else
			<button type="button" class="btn btn-primary" id="edit_usuario" data-id-usuario="{{$objUsuarios->id}}">Editar usuario</button>
			@endif
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
		</div>
	</div>
</div>
    

  
