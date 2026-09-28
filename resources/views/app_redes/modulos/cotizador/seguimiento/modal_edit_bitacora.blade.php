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
					    <input type="file" name="archivo_proyecto" id="archivo_proyecto" class="dropify" data-default-file="{{url('storage/bitacoras')}}/{{$info_bitacora->id_seguimiento}}/{{$info_bitacora->archivo}}"/>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="descrip_archivo">Descripción de archivo:</label> <br>
					    <textarea  class="form-control"  name="descrip_archivo" id="descrip_archivo" cols="30" rows="10">{{$info_bitacora->comentario}}</textarea>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" id="edit_bitacora" data-id-bitacora="{{$data_post->id_bitacora}}" data-id-proyect="{{$data_post->id_proyecto}}" data-id-seguimiento="{{$info_bitacora->id_seguimiento}}">Editar archivo</button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
		</div>
	</div>
</div>
    

  
