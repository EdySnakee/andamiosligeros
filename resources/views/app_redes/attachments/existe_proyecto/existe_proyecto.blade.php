 @if($existe == "si")
	<div class="p-3 mb-3 bg-warning text-dark">* Ya existe el proyecto <span class="nom_proyecto">{{$catalogoProyectos->nombre_proyecto}}</span> asignado a este estado.
		<form action="{{ route('app_redes_edit_proyectos')}}" method="post" style="display: inline-flex; align-items: center; justify-content: center;">
	                      {!! csrf_field() !!}
	  		<input type="hidden" name="id_proyecto" id="id_proyecto" value="{{$catalogoProyectos->id_proyecto}}">
	  		<button type="submit" class="btn btn-secondary btn-icon-split">
	  			<span class="icon text-white-50">
                  <i class="fas fa-edit"></i> 
                </span>
                <span class="text">Editar Proyecto</span>
	  		</button>
	  	</form>
	</div>
@elseif($existe == "no")
    <div class="p-3 mb-3 bg-success text-white">Estado disponible para asignar proyecto</div>
    <input type="hidden" value="{{$estado}}" id="valor-estado">
@endif
