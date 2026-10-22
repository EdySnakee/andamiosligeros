<div class="modal-dialog modal-dialog-centered">
	<div class="modal-content border-0 shadow-lg">
		<div class="modal-header bg-gradient-primary text-white">
			<h5 class="modal-title font-weight-bold">
				@if($accion == "agregar")
					<i class="fas fa-user-plus mr-2"></i> Agregar Nuevo Usuario
				@else
					<i class="fas fa-user-edit mr-2"></i> Editar Usuario
				@endif
			</h5>
			<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body p-4">
			<div id="modal_user_alert" class="alert alert-danger d-none" role="alert"></div>

			<form id="form_usuario" autocomplete="off">
				<div class="form-group mb-3">
					<label for="nombre_usuario" class="font-weight-bold text-gray-700">
						Nombre Completo <span class="text-danger">*</span>
					</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" 
							placeholder="Ej. Juan Pérez" value="{{ $objUsuarios ? $objUsuarios->name : '' }}" required>
					</div>
				</div>

				<div class="form-group mb-3">
					<label for="email_usr" class="font-weight-bold text-gray-700">
						Correo Electrónico <span class="text-danger">*</span>
					</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-envelope"></i></span>
						</div>
						<input type="email" class="form-control" id="email_usr" name="email_usr" 
							placeholder="correo@ejemplo.com" value="{{ $objUsuarios ? $objUsuarios->email : '' }}" required>
					</div>
				</div>

				<div class="form-group mb-3">
					<label for="tipo_usuario" class="font-weight-bold text-gray-700">
						Rol / Perfil de Acceso <span class="text-danger">*</span>
					</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user-tag"></i></span>
						</div>
						<select class="form-control" id="tipo_usuario" name="tipo_usuario" required>
							@php
								$selected_rol = $objUsuarios ? $objUsuarios->tipo_usuario : 'v1';
							@endphp
							@foreach($roles_disponibles as $key => $label)
								<option value="{{ $key }}" {{ ($selected_rol === $key || ($key === 'v1' && in_array($selected_rol, ['v1', 'vendedor', 'f1', 'n2'])) || ($key === 't1' && in_array($selected_rol, ['t1', 'taller']))) ? 'selected' : '' }}>
									{{ $label }}
								</option>
							@endforeach
						</select>
					</div>
					<small class="form-text text-muted mb-2">
						Define los módulos a los que este usuario tendrá acceso en el panel.
					</small>

					<!-- Contenedor de previsualización dinámica de permisos -->
					<div id="preview_permisos_container" class="p-3 bg-light border rounded shadow-sm">
						<div class="d-flex align-items-center justify-content-between mb-2">
							<span class="font-weight-bold text-gray-800 small text-uppercase">
								<i class="fas fa-shield-alt text-primary mr-1"></i> Módulos Permitidos:
							</span>
						</div>
						<div id="preview_permisos_badges" class="d-flex flex-wrap"></div>
						<div id="preview_permisos_resumen" class="small text-muted mt-2 font-italic border-top pt-2"></div>
					</div>
				</div>

				<hr class="my-3">

				<div class="form-group mb-3">
					<label for="pass_usr" class="font-weight-bold text-gray-700">
						Contraseña @if($accion == "agregar") <span class="text-danger">*</span> @endif
					</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-lock"></i></span>
						</div>
						<input type="password" class="form-control" id="pass_usr" name="pass_usr" 
							placeholder="{{ $accion == 'agregar' ? 'Mínimo 6 caracteres' : 'Dejar en blanco para no cambiarla' }}" autocomplete="new-password">
					</div>
					@if($accion != "agregar")
						<small class="form-text text-muted">
							Solo llena este campo si deseas cambiar la contraseña del usuario.
						</small>
					@endif
				</div>

				<div class="form-group mb-2">
					<label for="pass_confirm" class="font-weight-bold text-gray-700">
						Confirmar Contraseña
					</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-shield-alt"></i></span>
						</div>
						<input type="password" class="form-control" id="pass_confirm" name="pass_confirm" 
							placeholder="Repite la contraseña" autocomplete="new-password">
					</div>
				</div>
			</form>
		</div>
		<div class="modal-footer bg-light">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">
				<i class="fas fa-times mr-1"></i> Cancelar
			</button>
			@if($accion == "agregar")
				<button type="button" class="btn btn-primary" id="btn_guardar_usuario">
					<i class="fas fa-check mr-1"></i> Crear Usuario
				</button>
			@else
				<button type="button" class="btn btn-primary" id="btn_actualizar_usuario" data-id-usuario="{{ $objUsuarios->id }}">
					<i class="fas fa-save mr-1"></i> Guardar Cambios
				</button>
			@endif
		</div>
	</div>
</div>

    

  
