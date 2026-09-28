@if(!$datos_galeria_cliente->isEmpty())
  <div class="cont_galeria">
	@foreach($datos_galeria_cliente as $result_galeria)
	  <article class="item_galeria">
	    <a href="#" class="delete_img" id-imagen="{{$result_galeria->id_imagen}}" nombre-imagen="{{$result_galeria->img_galeria}}"><i class="fas fa-times"></i></a>
	    <img class="img_galeria" src="{{url('storage/clientes/galerias')}}/{{$datos_cliente->id_proyecto}}/{{$datos_cliente->id_cliente}}/{{$result_galeria->img_galeria}}" alt="">
	  </article>
	@endforeach
  </div>
@else
<div class="col-md-12">No cuenta con galeria</div>

@endif