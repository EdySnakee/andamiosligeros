@extends('layouts.app_redes')
@section('css')
<link rel="stylesheet" href="{{url('script/css/jquery-ui.min.css')}}">

<link rel="stylesheet" href="https://cdn.datatables.net/searchpanes/2.0.2/css/searchPanes.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.4.0/css/select.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
<style>
	.btn-md {
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

	.checkbox-toggle i {
		border: 2px solid rgb(51 122 183);
	}

	.disabled i:before {
		background: #bdbdbd;
	}

	.disabled input:checked+i {
		border: 2px solid #bdbdbd;
	}

	.aceptada i:before {
		background: #1cc88a;
	}

	.aceptada input:checked+i {
		border: 2px solid #1cc88a;
	}

	.pendiente i:before {
		background: #f6c23e;
	}

	.pendiente input:checked+i {
		border: 2px solid #f6c23e;
	}

	.dataTable tbody tr:hover {
		background: #ffd971 !important;
		color: black !important;
	}

	.aceptada {
		cursor: no-drop;
	}

	.table td,
	.table th {
		padding: 0.3rem;
	}

	#tablaProductos>tbody>tr>td:nth-child(7) label {
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
@include('app_redes.modulos.promociones.contenido_listado_promo')
@stop

@section('js')
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script src="{{url('script/js/jquery-ui.min.js')}}"></script>
<script>
	$(document).ready(function() {
		muestraTablaPromos();
	});
	$(document).on("click", "#confirm_desactiva_promo", openConfirmDesactiva);
	$(document).on("click", "#confirm_activa_promo", openConfirmActiva);

	function muestraTablaPromos() {
		var tbl_cotizaciones = $('#tablaPromos').DataTable({
			serverSide: true,
			order: [
				[0, "desc"]
			],
			columnDefs: [{
				"targets": [0],
				"visible": false,
				"searchable": false
			}],
			ajax: {
				url: '{{ route("path_ajax_table_promos") }}'
			},
			lengthMenu: [
				[5, 10, 25, 50, -1],
				['5 Productos', '10 productos', '25 productos', '50 productos', 'Mostrar todos']
			],
			columns: [{
					data: 'id_promo',
					name: 'id_promo'
				},
				{
					data: 'id_promo',
					name: 'id_promo'
				},
				{
					data: 'img_banner',
					name: 'img_banner'
				},
				{
					data: 'post_titulo',
					name: 'post_titulo'
				},
				{
					data: 'cantidad',
					name: 'cantidad'
				},
				{
					data: 'nombre_promo',
					name: 'nombre_promo'
				},
				{
					data: 'envio',
					name: 'envio'
				},
				{
					data: 'precio',
					name: 'precio'
				},
				{
					data: 'tipo_promo',
					name: 'tipo_promo'
				},
				{
					data: 'destacado_modal',
					name: 'destacado_modal',
					orderable: false,
					searchable: false
				},
				{
					data: 'pstatus',
					name: 'pstatus'
				},
				{
					data: 'action',
					name: 'action',
					orderable: false,
					searchable: false
				},
			]
		})
	}


	function openConfirmDesactiva(e) {
		e.preventDefault();
		var id_promo = $(this).attr("data-id-promo");
		swal({
				title: "Se puede revertir",
				text: "Si confirma se desactivará la promoción y no será público",
				icon: "warning",
				buttons: true,
				dangerMode: false,
				buttons: ["Cancelar", "Si, Desactivar ahora"],
			})
			.then((willConfirm) => {
				if (willConfirm) {
					confirmDesactiva(id_promo);
				} else {

				}
			});
	}

	function confirmDesactiva(id_promo) {
		var id_promo = id_promo;
		var data_json = {
			"accion": "confirmDesactiva",
			"datos": {
				"id_promo": id_promo
			}
		}
		ajaxSetup();
		$.ajax({
			data: data_json,
			url: '{{ route("ajax_promo_path") }}',
			type: 'post',
			datatype: 'html',
			beforeSend: function() {},
			success: function(result) {
				$('#tablaPromos').DataTable().destroy();
				muestraTablaPromos();
				swal("Éxito!", "Se ha Desactivado la promoción!", "success");

			},
			error: function(error) {
				console.log(error);
			}
		});
	}

	function openConfirmActiva(e) {
		e.preventDefault();
		var id_promo = $(this).attr("data-id-promo");
		swal({
				title: "Se publicará la promoción",
				text: "Si confirma se publicará la promoción",
				icon: "warning",
				buttons: true,
				dangerMode: false,
				buttons: ["Cancelar", "Si, PUBLICAR ahora"],
			})
			.then((willConfirm) => {
				if (willConfirm) {
					confirmActiva(id_promo);
				} else {

				}
			});
		// dd(id_promo);
	}

	function confirmActiva(id_promo) {
		var id_promo = id_promo;
		var data_json = {
			"accion": "confirmActiva",
			"datos": {
				"id_promo": id_promo
			}
		}
		ajaxSetup();
		$.ajax({
			data: data_json,
			url: '{{ route("ajax_promo_path") }}',
			type: 'post',
			datatype: 'html',
			beforeSend: function() {},
			success: function(result) {
				$('#tablaPromos').DataTable().destroy();
				muestraTablaPromos();
				swal("Genial!", "Se ha Publicado la promoción!", "success");

			},
			error: function(error) {
				console.log(error);
			}
		});
	}

	// Listener para el cambio del switch
	$(document).on('change', '.toggle-destacado', function(e) {
		e.preventDefault();
		var checkbox = $(this);
		var id_promo = checkbox.data('id');
		var isChecked = checkbox.is(':checked');
		var nuevo_estado = isChecked ? 1 : 0;

		var data_json = {
			"accion": "cambiarDestacado",
			"datos": {
				"id_promo": id_promo,
				"nuevo_estado": nuevo_estado
			}
		};

		// Asumo que tienes una función ajaxSetup() configurada para el CSRF
		ajaxSetup();

		$.ajax({
			data: data_json,
			url: '{{ route("ajax_promo_path") }}', // Asegúrate de que esta ruta es la correcta para tu función ajax_promo
			type: 'post',
			dataType: 'json',
			success: function(response) {
				// Si el servidor devuelve success = false (error de validación)
				if (response.success === false) {
					// Revertimos el checkbox visualmente porque el cambio fue rechazado
					checkbox.prop('checked', !isChecked);

					swal({
						title: response.tit_swal,
						text: response.msj_swal,
						icon: response.type_swal,
						button: "Entendido",
					});
				} else {
					// Éxito opcional: puedes mostrar un toast pequeño o nada para no ser intrusivo
					// toastr.success(response.msj_swal); 
				}
			},
			error: function(error) {
				console.log(error);
				// Revertir en caso de error de servidor
				checkbox.prop('checked', !isChecked);
				swal("Error", "Ocurrió un problema de conexión", "error");
			}
		});
	});

	/*
	$(document).on("click", "#activa_mp", activaMercadoPago);
	
	function activaMercadoPago() {
		var id_cotizacion = $(this).attr("data-id-coti");
		if($(this).is(":checked")){
			var st_mp = "si"
		}
		else {
			var st_mp = "no"
		}
		var data_json = {
			"accion":"activaMercadoPago",
			"datos":{
				"id_cotizacion":id_cotizacion,
				"st_mp":st_mp
			}
		}
		ajaxSetup();
		$.ajax({
			data:  data_json,
			url:   '{{ route("path_ajax_cotizador") }}',
			type:  'post',
			datatype:'html',
			beforeSend: function () {
				$(".activado"+id_cotizacion).attr("disabled", "disabled")
			},
			success:  function (result) {
				$('#tablaProductos').DataTable().ajax.reload();
			},
			error: function(error){
			}
		});
	}
	*/
</script>
@stop