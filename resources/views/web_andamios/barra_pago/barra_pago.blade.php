
<div class="detallepago">
	
	<div class="txt-pago text-center">
		<a href="#" id="cerrar-pago" data-accion="close"><i class="fa fa-times" aria-hidden="true"></i></a>
		
		<div class="cont-f-pasarela">
			@if(!empty($img_barra_pago))
			<div class="col-md">
				<img class="img-pasarela" src="{{url('web/prom/')}}/{{$img_barra_pago}}" alt="">
			</div>
			@endif
			
			<div class="cont-contacto col-md">
				<p><small><b>DATOS DE CONTACTO Y ENVIO</b></small></p>
				<div class="form-contacto">
					<div class="cont-flex">
						<div class="col6">
							<input type="text" placeholder="Nombre Completo *" class="form-c" id="nombre_c">
						</div>
						<div class="col6">
							<input type="tel" placeholder="Teléfono de Contácto *" class="form-c" id="numero_c">
						</div>
					</div>
					<div class="cont-flex">
						<div class="col12">
							<input type="email" placeholder="Correo electrónico *" class="form-c" id="email_c">
						</div>
					</div>
					<div class="cont-flex">
						<div class="col12">
							<input type="text" placeholder="Dirección de entrega *" class="form-c" id="direccion_c">
						</div>
					</div>
				</div>
				<p><small><b>RESUMEN DE COMPRA</b></small></p>
				<div class="tabla-resumen">
					<table class="table-responsive table text-center" style="width:100%">
						<tbody>
							<tr class="fila-sin-bordes">
								<td class="text-left">
									<p>
										<small>
											{{$nombre_product}}
										</small>
									</p>
									
								</td>
								<td class="text-left">
									{{-- <input class="form-promo" min="1" pattern="^[0-9]+" type="number" id="cantidad" value="{{$cantidad}}"> --}}
									<div class="quantity quantity-lg">
										<input type="button" class="minus text-color-hover-light bg-color-hover-primary border-color-hover-primary" value="-">
										<input readonly type="text" class="input-text qty text" title="Qty" value="{{$cantidad}}" id="cantidad" name="cantidad"  min="1" step="1">
										<input type="button" class="plus text-color-hover-light bg-color-hover-primary border-color-hover-primary" value="+">
									</div>
								</td>
								<td class="text-right">
									<p><small class="subtotal"><?php echo "$".number_format($costo_item, 2, '.', ',') ?></small></p>
								</td>
							</tr>
							<tr class="fila-sin-bordes">
								<td colspan="2"  class="text-right"><p><small>SUBTOTAL</small></p></td>
								<td class="text-right">
									<p><small class="subtotal"><?php echo "$".number_format($costo_item, 2, '.', ',') ?></small></p>
									<input type="hidden" name="subtotal" id="subtotal" value="{{$costo_item}}">
								</td>
							</tr>
							<tr class="fila-sin-bordes">
								<td colspan="2"  class="text-right"><p><small>ENVIO</small></p></td>
								<td class="text-right">
									<p><small class="envio"><?php echo "$".number_format($costo_envio, 2, '.', ',') ?></small></p>
									<input type="hidden" name="envio" id="envio" value="{{$costo_envio}}">
									<input type="hidden" name="envio" id="costo_envio" value="{{$costo_envio}}">
								</td>
							</tr>
							<tr id="fila-iva" class="fila-sin-bordes display-none">
								<td colspan="2"  class="text-right"><p><small>IVA 16%</small></p></td>
								<td class="text-right"><p><small class="iva"><?php echo "$".number_format(500, 2, '.', ',') ?></small></p></td>
							</tr>
							<tr class="fila-sin-bordes">
								<td colspan="2"  class="text-right"><p><b>TOTAL</b></p></td>
								<td class="text-right">
									<p><b class="total"><?php echo "$".number_format($costo_item + $costo_envio, 2, '.', ',') ?></b></p>
									<input type="hidden" name="total" id="total" value="{{$costo_item + $costo_envio}}">
								</td>
							</tr>
							<tr class="fila-sin-bordes">
								<td colspan="3"  class="text-right"><p><small><input type="checkbox" name="activa_iva" id="activa_iva"> <label for="activa_iva">Solicitar Factura</label></small></p></td>
							</tr>
							<tr class="fila-sin-bordes">
								<td colspan="3"  class="text-right"><button  type="button" class="btn btn-success" id="confirma_pedido"> Confirmar pedido</button> <button  type="button" class="btn display-none" id="edita_pedido"> Editar pedido</button></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			{{--
			<div class="info-resumen col-md">
				 <p>
					<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						 width="15px" viewBox="0 0 335.966 239.95" enable-background="new 0 0 335.966 239.95"
						 xml:space="preserve">
					<g>
						<path fill-rule="evenodd" clip-rule="evenodd" fill="#3F3F3F" d="M167.984,239.945c-43.237,0-86.475,0.005-129.711-0.002
							c-22.884-0.004-38.259-15.401-38.264-38.344C-0.002,147.115-0.003,92.631,0.01,38.147C0.015,15.386,15.365,0.005,38.055,0.004
							c86.599-0.006,173.199-0.006,259.797,0c22.674,0.001,38.094,15.414,38.101,38.111c0.015,54.609,0.019,109.218-0.002,163.827
							c-0.009,22.422-15.54,37.989-37.881,37.998C254.708,239.958,211.347,239.945,167.984,239.945z M24.002,96.12
							c0,1.549,0,2.892,0,4.234c0,33.731-0.003,67.462,0.001,101.193c0.001,10.124,4.239,14.398,14.301,14.398
							c86.452,0.006,172.903,0.006,259.354,0c10.003,0,14.299-4.348,14.3-14.438c0.005-33.731,0.002-67.463,0.002-101.194
							c0-1.339,0-2.678,0-4.194C215.928,96.12,120.27,96.12,24.002,96.12z M311.961,71.751c0-1.271,0-2.36,0-3.449
							c0-10.244,0.016-20.488-0.005-30.732c-0.019-9.095-4.515-13.621-13.547-13.621c-86.949-0.006-173.898-0.004-260.847-0.003
							c-0.625,0-1.25-0.012-1.874,0.009c-6.517,0.22-11.509,4.821-11.608,11.331c-0.181,11.864-0.03,23.732,0.008,35.599
							c0.001,0.317,0.304,0.634,0.423,0.867C120.276,71.751,215.929,71.751,311.961,71.751z"/>
						<path fill-rule="evenodd" clip-rule="evenodd" fill="#3F3F3F" d="M251.67,179.976c-7.732-0.002-15.466,0.046-23.198-0.015
							c-7.578-0.06-12.938-5.155-12.875-12.109c0.064-6.93,5.473-11.855,13.098-11.864c15.467-0.018,30.933-0.022,46.398,0.002
							c7.687,0.012,12.96,4.884,12.994,11.911c0.033,7.05-5.192,12.009-12.843,12.063C267.386,180.021,259.528,179.977,251.67,179.976z"
							/>
					</g>
					</svg>
					Paga con tu Tarjeta de Crédito</p> 
				<br>
			</div>
			--}}
		</div>
		<div class="cont-f-pasarela">
			<div class="info_mp">
			</div>
		</div>	
	</div>
</div>

