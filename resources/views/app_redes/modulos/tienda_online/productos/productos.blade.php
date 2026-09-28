@extends('layouts.app_redes')
@section('css')
	<link rel="stylesheet" href="{{url('script/css/jquery-ui.min.css')}}">
		
	<link rel="stylesheet" href="https://cdn.datatables.net/searchpanes/2.0.2/css/searchPanes.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/select/1.4.0/css/select.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
	<style>
		.btn-md{
			border-radius: 0.2rem;
		}
		table.dataTable tbody tr.selected>* {
			box-shadow: inset 0 0 0 9999px rgb(13 110 253 / 90%);
			color: white;
		}
		.btn-success {
			color: #fff !important;
			background-color: #1cc88a !important;
			border-color: #1cc88a !important;
		}
		.btn-info {
			color: #fff !important;
			background-color: #36b9cc !important;
			border-color: #36b9cc !important;
		}
		.checkbox-toggle i{
			border: 2px solid rgb(51 122 183);
		}
		.disabled i:before {
			background: #bdbdbd;
		}
		.disabled input:checked + i {
			border: 2px solid #bdbdbd;
		}
		.aceptada i:before {
			background: #1cc88a;
		}
		.aceptada input:checked + i {
			border: 2px solid #1cc88a;
		}
		.pendiente i:before {
			background: #f6c23e;
		}
		.pendiente input:checked + i {
			border: 2px solid #f6c23e;
		}
		.dataTable tbody tr:hover {
			background: #ffd971 !important;
    		color: black !important;
		}
		.aceptada {
			cursor: no-drop;
		}
		.table td, .table th {
			padding: 0.3rem;
		}

		#tablaProductos > tbody > tr > td:nth-child(7) label {
			margin: 0 auto;
		}
		.table thead th {
			background: #3b5998;
			color: white;
		}
		.btn-add {
			margin-top: 0;
		}
		.img-thumb img {
			width: 50px;
			height: 50px;
			object-fit: contain;
		}
		.img-thumb {
			width: 50px;
			height: 50px;
		}
		.estrella a {
			color: #3b5998;
		}
		.estrella {
			color: #3b5998;
		}
		
	</style>
@stop
@section('content')
    @include('app_redes.modulos.tienda_online.productos.contenido_listado_productos')
@stop

@section('js')
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
	<script src="{{url('script/js/jquery-ui.min.js')}}"></script>
	<script>
		//$(document).on("click", "#confirm_activa_p", openConfirmActiva);
    	$(document).on("click", "#confirm_elimina_p", openConfirmElimina);
    	$(document).on("click", "#confirm_desactiva", openConfirmDesactiva);
    	$(document).on("click", "#confirm_activa_p", openConfirmActiva);
		
		$( document ).ready(function() {
			muestraTablaProductos();
		});

		function muestraTablaProductos () {
			var tbl_cotizaciones = $('#tablaProductos').DataTable({
				serverSide: true,
				order: [[ 0, "desc" ]],
				columnDefs: [
					{
						"targets": [0],
						"visible": false,
						"searchable": false
					}
				],
				ajax: {
					url: '{{ route("path_ajax_table_products") }}'
				},
				lengthMenu: [
					[ 10, 25, 50, -1 ],
					[ '10 productos', '25 productos', '50 productos', 'Mostrar todos' ]
				],
				columns: [
					{data: 'id_product', name: 'id_product'},
					{data: 'id_product', name: 'id_product'},
					{data: 'imagen_portada', name: 'imagen_portada'},
					{data: 'post_titulo', name: 'post_titulo'},
					{data: 'categoria', name: 'categoria'},
					{data: 'post_fecha', name: 'post_fecha'},
					{data: 'precio', name: 'precio'},
					{data: 'post_estatus', name: 'post_estatus'},
					{data: 'estrella', name: 'estrella'},
					{data: 'action', name: 'action', orderable: false, searchable: false},         
				]
			})
		}

		function openConfirmElimina (e) {
			e.preventDefault();
			var id_producto = $(this).attr("data-id-p");
			swal({
				title: "¿Estas seguro?",
				text: "Si confirma se eliminará el producto permanentemente",
				icon: "warning",
				buttons: true,
				dangerMode: true,
				buttons: ["Cancelar", "Si, ELIMINAR ahora"],
			})
			.then((willConfirm) => {
				if (willConfirm) {
					confirmElimina(id_producto);
				} else {
					
				}
			});
		}
		function confirmElimina (id_producto) {
			var id_producto = id_producto;
			var data_json = {
				"accion":"confirmElimina",
				"datos":{
					"id_producto":id_producto
				}
			}
			ajaxSetup();
			$.ajax({
				data:  data_json,
				url:   '{{ route("ajax_tienda_path") }}',
				type:  'post',
				datatype:'html',
				beforeSend: function () {
				},
				success:  function (result) {
					$('#tablaProductos').DataTable().destroy();
					muestraTablaProductos();
					swal("Éxito!", "Se ha Eliminado permantentemente!", "success");
					
				},
				error: function(error){
					console.log(error);
				}
			});
		}

		function openConfirmDesactiva (e) {
			e.preventDefault();
			var id_producto = $(this).attr("data-id-p");
			swal({
				title: "Se puede revertir",
				text: "Si confirma se desactivará el producto y no será público",
				icon: "warning",
				buttons: true,
				dangerMode: false,
				buttons: ["Cancelar", "Si, Desactivar ahora"],
			})
			.then((willConfirm) => {
				if (willConfirm) {
					confirmDesactiva(id_producto);
				} else {
					
				}
			});
		}

		function confirmDesactiva (id_producto) {
			var id_producto = id_producto;
			var data_json = {
				"accion":"confirmDesactiva",
				"datos":{
					"id_producto":id_producto
				}
			}
			ajaxSetup();
			$.ajax({
				data:  data_json,
				url:   '{{ route("ajax_tienda_path") }}',
				type:  'post',
				datatype:'html',
				beforeSend: function () {
				},
				success:  function (result) {
					$('#tablaProductos').DataTable().destroy();
					muestraTablaProductos();
					swal("Éxito!", "Se ha Desactivado el producto!", "success");
					
				},
				error: function(error){
					console.log(error);
				}
			});
		}
		
		function openConfirmActiva (e) {
			e.preventDefault();
			var id_producto = $(this).attr("data-id-p");
			swal({
				title: "Se publicará el producto",
				text: "Si confirma se publicará el producto",
				icon: "warning",
				buttons: true,
				dangerMode: false,
				buttons: ["Cancelar", "Si, PUBLICAR ahora"],
			})
			.then((willConfirm) => {
				if (willConfirm) {
					confirmActiva(id_producto);
				} else {
					
				}
			});
		}
		function confirmActiva (id_producto) {
			var id_producto = id_producto;
			var data_json = {
				"accion":"confirmActiva",
				"datos":{
					"id_producto":id_producto
				}
			}
			ajaxSetup();
			$.ajax({
				data:  data_json,
				url:   '{{ route("ajax_tienda_path") }}',
				type:  'post',
				datatype:'html',
				beforeSend: function () {
				},
				success:  function (result) {
					$('#tablaProductos').DataTable().destroy();
					muestraTablaProductos();
					swal("Genial!", "Se ha Publicado el producto!", "success");
					
				},
				error: function(error){
					console.log(error);
				}
			});
		}
	</script>
@stop