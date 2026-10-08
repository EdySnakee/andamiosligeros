@extends('layouts.web_andamios')
@section('css')
	<title>Tienda de Andamios Ligeros Galvanizados | Venta de Andamios en México</title>
	<meta name="description" content="En Andamios Ligeros, nuestra meta es que puedas adquirir andamios seguros, resistentes y 50% más ligeros que cualquier otro. ¡Compra andamios galvanizados fácilmente con nosotros!" />
	<meta name="keywords" content="andamios ligeros, andamios galvanizados, andamios en mexico, andamios, material de construccion, mexico" />
	<meta property="og:image" content="{{ url('web/img/andamios-plegables.jpg') }}" />
	<meta property="og:image:secure_url" content="{{ url('web/img/andamios-plegables.jpg') }}" />
	<meta property="og:title" content="Tienda de Andamios Ligeros Galvanizados | Venta de Andamios en México" />
	<meta property="og:site_name" content="Tienda de Andamios Ligeros Galvanizados | Venta de Andamios en México" />
	<meta property="og:description" content="En Andamios Ligeros, nuestra meta es que puedas adquirir andamios seguros, resistentes y 50% más ligeros que cualquier otro. ¡Compra andamios galvanizados fácilmente con nosotros!" />
	
	<link rel="canonical" href="{{url('/tienda')}}">
	<meta property="og:url" content="{{url('/tienda')}}" />
    @include('web_andamios.includes.css_extra_loco')
	<link rel="stylesheet" href="{{url('loco/css/bootstrap.css')}}">

	<style>
		/* ========================================================
		   ESTILOS GENERALES Y HERO DE LA TIENDA
		   ======================================================== */
		.tienda-wrapper {
			background-color: #f8fafc;
			padding-top: 105px;
			padding-bottom: 80px;
			min-height: 100vh;
			font-family: 'Poppins', sans-serif;
		}

		.tienda-hero-banner {
			background: linear-gradient(135deg, #001f47 0%, #002f6c 55%, #083b80 100%);
			border-radius: 20px;
			color: #ffffff;
			padding: 45px 24px 35px;
			margin-bottom: 35px;
			box-shadow: 0 10px 30px rgba(0, 47, 108, 0.2);
			position: relative;
			overflow: hidden;
		}

		.tienda-hero-banner::after {
			content: "";
			position: absolute;
			top: -40px;
			right: -40px;
			width: 280px;
			height: 280px;
			background: radial-gradient(circle, rgba(255, 187, 1, 0.18) 0%, rgba(255, 187, 1, 0) 70%);
			border-radius: 50%;
			pointer-events: none;
		}

		.tienda-hero-tag {
			display: inline-flex;
			align-items: center;
			gap: 8px;
			background: rgba(255, 187, 1, 0.16);
			color: #ffbb01;
			border: 1px solid rgba(255, 187, 1, 0.35);
			font-size: 12.5px;
			font-weight: 700;
			letter-spacing: 0.6px;
			text-transform: uppercase;
			padding: 6px 16px;
			border-radius: 50px;
			margin-bottom: 14px;
		}

		.tienda-hero-title {
			font-family: 'Montserrat', sans-serif;
			font-size: 32px;
			font-weight: 800;
			color: #ffffff;
			margin-bottom: 12px;
			line-height: 1.25;
			letter-spacing: -0.5px;
		}

		.tienda-hero-subtitle {
			font-size: 15px;
			color: #cbd5e1;
			max-width: 680px;
			margin: 0 auto 30px;
			line-height: 1.6;
		}

		.tienda-trust-row {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
			gap: 14px;
			margin-top: 10px;
		}

		.trust-badge-card {
			background: rgba(255, 255, 255, 0.08);
			backdrop-filter: blur(8px);
			border: 1px solid rgba(255, 255, 255, 0.12);
			padding: 12px 14px;
			border-radius: 12px;
			display: flex;
			align-items: center;
			gap: 12px;
			transition: all 0.25s ease;
		}

		.trust-badge-card:hover {
			background: rgba(255, 255, 255, 0.15);
			transform: translateY(-2px);
		}

		.trust-badge-icon {
			width: 38px;
			height: 38px;
			border-radius: 10px;
			background: #ffbb01;
			color: #002f6c;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 16px;
			flex-shrink: 0;
			box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
		}

		.trust-badge-info strong {
			display: block;
			font-size: 13px;
			color: #ffffff;
			font-weight: 700;
			line-height: 1.3;
		}

		.trust-badge-info span {
			display: block;
			font-size: 11.5px;
			color: #94a3b8;
			line-height: 1.2;
		}

		/* ========================================================
		   BARRA DE FILTROS Y BÚSQUEDA
		   ======================================================== */
		.tienda-filter-card {
			background: #ffffff;
			border-radius: 18px;
			padding: 20px 24px;
			box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
			border: 1px solid #e2e8f0;
			margin-bottom: 30px;
		}

		.filter-row {
			display: flex;
			flex-wrap: wrap;
			align-items: center;
			gap: 15px;
		}

		.filter-row-primary {
			justify-content: space-between;
			margin-bottom: 16px;
		}

		.tienda-search-box {
			position: relative;
			flex: 1;
			min-width: 260px;
		}

		.search-magnifier {
			position: absolute;
			left: 14px;
			top: 50%;
			transform: translateY(-50%);
			color: #94a3b8;
			font-size: 15px;
			pointer-events: none;
		}

		.search-input {
			width: 100%;
			padding: 11px 40px 11px 38px;
			border: 1.5px solid #cbd5e1;
			border-radius: 12px;
			font-size: 14px;
			color: #1e293b;
			background-color: #f8fafc;
			transition: all 0.2s ease;
			outline: none;
		}

		.search-input:focus {
			border-color: #002f6c;
			background-color: #ffffff;
			box-shadow: 0 0 0 3px rgba(0, 47, 108, 0.1);
		}

		.search-clear-btn {
			position: absolute;
			right: 12px;
			top: 50%;
			transform: translateY(-50%);
			background: none;
			border: none;
			color: #94a3b8;
			font-size: 16px;
			cursor: pointer;
			padding: 2px;
			line-height: 1;
		}

		.search-clear-btn:hover {
			color: #ef4444;
		}

		.tienda-sort-box {
			display: flex;
			align-items: center;
			gap: 10px;
		}

		.sort-title {
			font-size: 13px;
			font-weight: 600;
			color: #475569;
			margin: 0;
			white-space: nowrap;
		}

		.tienda-dropdown-select {
			padding: 10px 14px;
			border: 1.5px solid #cbd5e1;
			border-radius: 12px;
			background: #ffffff;
			font-size: 13.5px;
			color: #1e293b;
			font-weight: 500;
			outline: none;
			cursor: pointer;
			transition: border-color 0.2s ease, box-shadow 0.2s ease;
		}

		.tienda-dropdown-select:focus {
			border-color: #002f6c;
			box-shadow: 0 0 0 3px rgba(0, 47, 108, 0.1);
		}

		.filter-row-secondary {
			justify-content: space-between;
			padding-top: 14px;
			border-top: 1px solid #f1f5f9;
		}

		.category-pills-bar {
			display: flex;
			align-items: center;
			flex-wrap: wrap;
			gap: 8px;
		}

		.btn-category-pill {
			background: #f1f5f9;
			border: 1px solid #e2e8f0;
			color: #334155;
			font-size: 13px;
			font-weight: 600;
			padding: 7px 16px;
			border-radius: 30px;
			cursor: pointer;
			transition: all 0.2s ease;
			display: inline-flex;
			align-items: center;
			gap: 6px;
		}

		.btn-category-pill:hover {
			background: #e2e8f0;
			color: #0f172a;
		}

		.btn-category-pill.active {
			background: #002f6c;
			border-color: #002f6c;
			color: #ffffff;
			box-shadow: 0 4px 10px rgba(0, 47, 108, 0.25);
		}

		.filter-actions-right {
			display: flex;
			align-items: center;
			gap: 12px;
			flex-wrap: wrap;
		}

		.model-select-group {
			display: flex;
			align-items: center;
			gap: 8px;
		}

		.model-label {
			font-size: 13px;
			font-weight: 600;
			color: #475569;
			margin: 0;
			white-space: nowrap;
		}

		.btn-reset-filters-pill {
			background: #fee2e2;
			color: #b91c1c;
			border: 1px solid #fecaca;
			font-size: 12.5px;
			font-weight: 600;
			padding: 7px 14px;
			border-radius: 10px;
			cursor: pointer;
			transition: all 0.2s ease;
			display: inline-flex;
			align-items: center;
			gap: 6px;
		}

		.btn-reset-filters-pill:hover {
			background: #fecaca;
			color: #991b1b;
		}

		.filter-status-bar {
			margin-top: 14px;
			display: flex;
			align-items: center;
			justify-content: flex-start;
		}

		.results-counter-pill {
			font-size: 12.5px;
			font-weight: 500;
			color: #64748b;
			background: #f8fafc;
			padding: 4px 12px;
			border-radius: 20px;
			border: 1px solid #e2e8f0;
		}

		.results-counter-pill strong {
			color: #002f6c;
			font-weight: 700;
		}

		/* ========================================================
		   TARJETAS DE PRODUCTO MODERNAS
		   ======================================================== */
		.product-modern-card {
			background: #ffffff;
			border-radius: 18px;
			border: 1px solid #e2e8f0;
			overflow: hidden;
			box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04);
			transition: transform 0.28s ease, box-shadow 0.28s ease, border-color 0.28s ease;
			display: flex;
			flex-direction: column;
			width: 100%;
			position: relative;
		}

		.product-modern-card:hover {
			transform: translateY(-6px);
			box-shadow: 0 16px 32px rgba(0, 47, 108, 0.12);
			border-color: #cbd5e1;
		}

		.product-modern-card.is-expired {
			opacity: 0.65;
		}

		.product-card-badges {
			position: absolute;
			top: 14px;
			left: 14px;
			right: 14px;
			display: flex;
			justify-content: space-between;
			align-items: flex-start;
			z-index: 3;
			pointer-events: none;
		}

		.p-badge {
			font-size: 11px;
			font-weight: 800;
			letter-spacing: 0.5px;
			text-transform: uppercase;
			padding: 5px 10px;
			border-radius: 8px;
			display: inline-flex;
			align-items: center;
			gap: 4px;
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
		}

		.badge-bestseller {
			background: #ffbb01;
			color: #002f6c;
		}

		.badge-discount {
			background: #e11d48;
			color: #ffffff;
			margin-left: auto;
		}

		.badge-expired {
			background: #64748b;
			color: #ffffff;
		}

		.product-card-image-wrap {
			display: flex;
			align-items: center;
			justify-content: center;
			height: 260px;
			background: #f8fafc;
			padding: 20px;
			position: relative;
			overflow: hidden;
			text-decoration: none !important;
		}

		.product-card-img {
			max-height: 210px;
			max-width: 100%;
			object-fit: contain;
			transition: transform 0.35s ease;
		}

		.product-modern-card:hover .product-card-img {
			transform: scale(1.05);
		}

		.product-card-body {
			padding: 20px;
			display: flex;
			flex-direction: column;
			flex-grow: 1;
		}

		.product-card-meta {
			display: flex;
			align-items: center;
			gap: 8px;
			margin-bottom: 8px;
			flex-wrap: wrap;
		}

		.meta-cat {
			font-size: 11px;
			font-weight: 700;
			letter-spacing: 0.5px;
			color: #0284c7;
			background: #e0f2fe;
			padding: 3px 8px;
			border-radius: 6px;
		}

		.meta-mod {
			font-size: 11.5px;
			color: #64748b;
			font-weight: 500;
		}

		.product-card-heading {
			font-family: 'Montserrat', sans-serif;
			font-size: 16px;
			font-weight: 700;
			line-height: 1.4;
			margin-bottom: 12px;
			min-height: 44px;
		}

		.product-card-heading a {
			color: #0f172a;
			text-decoration: none;
			transition: color 0.2s ease;
		}

		.product-card-heading a:hover {
			color: #002f6c;
			text-decoration: none;
		}

		.product-card-pricing {
			display: flex;
			align-items: baseline;
			gap: 10px;
			margin-bottom: 10px;
		}

		.price-current {
			font-family: 'Montserrat', sans-serif;
			font-size: 22px;
			font-weight: 800;
			color: #002f6c;
			line-height: 1;
		}

		.price-currency {
			font-size: 17px;
			font-weight: 700;
		}

		.price-tax-note {
			font-size: 12px;
			font-weight: 600;
			color: #64748b;
			margin-left: 2px;
		}

		.price-original {
			font-size: 13.5px;
			color: #94a3b8;
			text-decoration: line-through;
			font-weight: 500;
		}

		.product-card-trust-feature {
			font-size: 12px;
			color: #166534;
			background: #f0fdf4;
			padding: 4px 10px;
			border-radius: 6px;
			display: inline-flex;
			align-items: center;
			gap: 5px;
			margin-bottom: 16px;
			font-weight: 500;
			width: fit-content;
		}

		.product-card-form {
			margin-top: auto;
		}

		.product-card-actions {
			display: flex;
			align-items: center;
			gap: 10px;
		}

		.product-stepper {
			display: flex;
			align-items: center;
			border: 1.5px solid #cbd5e1;
			border-radius: 10px;
			overflow: hidden;
			background: #f8fafc;
			height: 42px;
			flex-shrink: 0;
		}

		.btn-stepper-decrement,
		.btn-stepper-increment {
			width: 32px;
			height: 100%;
			background: none;
			border: none;
			font-size: 16px;
			font-weight: 700;
			color: #334155;
			cursor: pointer;
			transition: background 0.15s ease, color 0.15s ease;
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 0;
		}

		.btn-stepper-decrement:hover,
		.btn-stepper-increment:hover {
			background: #e2e8f0;
			color: #002f6c;
		}

		.stepper-count-input {
			width: 36px;
			border: none;
			background: transparent;
			text-align: center;
			font-size: 14px;
			font-weight: 700;
			color: #0f172a;
			outline: none;
			-moz-appearance: textfield;
		}

		.stepper-count-input::-webkit-outer-spin-button,
		.stepper-count-input::-webkit-inner-spin-button {
			-webkit-appearance: none;
			margin: 0;
		}

		.btn-card-add-to-cart {
			flex: 1;
			height: 42px;
			background: #ffbb01;
			color: #002f6c;
			border: none;
			border-radius: 10px;
			font-size: 14px;
			font-weight: 700;
			letter-spacing: 0.3px;
			cursor: pointer;
			display: flex;
			align-items: center;
			justify-content: center;
			gap: 8px;
			transition: all 0.2s ease;
			box-shadow: 0 2px 6px rgba(255, 187, 1, 0.4);
		}

		.btn-card-add-to-cart:hover {
			background: #e5a700;
			color: #002f6c;
			transform: translateY(-1px);
			box-shadow: 0 4px 12px rgba(255, 187, 1, 0.5);
		}

		.btn-card-add-to-cart:active {
			transform: translateY(0);
		}

		.product-card-specs-link {
			text-align: center;
			margin-top: 12px;
			padding-top: 10px;
			border-top: 1px solid #f1f5f9;
		}

		.product-card-specs-link a {
			font-size: 12px;
			color: #64748b;
			text-decoration: none;
			font-weight: 600;
			transition: color 0.2s ease;
			display: inline-flex;
			align-items: center;
			gap: 4px;
		}

		.product-card-specs-link a:hover {
			color: #002f6c;
			text-decoration: none;
		}

		/* ========================================================
		   EMPTY STATE & SPINNERS
		   ======================================================== */
		.tienda-empty-state-box {
			background: #ffffff;
			border-radius: 18px;
			padding: 50px 24px;
			border: 1px solid #e2e8f0;
			max-width: 520px;
			margin: 0 auto;
			box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
		}

		.empty-state-icon {
			width: 72px;
			height: 72px;
			border-radius: 50%;
			background: #f1f5f9;
			color: #94a3b8;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 28px;
			margin: 0 auto 18px;
		}

		.empty-state-title {
			font-family: 'Montserrat', sans-serif;
			font-size: 20px;
			font-weight: 700;
			color: #0f172a;
			margin-bottom: 8px;
		}

		.empty-state-subtitle {
			font-size: 14px;
			color: #64748b;
			margin-bottom: 22px;
			line-height: 1.5;
		}

		.btn-empty-state-reset {
			background: #002f6c;
			color: #ffffff;
			border: none;
			padding: 11px 24px;
			border-radius: 10px;
			font-size: 13.5px;
			font-weight: 600;
			cursor: pointer;
			transition: all 0.2s ease;
			display: inline-flex;
			align-items: center;
			gap: 8px;
		}

		.btn-empty-state-reset:hover {
			background: #001f47;
			transform: translateY(-1px);
		}

		.tienda-loading-spinner {
			padding: 50px 0;
			color: #002f6c;
		}

		/* Responsive tweaks */
		@media (max-width: 768px) {
			.tienda-wrapper {
				padding-top: 85px;
			}
			.tienda-hero-banner {
				padding: 30px 18px 25px;
			}
			.tienda-hero-title {
				font-size: 24px;
			}
			.tienda-hero-subtitle {
				font-size: 13.5px;
			}
			.tienda-trust-row {
				grid-template-columns: 1fr;
			}
			.filter-row-secondary {
				flex-direction: column;
				align-items: flex-start;
			}
			.filter-actions-right {
				width: 100%;
				justify-content: space-between;
			}
			.model-select-group {
				width: 100%;
			}
			.model-dropdown {
				flex: 1;
			}
		}
	</style>
