<?php 
	use App\DetalleCotizaciones;
	use App\Productos;
	use App\Cotizaciones;

	session_start();

	$detalle_cotizaciones = DetalleCotizaciones::where("id_cotizacion", $info_cotizacion->id_cotizacion)->get();
	//$descuento = $info_cotizacion->porcentaje_descuento;
	$cotiArray = json_decode(json_encode($detalle_cotizaciones), true);
	$num_coti = count($detalle_cotizaciones);
	$i = 0;
	$_SESSION['conceptos'] = [];
	while ($i <= $num_coti-1) {
		$item_det_coti = $cotiArray[$i++];
	    $info_producto = Productos::where("id_producto", $item_det_coti['id_producto'])->first();
	    $info_producto_array = json_decode(json_encode($info_producto), true);

	    //print_r($item_det_coti->nombre_producto);
	    if ($item_det_coti['tipo_cobro'] == "m2") {
	        $largo = $item_det_coti['largo'];
	        $alto = $item_det_coti['alto'];
	        $dimensiones = $largo * $alto;
	        //print_r($dimensiones);
	    }
	    if($item_det_coti['tipo_cobro'] == "fijo"){
	        $largo = 1;
	        $alto = 1;
	        $dimensiones = $largo * $alto;
	        //print_r($dimensiones);
	    }

	    $cantidad = $item_det_coti['cantidad'];
	    
	    $costo = $item_det_coti['precio_unit'];
	    //print_r($costo."<br>");
	    
	    $concepto = [
	        'id' => rand(111111,999999),
	        'tipo_cobro' => $item_det_coti['tipo_cobro'],
	        'cantidad' => $cantidad,
	        'nombre_producto' => $item_det_coti['nombre_producto'],
			'categoria' => $info_producto_array['categoria'],
	        'id_producto' => $item_det_coti['id_producto'],
	        'sku' => $info_producto_array["SKU"],
	        'largo' => $largo,
	        'alto' => $alto,
	        'costo' => $costo,
	        'dimensiones' => $dimensiones,
	        //'descuento' => $descuento,
	        'total' => $dimensiones * $costo * $cantidad
	    ];
	    
	    $_SESSION['conceptos'][] = $concepto; 
	}
	

	if (empty($info_cotizacion->iva) || (float)$info_cotizacion->iva == 0) {
	    $iva = "no";
	    $info_cotizacion->activa_iva = "false";
	} else {
	    $iva = "si";
	    $info_cotizacion->activa_iva = "true";
	}
	
	echo $tabla_actualizada = Cotizaciones::actualizaTabla((!empty($_SESSION['conceptos']))?$_SESSION['conceptos'] : [], $info_cotizacion, $accion);
?>