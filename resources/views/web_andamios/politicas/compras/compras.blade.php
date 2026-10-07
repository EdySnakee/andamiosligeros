
@extends('layouts.web_andamios')
@section('css')
<!-- Title -->
<title>Términos y Condiciones | Andamios Ligeros</title>
<meta name="description" content="Términos y condiciones de compra en andamiosligeros.com: precios, pagos con Openpay, envíos, garantías y devoluciones.">
<meta name="author" content="Eureka">
<meta name="keywords" content="">
 
<meta property="og:description" content="Términos y condiciones de compra en andamiosligeros.com.">
<meta property="og:title" content="Términos y Condiciones | Andamios Ligeros">
<meta name="twitter:description" content="Términos y condiciones de compra en andamiosligeros.com.">
<meta name="twitter:title" content="Términos y Condiciones | Andamios Ligeros">
 
<meta name="twitter:card" content="summary">
<meta property="og:type" content="website" />
@include('web_andamios.includes.css_extra_loco')
<link rel="stylesheet" href="{{url('loco/css/bootstrap.css')}}">
<script>
	var URL_BASE_WEB = '<?php echo url("/"); ?>';
</script>
 
<style>
	/* ====== Términos y condiciones ======
	   Ajusta aquí los colores de marca. */
	.tyc {
		--tyc-accent: #1f7a3d;        /* verde de marca (cámbialo por el de tu sitio) */
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
		line-height: 1.15;
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
			grid-template-columns: 250px minmax(0, 1fr);
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
		columns: 2;
		column-gap: 1.5rem;
	}
	@media (min-width: 992px) { .tyc-toc ol { columns: 1; } }
	.tyc-toc li { break-inside: avoid; margin: 0 0 .1rem; }
	.tyc-toc a {
		display: block;
		padding: .3rem 0;
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
	.tyc-intro p:first-child { color: var(--tyc-ink); font-size: 1.15rem; }
 
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
		font-size: 1.4rem;
		font-weight: 700;
		line-height: 1.3;
		color: var(--tyc-ink);
	}
	.tyc-num {
		flex: 0 0 auto;
		min-width: 2.1rem;
		color: var(--tyc-accent);
		font-variant-numeric: tabular-nums;
	}
	.tyc-body p { margin: 0 0 1rem; }
	.tyc-body p:last-child { margin-bottom: 0; }
 
	/* Aviso destacado (pagos con Openpay) */
	.tyc-callout {
		margin: 1.25rem 0;
		padding: 1rem 1.25rem;
		background: var(--tyc-accent-soft);
		border-left: 4px solid var(--tyc-accent);
		border-radius: 0 6px 6px 0;
		font-weight: 600;
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
 
	.tyc a:focus-visible,
	.tyc-toc a:focus-visible {
		outline: 3px solid var(--tyc-accent);
		outline-offset: 2px;
		border-radius: 2px;
	}
 
	@media (max-width: 575px) {
		.tyc { padding-top: 1.5rem; }
		.tyc-toc ol { columns: 1; }
		.tyc-body { font-size: 1rem; }
		.tyc-section h2 { font-size: 1.2rem; }
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
				<h1 class="titulofondoverde">Términos y Condiciones</h1>
				<p class="tyc-updated">Términos y condiciones · Última actualización: octubre de 2026</p>
			</header>
 
			<div class="tyc-layout">
 
				<nav class="tyc-toc" aria-label="Índice de secciones">
					<p class="tyc-toc-title">Contenido</p>
					<ol>
						<li><a href="#identificacion">1. Identificación</a></li>
						<li><a href="#productos">2. Información de los productos</a></li>
						<li><a href="#precios">3. Precios</a></li>
						<li><a href="#disponibilidad">4. Disponibilidad</a></li>
						<li><a href="#pagos">5. Formas de pago</a></li>
						<li><a href="#confirmacion">6. Confirmación de compra</a></li>
						<li><a href="#produccion">7. Producción y entrega</a></li>
						<li><a href="#envios">8. Envíos</a></li>
						<li><a href="#inspeccion">9. Inspección de la mercancía</a></li>
						<li><a href="#cancelaciones">10. Cancelaciones y devoluciones</a></li>
						<li><a href="#garantias">11. Garantías</a></li>
						<li><a href="#uso">12. Uso adecuado</a></li>
						<li><a href="#propiedad">13. Propiedad intelectual</a></li>
						<li><a href="#modificaciones">14. Modificaciones</a></li>
						<li><a href="#aceptacion">15. Aceptación y contacto</a></li>
					</ol>
				</nav>
 
				<article class="tyc-body">
 
					<div class="tyc-intro">
						<p>Bienvenido al sitio web de Andamios Ligeros. Al acceder, navegar, utilizar este sitio web o realizar una compra a través de andamiosligeros.com, el usuario acepta los presentes Términos y Condiciones.</p>
						<p>Si el usuario no está de acuerdo con alguno de estos términos, deberá abstenerse de utilizar el sitio web o realizar compras a través del mismo.</p>
					</div>
 
					<section class="tyc-section" id="identificacion">
						<h2><span class="tyc-num">1.</span> Identificación</h2>
						<p>El presente sitio web es operado por Andamios Ligeros, dedicado a la comercialización de andamios, equipos y accesorios para trabajos en altura y construcción.</p>
						<p>Los productos, características, precios, promociones y condiciones publicados en el sitio podrán estar sujetos a disponibilidad y actualización.</p>
					</section>
 
					<section class="tyc-section" id="productos">
						<h2><span class="tyc-num">2.</span> Información de los productos</h2>
						<p>Andamios Ligeros procura que la información, imágenes, características técnicas y precios publicados en el sitio sean correctos y estén actualizados.</p>
						<p>Las imágenes mostradas son de carácter ilustrativo y pueden presentar variaciones respecto al producto final, particularmente en acabados, accesorios, colores o configuraciones.</p>
						<p>Las características técnicas de cada producto deberán consultarse en su respectiva ficha técnica o directamente con nuestro equipo de ventas antes de realizar una compra cuando el producto vaya a utilizarse en condiciones específicas de trabajo.</p>
					</section>
 
					<section class="tyc-section" id="precios">
						<h2><span class="tyc-num">3.</span> Precios</h2>
						<p>Todos los precios publicados en el sitio se expresan en pesos mexicanos (MXN).</p>
						<p>Salvo que se indique expresamente lo contrario, los precios publicados no incluyen IVA.</p>
						<p>Los costos de envío podrán variar dependiendo del producto, cantidad, destino, cobertura de la empresa transportista y demás condiciones logísticas aplicables.</p>
						<p>Andamios Ligeros se reserva el derecho de modificar precios, promociones y condiciones comerciales sin previo aviso. Dichas modificaciones no afectarán las compras que hayan sido confirmadas y pagadas previamente, salvo que exista alguna condición expresamente comunicada al cliente.</p>
					</section>
 
					<section class="tyc-section" id="disponibilidad">
						<h2><span class="tyc-num">4.</span> Disponibilidad</h2>
						<p>La disponibilidad mostrada en el sitio está sujeta a existencia física y capacidad de producción.</p>
						<p>La realización de un pedido no implica necesariamente la confirmación definitiva de disponibilidad hasta que el pago haya sido validado y nuestro personal haya confirmado la orden.</p>
						<p>En caso de que un producto no se encuentre disponible, nuestro equipo se pondrá en contacto con el cliente para informar las alternativas disponibles, tiempos estimados o, en su caso, las condiciones aplicables para la cancelación y devolución.</p>
					</section>
 
					<section class="tyc-section" id="pagos">
						<h2><span class="tyc-num">5.</span> Formas de pago</h2>
						<p>Las compras podrán realizarse mediante los métodos de pago habilitados en el sitio web y aquellos que sean indicados por nuestro equipo de ventas.</p>
						<div class="tyc-callout">
							<p>Las transacciones serán efectuadas mediante la pasarela de pago de Openpay, de acuerdo con los términos, condiciones y políticas aplicables a dicha plataforma.</p>
						</div>
						<p>Andamios Ligeros no almacena directamente los datos completos de las tarjetas bancarias utilizados para realizar los pagos cuando estos son procesados mediante la plataforma correspondiente.</p>
						<p>La aprobación o rechazo de una transacción podrá depender de la institución bancaria emisora, del proveedor de servicios de pago o de los mecanismos de seguridad y prevención de fraude aplicables.</p>
					</section>
 
					<section class="tyc-section" id="confirmacion">
						<h2><span class="tyc-num">6.</span> Confirmación de compra</h2>
						<p>Una vez recibido y validado el pago, se procederá con la confirmación de la orden y, cuando corresponda, con el proceso de fabricación, preparación o liberación del producto.</p>
						<p>El cliente deberá proporcionar información correcta y suficiente para procesar su pedido, incluyendo datos de contacto, facturación y envío cuando sean requeridos.</p>
						<p>Cualquier error en los datos proporcionados por el cliente que genere retrasos, costos adicionales o imposibilidad de entrega será responsabilidad del cliente.</p>
					</section>
 
					<section class="tyc-section" id="produccion">
						<h2><span class="tyc-num">7.</span> Tiempos de producción y entrega</h2>
						<p>Los tiempos de producción comunicados al cliente son estimados y pueden variar dependiendo de la disponibilidad del producto, volumen de pedido, capacidad de producción, temporada, circunstancias operativas o situaciones ajenas al control de Andamios Ligeros.</p>
						<p>Una vez entregada la mercancía a la empresa transportista, los tiempos de tránsito dependerán directamente del proveedor logístico y de la cobertura correspondiente.</p>
						<p>Andamios Ligeros realizará los esfuerzos razonables para cumplir con los tiempos comunicados y mantendrá informado al cliente cuando exista alguna modificación relevante en su pedido.</p>
					</section>
 
					<section class="tyc-section" id="envios">
						<h2><span class="tyc-num">8.</span> Envíos</h2>
						<p>Los envíos se realizan mediante empresas de transporte con cobertura disponible para el destino indicado por el cliente.</p>
						<p>El costo de envío será informado antes de confirmar la compra cuando no se encuentre incluido en el precio publicado.</p>
						<p>Una vez entregada la mercancía a la empresa transportista, el cliente podrá recibir información de seguimiento cuando el servicio contratado lo permita.</p>
						<p>Los retrasos ocasionados por causas atribuibles a la empresa transportista, condiciones climáticas, bloqueos, accidentes, situaciones de fuerza mayor u otras circunstancias fuera del control directo de Andamios Ligeros podrán modificar los tiempos estimados de entrega.</p>
					</section>
 
					<section class="tyc-section" id="inspeccion">
						<h2><span class="tyc-num">9.</span> Inspección de la mercancía</h2>
						<p>El cliente deberá revisar la mercancía al momento de recibirla y, en caso de detectar daños visibles ocasionados durante el transporte, deberá documentarlos y reportarlos oportunamente conforme al procedimiento indicado por Andamios Ligeros y/o la empresa transportista.</p>
						<p>La documentación mediante fotografías o videos podrá ser solicitada para facilitar cualquier proceso de aclaración o reclamación.</p>
					</section>
 
					<section class="tyc-section" id="cancelaciones">
						<h2><span class="tyc-num">10.</span> Cancelaciones y devoluciones</h2>
						<p>Las cancelaciones y devoluciones estarán sujetas a las condiciones establecidas en las políticas correspondientes de Andamios Ligeros y a la legislación aplicable.</p>
						<p>Cuando un producto haya sido fabricado especialmente bajo especificaciones particulares del cliente, podrán existir condiciones especiales de cancelación o devolución, las cuales serán informadas previamente cuando correspondan.</p>
						<p>Para conocer las condiciones específicas aplicables, el cliente deberá consultar nuestra Política de Cancelaciones o comunicarse con nuestro equipo de atención.</p>
					</section>
 
					<section class="tyc-section" id="garantias">
						<h2><span class="tyc-num">11.</span> Garantías</h2>
						<p>Los productos comercializados por Andamios Ligeros cuentan con las garantías que correspondan de acuerdo con el producto adquirido y las condiciones aplicables.</p>
						<p>La garantía no cubrirá daños ocasionados por uso incorrecto, modificaciones no autorizadas, instalación inadecuada, sobrecarga, accidentes, desgaste normal, negligencia o cualquier utilización distinta a las especificaciones técnicas del producto.</p>
					</section>
 
					<section class="tyc-section" id="uso">
						<h2><span class="tyc-num">12.</span> Uso adecuado de los productos</h2>
						<p>El cliente es responsable de utilizar los productos de acuerdo con sus fichas técnicas, instrucciones, capacidades de carga, recomendaciones de seguridad y normativa aplicable.</p>
						<p>Los andamios y equipos para trabajos en altura deberán utilizarse únicamente para los fines para los cuales fueron diseñados.</p>
						<p>Es responsabilidad del usuario determinar las condiciones específicas de seguridad necesarias para cada proyecto y operación.</p>
					</section>
 
					<section class="tyc-section" id="propiedad">
						<h2><span class="tyc-num">13.</span> Propiedad intelectual</h2>
						<p>Todos los contenidos publicados en andamiosligeros.com, incluyendo textos, fotografías, imágenes, diseños, logotipos, fichas técnicas, gráficos, videos, marcas y demás materiales, son propiedad de Andamios Ligeros o se utilizan con las autorizaciones correspondientes.</p>
						<p>Queda prohibida la reproducción, distribución, modificación o utilización comercial de dichos contenidos sin autorización previa y por escrito.</p>
					</section>
 
					<section class="tyc-section" id="modificaciones">
						<h2><span class="tyc-num">14.</span> Modificaciones</h2>
						<p>Andamios Ligeros podrá modificar, actualizar o complementar los presentes Términos y Condiciones cuando sea necesario para adecuarlos a cambios operativos, comerciales, legales o tecnológicos.</p>
						<p>Las modificaciones serán publicadas en este sitio web y entrarán en vigor a partir de su publicación, salvo que se indique expresamente una fecha distinta.</p>
					</section>
 
					<section class="tyc-section" id="aceptacion">
						<h2><span class="tyc-num">15.</span> Aceptación</h2>
						<p>El uso del sitio web, así como la realización de una compra a través de andamiosligeros.com, implica que el usuario manifiesta haber leído y comprendido los presentes Términos y Condiciones y acepta sujetarse a ellos en lo que resulte aplicable.</p>
						<p>Para cualquier duda relacionada con estos términos, productos, pedidos o condiciones comerciales, el usuario podrá comunicarse con nuestro equipo de atención a través de los medios de contacto publicados en el sitio web.</p>
 
						<div class="tyc-contact">
							<strong>Andamios Ligeros</strong>
							Correo electrónico: <a href="mailto:ventas@andamiosligeros.com">ventas@andamiosligeros.com</a><br>
							Sitio web: <a href="https://andamiosligeros.com">andamiosligeros.com</a>
						</div>
					</section>
 
				</article>
			</div>
		</div>
	</main>
@stop
@section('js')
@stop