@stop

@section('content')
	<main class="page-normal">
	    @include('web_andamios.tienda.contenido_tienda')
	</main>
@stop

@section('js')
    @include('web_andamios.includes.scripts_funciones')
	<script>
		var searchTimeout = null;

		$(document).ready(function() {
			actualizaProductos();
		});

		/* ----------------------------------------------------
		   INTERACCIONES CON EL BUSCADOR Y FILTROS
		   ---------------------------------------------------- */
		// Buscador con debounce (350ms)
		$(document).on("input", "#store_search", function() {
			var query = $(this).val();
			if (query.trim().length > 0) {
				$("#clear_search").fadeIn(150);
			} else {
				$("#clear_search").fadeOut(150);
			}
			clearTimeout(searchTimeout);
			searchTimeout = setTimeout(function() {
				actualizaProductos();
			}, 350);
		});

		// Limpiar búsqueda
		$(document).on("click", "#clear_search", function() {
			$("#store_search").val("");
			$(this).fadeOut(150);
			actualizaProductos();
		});

		// Enter en el buscador
		$(document).on("keydown", "#store_search", function(e) {
			if (e.keyCode === 13) {
				e.preventDefault();
				clearTimeout(searchTimeout);
				actualizaProductos();
			}
		});

		// Pastillas (Pills) de Categoría
		$(document).on("click", ".btn-category-pill", function(e) {
			e.preventDefault();
			$(".btn-category-pill").removeClass("active");
			$(this).addClass("active");
			var cat = $(this).data("category") || "";
			$("#filter_categoria").val(cat);
			actualizaProductos();
		});

		// Cambio de Modelo
		$(document).on("change", "#filter_model", function() {
			actualizaProductos();
		});

		// Cambio de Orden
		$(document).on("change", "#filter_orden", function() {
			actualizaProductos();
		});

		// Restablecer todos los filtros
		function resetAllFilters() {
			$("#store_search").val("");
			$("#clear_search").hide();
			$(".btn-category-pill").removeClass("active");
			$('.btn-category-pill[data-category=""]').addClass("active");
			$("#filter_categoria").val("");
			$("#filter_model").val("");
			$("#filter_orden").val("destacados");
			actualizaProductos();
		}

		/* ----------------------------------------------------
		   STEPPER DE CANTIDAD EN TARJETA
		   ---------------------------------------------------- */
		$(document).on("click", ".btn-stepper-decrement", function(e) {
			e.preventDefault();
			var $input = $(this).siblings(".stepper-count-input");
			var val = parseInt($input.val(), 10) || 1;
			if (val > 1) {
				$input.val(val - 1);
			}
		});

		$(document).on("click", ".btn-stepper-increment", function(e) {
			e.preventDefault();
			var $input = $(this).siblings(".stepper-count-input");
			var val = parseInt($input.val(), 10) || 1;
			if (val < 99) {
				$input.val(val + 1);
			}
		});

		/* ----------------------------------------------------
		   PETICIÓN AJAX PARA ACTUALIZAR CATÁLOGO
		   ---------------------------------------------------- */
		function actualizaProductos() {
			var categoria_activa = $("#filter_categoria").val() || "";
			var modelo_activo = $("#filter_model").val() || "";
			var busqueda = $("#store_search").val() || "";
			var orden = $("#filter_orden").val() || "destacados";

			// Mostrar u ocultar botón de limpiar filtros si hay algún filtro activo
			if (categoria_activa !== "" || modelo_activo !== "" || busqueda.trim() !== "" || orden !== "destacados") {
				$("#btn_reset_filters").fadeIn(200);
			} else {
				$("#btn_reset_filters").fadeOut(200);
			}

			var data_json = {
				"accion": "actualizaProductos",
				"datos": {
					"categoria_activa": categoria_activa,
					"modelo_activo": modelo_activo,
					"busqueda": busqueda.trim(),
					"orden": orden
				}
			};

			ajaxSetup();
			$.ajax({
				data: data_json,
				url: '{{ route("path_ajax_tienda_web") }}',
				type: 'post',
				datatype: 'html',
				beforeSend: function () {
					$("#list-products").html(
						'<div class="col-12 text-center">' +
							'<div class="tienda-loading-spinner">' +
								'<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>' +
								'<p class="mt-3 text-muted font-weight-bold" style="font-size:14px;">Actualizando catálogo...</p>' +
							'</div>' +
						'</div>'
					);
				},
				success: function (result) {
					$("#list-products").html(result);

					// Actualizar contador de productos encontrados
					var count = $("#loaded_products_count").data("count");
					if (typeof count !== "undefined") {
						if (count === 0) {
							$("#products_counter").html('<i class="fa fa-cubes"></i> <strong>0</strong> productos encontrados');
						} else if (count === 1) {
							$("#products_counter").html('<i class="fa fa-cubes"></i> Mostrando <strong>1</strong> producto');
						} else {
							$("#products_counter").html('<i class="fa fa-cubes"></i> Mostrando <strong>' + count + '</strong> productos');
						}
					}
				},
				error: function(error){
					console.error("Error al actualizar productos:", error);
					$("#list-products").html(
						'<div class="col-12 text-center py-5 text-danger">' +
							'<i class="fa fa-exclamation-circle fa-3x mb-3"></i>' +
							'<p>Ocurrió un problema al cargar los productos. Por favor intenta recargar la página.</p>' +
						'</div>'
					);
				}
			});
		}
	</script>
@stop
