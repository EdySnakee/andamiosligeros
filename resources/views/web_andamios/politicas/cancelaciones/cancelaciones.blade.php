@extends('layouts.web_andamios')
@section('css')
<!-- Title -->
<title>Políticas de cancelación, tiempos de entrega e incidencias | Andamios Ligeros</title>
<meta name="description" content="Conoce las políticas de cancelación, tiempos de producción, entrega e incidencias en Andamios Ligeros. Información clara y transparente antes de tu compra.">
<meta name="author" content="Eureka">
<meta name="keywords" content="políticas de cancelación, tiempos de entrega, producción, andamios ligeros, incidencias, devoluciones">

<meta property="og:description" content="Conoce las políticas de cancelación, tiempos de producción, entrega e incidencias en Andamios Ligeros.">
<meta property="og:title" content="Políticas de cancelación, tiempos de entrega e incidencias | Andamios Ligeros">
<meta name="twitter:description" content="Conoce las políticas de cancelación, tiempos de producción, entrega e incidencias en Andamios Ligeros.">
<meta name="twitter:title" content="Políticas de cancelación, tiempos de entrega e incidencias | Andamios Ligeros">

<meta name="twitter:card" content="summary">
<meta property="og:type" content="website" />
@include('web_andamios.includes.css_extra_loco')
<link rel="stylesheet" href="{{url('loco/css/bootstrap.css')}}">
<script>
	var URL_BASE_WEB = '<?php echo url("/"); ?>';
</script>

