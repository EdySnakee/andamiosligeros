<?php 
use App\ItemFiles;
$titulo = "Andamios Ligeros";
$host = "andamiosligeros.com";
$descripcion = "El mejor andamio de México, Andamio Galvanizado, 50% más ligero, misma resistencia. Ahorra tiempo y esfuerzo en el armado y traslado haciendo más fácil el trabajo.";


?>

<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">
	<channel>
	  <title><?php echo $titulo; ?></title>
	   <link>https://<?php echo $host; ?></link>
	   <description><![CDATA[<?php echo $descripcion; ?>]]></description>
		@foreach ($Ptienda as $item_producto)
			<?php 
			
            if ($item_producto->categoria == 'vallas'){
                $categorias = 'Economía e industria > Equipo de protección para el trabajo';
                $customlabel = 'Vallas';
            }
			?>
			<item>
				<g:id>{{$item_producto->id_product}}</g:id>
				<g:title><![CDATA[<?php echo $item_producto->post_titulo; ?>]]></g:title>
				<g:description><![CDATA[<?php echo $item_producto->descripcion_corta; ?>]]></g:description>
				<g:google_product_category><![CDATA[<?php echo $categorias; ?>]]></g:google_product_category>
				<g:product_type><![CDATA[<?php echo $categorias; ?>]]></g:product_type>
				<g:link>https://<?php echo $host; ?>/tienda/<?php echo $item_producto->post_url; ?></g:link>
				<g:image_link><?php echo $item_producto->imagen_portada; ?></g:image_link>
					<?php 
					$img_productos = ItemFiles::where('id_product', $item_producto->id_product)->where("file_tipo", "galeria")->get();
					?>
					@foreach ($img_productos as $item_image)
						<g:additional_image_link><?php echo $item_image->file_url; ?></g:additional_image_link>
					@endforeach
				<g:condition>new</g:condition>
				<g:availability>in_stock</g:availability>
				@if (!empty($item_producto->precio2) and $item_producto->precio2 != 0.00)
				<g:price><?php echo number_format($item_producto->precio, 2, '.', ''); ?> MXN</g:price>
				<g:sale_price><?php echo number_format($item_producto->precio2, 2, '.', ''); ?> MXN</g:sale_price>
				@else
				<g:price><?php echo number_format($item_producto->precio, 2, '.', ''); ?> MXN</g:price>
				@endif
				
				<g:brand>Andamios Ligeros</g:brand>
				<g:mpn>VA-<?php echo $item_producto->id_product ;?></g:mpn>
				<g:custom_label_0><?php echo $customlabel; ?></g:custom_label_0>
				<g:shipping>
					<g:country>MEX</g:country>
					<g:price>250.00 MXN</g:price>
				</g:shipping>
		    </item>
		@endforeach
	</channel>
</rss>
