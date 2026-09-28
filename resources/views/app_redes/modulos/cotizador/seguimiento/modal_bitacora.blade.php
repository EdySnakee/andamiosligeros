<div class="modal-dialog modal-xl">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title">Agregar Archivo</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-8">
					<div class="form-group">
					    <label for="archivo_proyecto">Archivo proyecto:</label> <br>
					    <input type="file" name="archivo_proyecto" id="archivo_proyecto" class="dropify" />
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="descrip_archivo">Descripción de archivo:</label> <br>
					    <textarea  class="form-control"  name="descrip_archivo" id="descrip_archivo" cols="30" rows="10"></textarea>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" id="add_bitacora" data-id-proyect="{{$data_post->id_proyecto}}" data-id-coti="{{$data_post->id_cotizacion}}">Guardar archivo</button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
		</div>
	</div>
</div>
    

  