<style>
	/* ====== Políticas de Cancelación ====== */
	.tyc {
		--tyc-accent: #1f7a3d;
		--tyc-accent-soft: #eaf4ed;
		--tyc-ink: #1d2521;
		--tyc-muted: #5b6760;
		--tyc-line: #dde3df;
		--tyc-bg-soft: #f6f8f7;
		color: var(--tyc-ink);
		padding: 2.5rem 0 4rem;
	}

	html { scroll-behavior: smooth; }
	@media (prefers-reduced-motion: reduce) { html { scroll-behavior: auto; } }

	/* Encabezado */
	.tyc-head {
		border-bottom: 1px solid var(--tyc-line);
		padding-bottom: 1.5rem;
		margin-bottom: 2.5rem;
	}
	.tyc-head h1 {
		margin: 0 0 .5rem;
		line-height: 1.2;
	}
	.tyc-updated {
		margin: 0;
		color: var(--tyc-muted);
		font-size: .95rem;
	}

	/* Estructura: índice + contenido */
	.tyc-layout {
		display: grid;
		grid-template-columns: 1fr;
		gap: 2rem;
	}
	@media (min-width: 992px) {
		.tyc-layout {
			grid-template-columns: 270px minmax(0, 1fr);
			gap: 3.5rem;
			align-items: start;
		}
	}

	/* Índice */
	.tyc-toc {
		background: var(--tyc-bg-soft);
		border-radius: 6px;
		padding: 1.25rem 1.25rem 1rem;
		font-size: .9rem;
	}
	@media (min-width: 992px) {
		.tyc-toc {
			position: sticky;
			top: 100px;
			max-height: calc(100vh - 130px);
			overflow-y: auto;
			background: transparent;
			border-left: 2px solid var(--tyc-line);
			border-radius: 0;
			padding: .25rem 0 .25rem 1.25rem;
		}
	}
	.tyc-toc-title {
		margin: 0 0 .75rem;
		font-weight: 700;
		font-size: 1rem;
	}
	.tyc-toc ol {
		list-style: none;
		margin: 0;
		padding: 0;
	}
	.tyc-toc li { break-inside: avoid; margin: 0 0 .1rem; }
	.tyc-toc a {
		display: block;
		padding: .35rem 0;
		color: var(--tyc-muted);
		text-decoration: none;
		line-height: 1.35;
	}
	.tyc-toc a:hover,
	.tyc-toc a:focus-visible { color: var(--tyc-accent); text-decoration: underline; }

	/* Contenido */
	.tyc-body {
		max-width: 72ch;
		font-size: 1.0625rem;
		line-height: 1.75;
		text-align: left;
	}
	.tyc-intro { color: var(--tyc-muted); }
	.tyc-intro p:first-child { color: var(--tyc-ink); font-size: 1.125rem; }

	.tyc-section {
		margin-top: 2.75rem;
		padding-top: 2rem;
		border-top: 1px solid var(--tyc-line);
		scroll-margin-top: 100px;
	}
	.tyc-section h2 {
		display: flex;
		align-items: baseline;
		gap: .75rem;
		margin: 0 0 1rem;
		font-size: 1.35rem;
		font-weight: 700;
		line-height: 1.3;
		color: var(--tyc-ink);
	}
	.tyc-num {
		flex: 0 0 auto;
		min-width: 1.75rem;
		color: var(--tyc-accent);
		font-variant-numeric: tabular-nums;
	}
	.tyc-body p { margin: 0 0 1rem; }
	.tyc-body p:last-child { margin-bottom: 0; }

	.tyc-body ul {
		list-style: disc;
		margin: 0 0 1.25rem 1.5rem;
		padding: 0;
	}
	.tyc-body ul li {
		margin-bottom: .6rem;
		line-height: 1.6;
	}

	/* Aviso destacado */
	.tyc-callout {
		margin: 1.25rem 0;
		padding: 1rem 1.25rem;
		background: var(--tyc-accent-soft);
		border-left: 4px solid var(--tyc-accent);
		border-radius: 0 6px 6px 0;
		font-weight: 500;
	}
	.tyc-callout p { margin: 0; }

	/* Contacto */
	.tyc-contact {
		margin-top: 1.5rem;
		padding: 1.25rem 1.5rem;
		background: var(--tyc-bg-soft);
		border-radius: 6px;
		line-height: 1.7;
	}
	.tyc-contact strong { display: block; margin-bottom: .25rem; }
	.tyc-contact a { color: var(--tyc-accent); font-weight: 600; }

	.tyc-closing {
		margin-top: 1.75rem !important;
		padding-top: 1.25rem;
		border-top: 1px dashed var(--tyc-line);
		font-weight: 500;
		color: var(--tyc-ink);
	}

	.tyc a:focus-visible,
	.tyc-toc a:focus-visible {
		outline: 3px solid var(--tyc-accent);
		outline-offset: 2px;
		border-radius: 2px;
	}

	@media (max-width: 575px) {
		.tyc { padding-top: 1.5rem; }
		.tyc-body { font-size: 1rem; }
		.tyc-section h2 { font-size: 1.15rem; }
	}

	@media print {
		.tyc-toc { display: none; }
		.tyc-layout { display: block; }
		.tyc-section { break-inside: avoid; }
	}
</style>
@stop

@section('content')
	<main class="page-normal">
		<div class="container-md cont-princ-product tyc">

			<header class="tyc-head">
				<h1 class="titulofondoverde">Políticas de cancelación, tiempos de entrega e incidencias</h1>
				<p class="tyc-updated">Políticas de compra y cancelación · Última actualización: octubre de 2026</p>
			</header>

			<div class="tyc-layout">

				<nav class="tyc-toc" aria-label="Índice de secciones">
					<p class="tyc-toc-title">Contenido</p>
					<ol>
						<li><a href="#confirmacion">1. Confirmación de pedidos y cancelaciones</a></li>
						<li><a href="#tiempos-produccion">2. Tiempos de producción y preparación</a></li>
						<li><a href="#inicio-conclusion">3. Inicio y conclusión de producción</a></li>
						<li><a href="#retrasos-fabricacion">4. Retrasos en la fabricación</a></li>
						<li><a href="#retrasos-paqueteria">5. Retrasos de paquetería</a></li>
						<li><a href="#productos-agotados">6. Productos agotados o imposibilidad</a></li>
						<li><a href="#devoluciones-reembolsos">7. Devoluciones y reembolsos</a></li>
						<li><a href="#atencion-cliente">8. Atención al cliente</a></li>
					</ol>
				</nav>

				<article class="tyc-body">

					<div class="tyc-intro">
						<p>En Andamios Ligeros trabajamos para ofrecer productos de calidad y cumplir con los compromisos adquiridos con nuestros clientes. Debido a que algunos productos requieren procesos de fabricación, preparación y coordinación logística, es importante que conozca las siguientes políticas antes de realizar su compra.</p>
					</div>

					<section class="tyc-section" id="confirmacion">
						<h2><span class="tyc-num">1.</span> Confirmación de pedidos y cancelaciones</h2>
						<p>Una vez confirmado el pago y comenzado el proceso de fabricación, preparación o adquisición de los productos, no se aceptarán cancelaciones por decisión unilateral del cliente, salvo en los casos en que la legislación aplicable otorgue ese derecho.</p>
						<p>Antes de confirmar su compra, le recomendamos verificar cuidadosamente las características, cantidades, especificaciones técnicas y condiciones de entrega de los productos solicitados.</p>
						<p>Si tiene alguna duda sobre su pedido, nuestro equipo de atención al cliente podrá orientarle antes de finalizar la compra.</p>
					</section>

					<section class="tyc-section" id="tiempos-produccion">
						<h2><span class="tyc-num">2.</span> Tiempos de producción y preparación</h2>
						<p>Los tiempos de producción o preparación serán informados por nuestro asesor de ventas al momento de realizar la cotización o confirmar el pedido.</p>
						<p>Estos tiempos son estimados y pueden variar por circunstancias operativas, entre ellas:</p>
						<ul>
							<li><strong>Alto volumen de pedidos:</strong> un incremento extraordinario en la demanda puede extender los tiempos habituales de fabricación y preparación.</li>
							<li><strong>Fallas técnicas o mantenimiento de maquinaria:</strong> las averías, reparaciones o situaciones imprevistas en nuestros equipos de producción pueden ocasionar retrasos.</li>
							<li><strong>Disponibilidad de materiales e insumos:</strong> circunstancias relacionadas con el suministro de materias primas pueden afectar el calendario de producción.</li>
							<li><strong>Otras situaciones extraordinarias:</strong> acontecimientos ajenos a nuestra operación habitual que afecten directamente la fabricación o preparación de los productos.</li>
						</ul>
						<p>En caso de presentarse una situación que afecte significativamente el tiempo estimado de entrega, procuraremos informar al cliente sobre el estado de su pedido y, cuando sea posible, comunicarle una nueva fecha estimada.</p>
					</section>

					<section class="tyc-section" id="inicio-conclusion">
						<h2><span class="tyc-num">3.</span> Inicio y conclusión del tiempo de producción</h2>
						<p>El tiempo de producción comenzará a contabilizarse una vez que el pago haya sido confirmado y acreditado, lo cual se verificará en un plazo máximo de 48 horas hábiles, salvo que existan circunstancias ajenas a nuestro control que impidan dicha verificación.</p>
						<p>El periodo de producción o preparación concluirá cuando la mercancía sea entregada a la empresa de paquetería y se genere la guía de envío correspondiente.</p>
						<p>La generación de la guía no significa necesariamente que el paquete haya comenzado su recorrido. El tránsito y la entrega posterior estarán sujetos a los tiempos y condiciones de la empresa transportista.</p>
					</section>

					<section class="tyc-section" id="retrasos-fabricacion">
						<h2><span class="tyc-num">4.</span> Retrasos en la fabricación</h2>
						<p>Si el pedido experimenta un retraso debido a un alto volumen de producción, una falla de maquinaria u otra circunstancia operativa extraordinaria, mantendremos comunicación con el cliente, en la medida de lo posible, para informarle sobre el avance y la nueva estimación de entrega.</p>
						<p>Los retrasos no generan automáticamente la cancelación del pedido ni una devolución inmediata del importe pagado. No obstante, se respetarán los derechos que correspondan al consumidor conforme a la legislación aplicable y a las condiciones particulares de la compra.</p>
						<p>Nuestro objetivo será concluir la fabricación y entregar el pedido en cuanto las condiciones operativas lo permitan.</p>
					</section>

					<section class="tyc-section" id="retrasos-paqueteria">
						<h2><span class="tyc-num">5.</span> Retrasos atribuibles a la empresa de paquetería</h2>
						<p>Una vez entregada la mercancía a la empresa transportista y emitida la guía correspondiente, los tiempos de tránsito estarán sujetos a la operación de la paquetería.</p>
						<p>Pueden presentarse retrasos por saturación logística, condiciones climáticas, cierres de carreteras, incidencias en las rutas, restricciones operativas u otras circunstancias que afecten el transporte.</p>
						<p>En estos casos, Andamios Ligeros brindará orientación al cliente y, cuando corresponda, apoyo en el seguimiento del envío ante la empresa transportista.</p>
						<p>Los retrasos atribuibles a la paquetería no generan automáticamente la cancelación del pedido ni una devolución de efectivo. Esto se entiende sin perjuicio de los derechos del consumidor y de las responsabilidades que legalmente correspondan a cada parte.</p>
					</section>

					<section class="tyc-section" id="productos-agotados">
						<h2><span class="tyc-num">6.</span> Productos agotados o imposibilidad de cumplir con el pedido</h2>
						<p>Si, después de confirmar una compra, se presenta una circunstancia que nos impida fabricar, conseguir o suministrar el producto solicitado, nos comunicaremos con el cliente para informarle de la situación.</p>
						<p>En estos casos, se le comunicarán las alternativas disponibles, que podrán incluir, según corresponda, una solución acordada, la sustitución del producto por otro equivalente con autorización del cliente o el reembolso que legalmente proceda.</p>
						<p>No se sustituirá un producto por otro sin informar previamente al cliente y obtener su aceptación cuando esta sea necesaria.</p>
					</section>

					<section class="tyc-section" id="devoluciones-reembolsos">
						<h2><span class="tyc-num">7.</span> Devoluciones y reembolsos</h2>
						<p>Las solicitudes relacionadas con cancelaciones, devoluciones o reembolsos serán evaluadas de acuerdo con las circunstancias de cada caso, las condiciones de la compra y la legislación aplicable.</p>
						<p>La presente política no limita los derechos que correspondan al consumidor en los supuestos previstos por la ley, incluidos aquellos relacionados con incumplimientos atribuibles al proveedor, productos defectuosos o entregas que no correspondan a lo contratado.</p>
						<p>Cuando legalmente proceda un reembolso, se informará al cliente sobre el procedimiento correspondiente.</p>
						<p>Los cupones de descuento o saldos para futuras compras podrán ofrecerse como alternativas comerciales, pero no sustituirán un reembolso cuando este sea legalmente exigible.</p>
					</section>

					<section class="tyc-section" id="atencion-cliente">
						<h2><span class="tyc-num">8.</span> Atención al cliente</h2>
						<p>Para consultar el estado de un pedido o reportar alguna incidencia, el cliente podrá comunicarse con nuestro equipo de atención al cliente mediante los canales oficiales de Andamios Ligeros.</p>
						<p>Para agilizar la atención, recomendamos proporcionar el número de pedido o cotización, el comprobante de pago y, cuando corresponda, la guía de envío.</p>

						<div class="tyc-contact">
							<strong>Andamios Ligeros</strong>
							Teléfono / WhatsApp: <a href="tel:5519484708">55-1948-4708</a><br>
							Correo electrónico: <a href="mailto:ventas@andamiosligeros.com">ventas@andamiosligeros.com</a><br>
							Sitio web: <a href="https://andamiosligeros.com">andamiosligeros.com</a>
						</div>

						<p class="tyc-closing">Agradecemos su confianza y comprensión. En Andamios Ligeros trabajamos continuamente para mejorar nuestros procesos de fabricación, atención y entrega.</p>
					</section>

				</article>
			</div>
		</div>
	</main>
@stop
@section('js')
@stop